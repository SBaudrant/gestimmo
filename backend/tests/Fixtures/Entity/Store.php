<?php

namespace App\Tests\Fixtures\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ApiResource(
    operations: [
        new Get(),
        new Patch(
            normalizationContext: [
                'groups' => ['store:get'],
            ],
            denormalizationContext: [
                'groups' => ['store:update'],
            ],
        ),
    ],
)]
class Store
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

    #[ORM\OneToMany(mappedBy: 'store', targetEntity: Pet::class, orphanRemoval: true, cascade: ['persist'])]
    #[Groups([
        'store:get',
        'store:update',
    ])]
    private Collection $pets;

    public function __construct(string $name, Collection $pets)
    {
        $this->name = $name;
        $this->pets = $pets;
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

    /**
     * @return Collection<int, Pet>
     */
    public function getPets(): Collection
    {
        return $this->pets;
    }

    public function addPet(Pet $pet): self
    {
        if (!$this->pets->contains($pet)) {
            $this->pets->add($pet);
            $pet->setStore($this);
        }

        return $this;
    }

    public function removePet(Pet $pet): self
    {
        if ($this->pets->removeElement($pet)) {
            // set the owning side to null (unless already changed)
            if ($pet->getStore() === $this) {
                $pet->setStore(null);
            }
        }

        return $this;
    }
}
