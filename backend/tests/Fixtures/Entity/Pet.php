<?php

namespace App\Tests\Fixtures\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ApiResource]
class Pet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'store:get',
        'store:update',
    ])]
    private string $name;

    #[ORM\Column]
    #[Groups([
        'store:get',
        'store:update',
    ])]
    private int $age;

    #[ORM\ManyToOne(inversedBy: 'pets', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Store $store;

    public function __construct(string $name, int $age, Store $store)
    {
        $this->name = $name;
        $this->age = $age;
        $this->store = $store;
        $store->addPet($this);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getStore(): Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        $this->store = $store;

        return $this;
    }
}
