<?php

namespace App\Tests\Functionnal\User;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class UserLoginTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testValidLogin(): void
    {
        $client = self::createClient();
        $client->request('POST', '/users/login', [
            'json' => ['username' => 'admin@test.com', 'password' => 'pass'],
        ]);

        self::assertResponseIsSuccessful();
    }

    public function testInvalidCredentials(): void
    {
        $client = self::createClient();
        $client->request('POST', '/users/login', [
            'json' => ['username' => 'admin@test.com', 'password' => 'wrongpassword'],
        ]);

        self::assertResponseStatusCodeSame(401);
        self::assertJsonContains([
            'code' => 401,
            'message' => 'Identifiants invalides.',
        ]);
    }
}
