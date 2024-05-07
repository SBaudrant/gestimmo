<?php

namespace App\Tests\Functionnal\Normalizer;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use App\Tests\Fixtures\Entity\Pet;
use App\Tests\Fixtures\Entity\Store;
use Doctrine\Common\Collections\ArrayCollection;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class AllowPatchEmbeddedCollectionRelationNormalizerTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testPatchEmbeddedCollectionRelation(): void
    {
        $client = self::createClient();
        $user = static::getContainer()->get('doctrine')->getRepository(User::class)->findOneBy(['email' => 'admin@test.com']);
        $client->loginUser($user);

        $store = new Store('My store', new ArrayCollection());
        $mowgli = new Pet('Mowgli', 3, $store);
        $mogwai = new Pet('Mogwai', 4, $store);

        $doctrine = self::getContainer()->get('doctrine');
        assert($doctrine instanceof ManagerRegistry);
        $doctrine->getManager()->persist($store);
        $doctrine->getManager()->flush();

        $client->request('PATCH', sprintf('/stores/%s', $store->getId()), [
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
                'name' => 'Test',
                'pets' => [
                    sprintf('/pets/%s', $mowgli->getId()),
                    [
                        '@id' => sprintf('/pets/%s', $mogwai->getId()),
                        'age' => 5,
                    ],
                ],
            ],
        ]);

        self::assertResponseStatusCodeSame(200);

        self::getContainer()->get('doctrine')->getManager()->refresh($mogwai);
        self::getContainer()->get('doctrine')->getManager()->refresh($store);

        self::assertEquals(5, $mogwai->getAge());
        self::assertTrue($store->getPets()->contains($mogwai));
        self::assertTrue($store->getPets()->contains($mowgli));
    }
}
