<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Enum\LocationTypeEnum;
use App\Repository\LeaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(
            requirements: ['id' => '\\d+'],
            normalizationContext: ['groups' => ['tenant:get']],
            security: 'is_granted(\'GET_ITEM\', object)',
        ),
        new Patch(
            normalizationContext: ['groups' => ['tenant:get']],
            denormalizationContext: ['groups' => ['tenant:update']],
            security: 'is_granted(\'PUT_ITEM\', object)',
            securityPostDenormalize: 'object !== user or object.getRole() === previous_object.getRole()',
        ),
        new Delete(
            security: 'is_granted(\'DELETE_ITEM\', object)',
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['tenant:getAll']],
            security: 'is_granted(\'GET_COLLECTION\', object)',
        ),
        new Post(
            normalizationContext: ['groups' => ['tenant:get']],
            denormalizationContext: ['groups' => ['tenant:create']],
            securityPostDenormalize: 'is_granted(\'POST_COLLECTION\', object)',
        )
    ],
)]
#[ORM\Entity(repositoryClass: LeaseRepository::class)]
/**
 * Lease entity is the rent contract made for a period.
 */
class Lease
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'lease:get',
        'lease:getAll',
        'lease:create',
        'lease:update',
        'rental_property:get',
        'rental_property:getAll',
    ])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups([
        'lease:get',
        'lease:getAll',
        'lease:create',
        'lease:update',
        'rental_property:get',
        'rental_property:getAll',
    ])]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups([
        'lease:get',
        'lease:getAll',
        'lease:create',
        'lease:update',
        'rental_property:get',
        'rental_property:getAll',
    ])]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(type: "integer", enumType: LocationTypeEnum::class)]
    #[Groups([
        'lease:get',
        'lease:getAll',
        'lease:create',
        'lease:update',
        'rental_property:get',
        'rental_property:getAll',
    ])]
    private ?LocationTypeEnum $locationType = LocationTypeEnum::UNFURNISHED;

    #[ORM\ManyToOne(inversedBy: 'leases')]
    #[ORM\JoinColumn(nullable: false)]
    private ?RentalProperty $rentalProperty = null;

    /**
     * @var Collection<int, Tenant>
     */
    #[ORM\ManyToMany(targetEntity: Tenant::class, mappedBy: 'Lease', cascade: ["persist", "remove"])]
    #[Groups([
        'lease:get',
        'lease:getAll',
        'lease:create',
        'lease:update',
        'rental_property:get',
        'rental_property:getAll',
    ])]
    private Collection $tenants;

    #[ORM\Column]
    #[Groups([
        'lease:get',
        'lease:getAll',
        'lease:create',
        'lease:update',
        'rental_property:get',
        'rental_property:getAll',
    ])]
    private ?int $paymentDay = null;

    #[ORM\Column]
    private ?float $rentBase = null;

    #[ORM\Column]
    private ?float $rentFees = null;

    /**
     * @var Collection<int, RentPayment>
     */
    #[ORM\OneToMany(mappedBy: 'lease', targetEntity: RentPayment::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $rentPayments;

    public function __construct()
    {
        $this->tenants = new ArrayCollection();
        $this->rentPayments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get the value of locationType
     */
    public function getLocationType(): LocationTypeEnum
    {
        return $this->locationType;
    }

    /**
     * Set the value of locationType
     *
     * @return  self
     */
    public function setLocationType(LocationTypeEnum $locationType)
    {
        $this->locationType = $locationType;

        return $this;
    }

    public function getRentalProperty(): ?RentalProperty
    {
        return $this->rentalProperty;
    }

    public function setRentalProperty(?RentalProperty $rentalProperty): static
    {
        $this->rentalProperty = $rentalProperty;

        return $this;
    }

    /**
     * @return Collection<int, Tenant>
     */
    public function getTenants(): Collection
    {
        return $this->tenants;
    }

    public function addTenant(Tenant $tenant): static
    {
        if (!$this->tenants->contains($tenant)) {
            $this->tenants->add($tenant);
            $tenant->addLease($this);
        }

        return $this;
    }

    public function removeTenant(Tenant $tenant): static
    {
        if ($this->tenants->removeElement($tenant)) {
            $tenant->removeLease($this);
        }

        return $this;
    }

    public function getPaymentDay(): ?int
    {
        return $this->paymentDay;
    }

    public function setPaymentDay(int $paymentDay): static
    {
        $this->paymentDay = $paymentDay;

        return $this;
    }

    public function getRentBase(): ?float
    {
        return $this->rentBase;
    }

    public function setRentBase(float $rentBase): static
    {
        $this->rentBase = $rentBase;

        return $this;
    }

    public function getRentFees(): ?float
    {
        return $this->rentFees;
    }

    public function setRentFees(float $rentFees): static
    {
        $this->rentFees = $rentFees;

        return $this;
    }

    /**
     * @return Collection<int, RentPayment>
     */
    public function getRentPayments(): Collection
    {
        return $this->rentPayments;
    }

    public function addRentPayment(RentPayment $rentPayment): static
    {
        if (!$this->rentPayments->contains($rentPayment)) {
            $this->rentPayments->add($rentPayment);
            $rentPayment->setLease($this);
        }

        return $this;
    }

    public function removeRentPayment(RentPayment $rentPayment): static
    {
        if ($this->rentPayments->removeElement($rentPayment)) {
            // set the owning side to null (unless already changed)
            if ($rentPayment->getLease() === $this) {
                $rentPayment->setLease(null);
            }
        }

        return $this;
    }
}
