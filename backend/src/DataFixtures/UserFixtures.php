<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;

class UserFixtures extends Fixture
{
    public const ADMIN_USER_REFERENCE = 'admin';
    public const USERS_REFERENCE = 'users';

    
    /**
     * Value is equivalent to 'pass'.
     * @var string USER_PASSWORD_HASH
     */
    public const USER_PASSWORD_HASH = '$2y$13$S88eMZ.tUMhfxcSRq1TCjeD5FW3wy28woVpfo8gg9ZZx4kpRgBUpq';

    private int $user_count = 1;

    private FakerGenerator $faker;



    public function load(ObjectManager $manager)
    {
        $this->faker = FakerFactory::create('fr_FR');

        $users = [];

        $admin = $this->generateAdminUser();
        $manager->persist($admin);

        $users[] = $admin;

        for($i = 0; $i < 20; $i++){
            $user = $this->generateUser();
            $manager->persist($user);
            $users[] = $user;
        }

        $manager->flush();

        // Other fixtures can get this objects using the UserFixtures::ADMIN_USER_REFERENCE UserFixtures::USERS_REFERENCE constant.
        $this->addReference(self::ADMIN_USER_REFERENCE, $admin);
        $this->addReference(self::USERS_REFERENCE, $admin);


    }

    /**
     * Function will return a new user. It will faker datas for missing fields. 
     *
     * @param string|null $firsname
     * @param string|null $lastname
     * @param string|null $email
     * @param Role $role 
     * @param string $password
     * @return User
     */
    private function generateUser(?string $firsname = null, ?string $lastname= null, ?string $email = null, Role $role = Role::USER, string $password = self::USER_PASSWORD_HASH): User
    {
        $user = (new User())
            ->setFirstname($firsname ?? $this->faker->firstName())
            ->setLastname($lastname ?? $this->faker->lastName())
            ->setEmail($email ?? 'user_' . $this->user_count . '@test.com')
            ->setPassword($password ?? self::USER_PASSWORD_HASH)
            ->setRole($role ?? Role::USER)
        ;

        $this->user_count++;

        return $user;
    }

    /**
     * Create the admin of the site.
     *
     * @return User
     */
    private function generateAdminUser(): User
    {
        return $this->generateUser('admin', 'admin', 'admin@test.com', Role::ADMIN);
    }
}