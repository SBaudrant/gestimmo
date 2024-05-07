<?php

namespace App\Tests\Functionnal\User;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\MailerAssertionsTrait;

class PatchUserTest extends ApiTestCase
{
    use RefreshDatabaseTrait;
    use MailerAssertionsTrait;

    public function testUserCanPatch(): void
    {
        $client = self::createClient();
        $user = static::getContainer()->get('doctrine')->getRepository(User::class)->findOneBy(['email' => 'admin@test.com']);
        $client->loginUser($user);

        $client->request('PATCH', sprintf('/users/%s', $user->getId()), [
            'json' => [
                'firstName' => 'Updated',
            ],
        ]);

        self::assertResponseStatusCodeSame(200);
        self::assertJsonContains([
            'firstName' => 'Updated',
            'lastName' => 'Administrateur',
        ]);

        self::getContainer()->get('doctrine')->getManager()->refresh($user);
        self::assertEquals('Updated', $user->getFirstName());
        self::assertEquals('Administrateur', $user->getLastName());
    }
}
