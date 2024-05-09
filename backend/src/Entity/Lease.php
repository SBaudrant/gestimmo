<?php

namespace App\Entity;

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
    ])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups([
        'lease:get',
        'lease:getAll',
        'lease:create',
        'lease:update',
    ])]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups([
        'lease:get',
        'lease:getAll',
        'lease:create',
        'lease:update',
    ])]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Groups([
        'lease:get',
        'lease:getAll',
        'lease:create',
        'lease:update',
    ])]
    private ?LocationTypeEnum $locationType = null;

    #[ORM\ManyToOne(inversedBy: 'leases')]
    #[ORM\JoinColumn(nullable: false)]
    private ?RentalProperty $rentalProperty = null;

    /**
     * @var Collection<int, Tenant>
     */
    #[ORM\ManyToMany(targetEntity: Tenant::class, mappedBy: 'Lease')]
    #[Groups([
        'lease:get',
        'lease:getAll',
        'lease:create',
        'lease:update',
    ])]
    private Collection $tenants;

    #[ORM\Column]
    #[Groups([
        'lease:get',
        'lease:getAll',
        'lease:create',
        'lease:update',
    ])]
    private ?int $paymentDay = null;

    public function __construct()
    {
        $this->tenants = new ArrayCollection();
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
    public function getLocationType()
    {
        return $this->locationType;
    }

    /**
     * Set the value of locationType
     *
     * @return  self
     */ 
    public function setLocationType($locationType)
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
}
