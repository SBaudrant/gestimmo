<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Enum\LocationTypeEnum;
use App\Repository\UserRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\User;
use App\Entity\RentalProperty;
use App\Entity\Lease;
use App\Entity\Tenant;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;

class RentalPropertyFixtures extends Fixture implements DependentFixtureInterface
{

    private FakerGenerator $faker;

    public function load(ObjectManager $manager)
    {

        $this->faker = FakerFactory::create('fr_FR');

        // Get generated users.
        $userRepository = $manager->getRepository(User::class);
        $users = $userRepository->findAll();

        // Générer les propriétés locatives, baux et locataires
        foreach ($users as $user) {
            $numProperties = rand(1, 4);
            $globalPropertyCount = 0;

            echo "Generate $numProperties rental properties for {$user->getFirstname()} {$user->getLastname()}\n";

            for ($i = 1; $i <= $numProperties; $i++) {
                echo "    Generation appartment N°$i\n";
                
                $globalPropertyCount++;

                $rentalProperty = (new RentalProperty())
                    ->setAddress($this->generateAddress())
                    ->setLabel("Appartement $globalPropertyCount")
                    ->setProposedPaymentDay(rand(1, 28))
                    ->setProposedRentFees(rand(3, 30) * 5)
                    ->setProposedRentBase(rand(60, 80) * 5)
                    ->addOwner($user)
                ;

                $manager->persist($rentalProperty);

                $locationType = $this->faker->randomElement(LocationTypeEnum::class);

                // 85% to be Single Tenant or couple Tenant.
                $isSharedLease = $this->faker->optional(0.85, true)->boolean(false);
                $isCouple = null;

                if (!$isSharedLease) {
                    // 45% to be a lease to a couple. 65% to be to single person. 
                    $isCouple = $this->faker->optional(0.65, true)->boolean(false);
                }

                $firstLeaseStartDate = $this->faker->dateTimeThisYear();

                $firstLeaseEndDate = (new \DateTime($firstLeaseStartDate->format('Y-m-d')));

                if ($locationType == LocationTypeEnum::FURNISHED) {
                    $firstLeaseEndDate->modify('+1 year');
                } else {
                    $firstLeaseEndDate->modify('+3 years');
                }

                $paymentDay = rand(1, 28);
                $rentFees = rand(3, 30) * 5;
                $rentBase = rand(60, 80) * 5;

                echo "        Generation of the actual lease for Rental property : {$rentalProperty->getLabel()}\n";
                $lease = $this->generateLease($firstLeaseStartDate, $firstLeaseEndDate, $paymentDay, $rentFees, $rentBase, $locationType);

                if ($isCouple) {
                    $lease->addTenant($this->generateTenant());
                }

                $rentalProperty->addLease($lease);

                $manager->persist($lease);

                $olderLeases = rand(0, 3);

                echo "        Generation of $olderLeases older lease(s) for Rental property : {$rentalProperty->getLabel()}\n";
                $lastStartDate = $firstLeaseStartDate;

                for ($j = 0; $j < $olderLeases; $j++) {

                    $endDate = $this->faker->dateTimeInInterval($lastStartDate, '-2 months');
                    
                    if ($locationType === LocationTypeEnum::FURNISHED) {
                        $leaseDuration = $this->faker->numberBetween(6, 12);
                    } else {
                        $leaseDuration = $this->faker->numberBetween(12, 36);
                    }

                    $startDate = (new \DateTime($endDate->format('Y-m-d')))->modify("-$leaseDuration months");

                    $lease = $this->generateLease($startDate, $endDate, $paymentDay, $rentFees, $rentBase, $locationType);
                    $rentalProperty->addLease($lease);

                    $manager->persist($lease);

                    $lastStartDate = $startDate;
                }

            }
        }

        $manager->flush();
    }

    private function generateAddress()
    {
        // Implémentez votre générateur d'adresse ici
        return (new Address())
            ->setCity($this->faker->city())
            ->setPostalCode($this->faker->postcode())
            ->setStreet($this->faker->streetAddress())
        ;
    }

    private function generateTenant()
    {
        $tenant = (new Tenant())
            ->setFirstName($this->faker->firstName())
            ->setLastName($this->faker->lastName())
            ->setPhone($this->faker->phoneNumber())
            ->setEmail($this->faker->email())
        ;

        return $tenant;
    }

    /**
     * Generate a 
     *
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param integer $paymentDay
     * @param float $rentFees
     * @param float $rentBase
     * @param LocationTypeEnum $locationType
     * @return Lease
     */
    private function generateLease(\DateTime $startDate, \DateTime $endDate, int $paymentDay, float $rentFees, float $rentBase, LocationTypeEnum $locationType = LocationTypeEnum::UNFURNISHED): Lease
    {
        return (new Lease())
            ->setStartDate($startDate)
            ->setEndDate($endDate)
            ->setPaymentDay($paymentDay)
            ->setRentFees($rentFees)
            ->setRentBase($rentBase)
            ->setLocationType($locationType) // Modifiez si nécessaire
            ->addTenant($this->generateTenant())
        ;
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
