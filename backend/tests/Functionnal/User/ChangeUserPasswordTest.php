<?php

namespace App\Tests\Functionnal\User;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class ChangeUserPasswordTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testChangeUserPassword(): void
    {
        $client = self::createClient();
        $user = static::getContainer()->get('doctrine')->getRepository(User::class)->findOneBy(['email' => 'user@test.com']);
        $client->loginUser($user);

        $client->request('PATCH', sprintf('/users/%s/change_password', $user->getId()), [
            'json' => [
                'oldPassword' => 'pass',
                'newPassword' => 'aze123##',
            ],
        ]);

        self::assertResponseIsSuccessful();
    }
}
