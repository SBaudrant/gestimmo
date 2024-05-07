<?php

namespace App\Tests\Functionnal\User;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use App\Enum\Role;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\MailerAssertionsTrait;

class CreateUserTest extends ApiTestCase
{
    use RefreshDatabaseTrait;
    use MailerAssertionsTrait;

    public function testMailIsSent(): void
    {
        $client = self::createClient();
        $user = static::getContainer()->get('doctrine')->getRepository(User::class)->findOneBy(['email' => 'admin@test.com']);
        $client->loginUser($user);

        $client->request('POST', '/users', [
            'json' => [
                'email' => 'new_user@test.com',
                'firstName' => 'John',
                'lastName' => 'Doe',
                'role' => Role::USER->value,
                'active' => true,
            ],
        ]);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(201);

        self::assertEmailCount(1);
    }

    public function testUserCantCreate(): void
    {
        $client = self::createClient();
        $user = static::getContainer()->get('doctrine')->getRepository(User::class)->findOneBy(['email' => 'user@test.com']);
        $client->loginUser($user);

        $client->request('POST', '/users', [
            'json' => [
                'email' => 'new_user@test.com',
                'firstName' => 'John',
                'lastName' => 'Doe',
                'role' => Role::USER->value,
                'active' => true,
            ],
        ]);

        self::assertResponseStatusCodeSame(403);
    }

    public function testInvalidPayload(): void
    {
        $client = self::createClient();
        $user = static::getContainer()->get('doctrine')->getRepository(User::class)->findOneBy(['email' => 'admin@test.com']);
        $client->loginUser($user);

        $client->request('POST', '/users', [
            'json' => [
                'email' => 'new_user',
                'firstName' => '',
                'lastName' => '',
                'role' => Role::USER->value,
            ],
        ]);

        self::assertResponseStatusCodeSame(422);
        self::assertJsonContains([
            'violations' => [
                ['propertyPath' => 'email', 'message' => 'Cette valeur n\'est pas une adresse email valide.'],
                ['propertyPath' => 'firstName', 'message' => 'Cette valeur ne doit pas être vide.'],
                ['propertyPath' => 'lastName', 'message' => 'Cette valeur ne doit pas être vide.'],
            ],
        ]);
    }

    public function testInvalidPropertyType(): void
    {
        $client = self::createClient();
        $user = static::getContainer()->get('doctrine')->getRepository(User::class)->findOneBy(['email' => 'admin@test.com']);
        $client->loginUser($user);

        $client->request('POST', '/users', [
            'json' => [
                'lastName' => null,
            ],
        ]);

        self::assertResponseStatusCodeSame(422);
        self::assertJsonContains([
            'violations' => [
                ['propertyPath' => 'lastName', 'message' => 'Cette valeur doit être de type string.'],
            ],
        ]);
    }

    public function testEmailIsUnique(): void
    {
        $client = self::createClient();
        $user = static::getContainer()->get('doctrine')->getRepository(User::class)->findOneBy(['email' => 'admin@test.com']);
        $client->loginUser($user);

        $client->request('POST', '/users', [
            'json' => [
                'email' => 'admin@test.com',
                'firstName' => 'John',
                'lastName' => 'Doe',
                'role' => Role::USER->value,
                'active' => true,
            ],
        ]);

        self::assertResponseStatusCodeSame(422);
        self::assertJsonContains([
            'violations' => [
                ['propertyPath' => 'email', 'message' => 'Cette valeur est déjà utilisée.'],
            ],
        ]);
    }
}
