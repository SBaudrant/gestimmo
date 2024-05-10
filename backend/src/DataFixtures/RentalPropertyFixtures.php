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
            echo "Generate $numProperties for {$user->getFirstname()} {$user->getLastname()}\n"; 
            for ($i = 0; $i < $numProperties; $i++) {

                $property = (new RentalProperty())
                    ->setAddress($this->generateAddress())
                    ->setProposedPaymentDay(rand(1, 28))
                    ->setProposedRentFees(rand(3, 30) * 5)
                    ->setProposedRentBase(rand(60, 80) * 5)
                    ->addOwner($user)
                ;

                $manager->persist($property);

                $locationType = $this->faker->randomElement(LocationTypeEnum::class);

                $numberLeases = rand(1, 4);

                // 85% to be Single Tenant or couple Tenant.
                $isSharedLease = $this->faker->optional(0.85, true)->boolean(false);
                $isCouple = null;

                if (!$isSharedLease) {
                    // 45% to be a lease to a couple. 65% to be to single person. 
                    $isCouple = $this->faker->optional(0.65, true)->boolean(false);
                }

                $firstLeaseStartDate = $this->faker->dateTimeThisYear();

                if ($locationType == LocationTypeEnum::FURNISHED) {
                    $firstLeaseEndDate = $firstLeaseStartDate->modify('+1 year');
                } else {
                    $firstLeaseEndDate = $firstLeaseStartDate->modify('+3 years');
                }

                $paymentDay = rand(1, 28);
                $rentFees = rand(3, 30) * 5;
                $rentBase = rand(60, 80) * 5;

                $lease = (new Lease())
                    ->setStartDate($firstLeaseStartDate)
                    ->setEndDate($firstLeaseEndDate)
                    ->setPaymentDay($paymentDay)
                    ->setRentFees($rentFees)
                    ->setRentBase($rentBase)
                    ->setLocationType($locationType) // Modifiez si nécessaire
                    ->addTenant($this->generateTenant())
                ;

                if ($isCouple) {
                    $lease->addTenant($this->generateTenant());
                }

                $property->addLease($lease);

                $manager->persist($lease);

                for ($i = 0; $i < $numberLeases - 1; $i++) {

                }


            }
        }

        $manager->flush();
    }

    private function generateAddress()
    {
        // Implémentez votre générateur d'adresse ici
        return (new Address())
            ->setCity($this->faker->city)
            ->setPostalCode($this->faker->postcode)
            ->setStreet($this->faker->streetAddress)
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

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
