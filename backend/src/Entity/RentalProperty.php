<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\RentalPropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(
            requirements: ['id' => '\\d+'],
            normalizationContext: ['groups' => ['rental_property:get']],
            security: 'is_granted(\'GET_ITEM\', object)',
        ),
        new Patch(
            normalizationContext: ['groups' => ['rental_property:get']],
            denormalizationContext: ['groups' => ['rental_property:update']],
            security: 'is_granted(\'PUT_ITEM\', object)',
            securityPostDenormalize: 'object !== user or object.getRole() === previous_object.getRole()',
        ),
        new Delete(
            security: 'is_granted(\'DELETE_ITEM\', object)',
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['rental_property:getAll']],
            security: 'is_granted(\'GET_COLLECTION\', object)',
        ),
        new Post(
            normalizationContext: ['groups' => ['rental_property:get']],
            denormalizationContext: ['groups' => ['rental_property:create']],
            securityPostDenormalize: 'is_granted(\'POST_COLLECTION\', object)',
        )
    ],
)]

#[ORM\Entity(repositoryClass: RentalPropertyRepository::class)]
/**
 * Rental property entity is the appartement or the house used to be rented.
 */
class RentalProperty
{
    #[ORM\Column(type: Types::BIGINT)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[Groups([
        'rental_property:get',
        'rental_property:getAll',
        'rental_property:create',
        'rental_property:update',
        'user:get'
    ])]
    private ?int $id = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'rentalProperties')]
    #[Groups([
        'rental_property:get',
        'rental_property:getAll',
    ])]
    private Collection $owners;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'rental_property:get',
        'rental_property:getAll',
        'rental_property:create',
        'rental_property:update',
    ])]
    private ?Address $address = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Groups([
        'rental_property:get',
        'rental_property:getAll',
        'rental_property:update',
    ])]
    private Collection $currentLeases;

    /**
     * @var Collection<int, Lease>
     */
    #[ORM\OneToMany(mappedBy: 'rentalProperty', targetEntity: Lease::class)]
    #[Groups([
        'rental_property:get',
        'rental_property:getAll',
        'rental_property:update',
        'user:get'
    ])]
    private Collection $leases;

    public function __construct()
    {
        $this->owners = new ArrayCollection();
        $this->currentLeases = new ArrayCollection();
        $this->leases = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getOwners(): Collection
    {
        return $this->owners;
    }

    public function addOwner(User $owner): self
    {
        if (!$this->owners->contains($owner)) {
            $this->owners->add($owner);
        }

        return $this;
    }

    public function removeOwner(User $owner): self
    {
        $this->owners->removeElement($owner);

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, Lease>
     */
    public function getCurrentLeases(): ?Collection
    {
        return $this->currentLeases;
    }

    public function addCurrentLease(Lease $lease): self
    {
        if (!$this->currentLeases->contains($lease)) {
            $this->currentLeases->add($lease);
            $lease->setRentalProperty($this);
        }

        return $this;
    }

    public function removeCurrentLease(Lease $lease): self
    {
        if ($this->currentLeases->removeElement($lease)) {
            // set the owning side to null (unless already changed)
            if ($lease->getRentalProperty() === $this) {
                $lease->setRentalProperty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Lease>
     */
    public function getLeases(): Collection
    {
        return $this->leases;
    }

    public function addLease(Lease $lease): self
    {
        if (!$this->leases->contains($lease)) {
            $this->leases->add($lease);
            $lease->setRentalProperty($this);
        }

        return $this;
    }

    public function removeLease(Lease $lease): self
    {
        if ($this->leases->removeElement($lease)) {
            // set the owning side to null (unless already changed)
            if ($lease->getRentalProperty() === $this) {
                $lease->setRentalProperty(null);
            }
        }

        return $this;
    }
}
