<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\AddressRepository;


#[ORM\Entity(repositoryClass: AddressRepository::class)]
/**
 * Address entity.
 */
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'rental_property:get',
        'rental_property:getAll',
        'rental_property:create',
        'rental_property:update',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'rental_property:get',
        'rental_property:getAll',
        'rental_property:create',
        'rental_property:update',
    ])]
    private ?string $street = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'rental_property:get',
        'rental_property:getAll',
        'rental_property:create',
        'rental_property:update',
    ])]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'rental_property:get',
        'rental_property:getAll',
        'rental_property:create',
        'rental_property:update',
    ])]
    private ?string $postalCode = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }
}
