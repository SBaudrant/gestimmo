<?php

namespace App\Tests\Functionnal\User;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class GetUserTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testGetCollectionWithAdmin(): void
    {
        $client = static::createClient();
        $user = static::getContainer()->get('doctrine')->getRepository(User::class)->findOneBy(['email' => 'admin@test.com']);
        $client->loginUser($user);

        $response = $client->request('GET', '/users');

        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        self::assertJsonContains([
            '@context' => '/contexts/User',
            '@id' => '/users',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 110,
            'hydra:view' => [
                '@id' => '/users?page=1',
                '@type' => 'hydra:PartialCollectionView',
                'hydra:first' => '/users?page=1',
                'hydra:last' => '/users?page=4',
                'hydra:next' => '/users?page=2',
            ],
        ]);

        $this->assertCount(30, $response->toArray()['hydra:member']);
    }

    public function testGetCollectionWithUser(): void
    {
        $client = static::createClient();
        $user = static::getContainer()->get('doctrine')->getRepository(User::class)->findOneBy(['email' => 'user@test.com']);
        $client->loginUser($user);

        $client->request('GET', '/users');

        self::assertResponseStatusCodeSame(403);
    }

    public function testRolesSerializer(): void
    {
        $client = static::createClient();
        $user = static::getContainer()->get('doctrine')->getRepository(User::class)->findOneBy(['email' => 'admin@test.com']);
        $client->loginUser($user);

        $client->request('GET', sprintf('/users/%s', $user->getId()));

        self::assertResponseIsSuccessful();
        self::assertJsonContains(['roles' => ['ROLE_ADMIN', 'ROLE_USER']]);
    }
}
