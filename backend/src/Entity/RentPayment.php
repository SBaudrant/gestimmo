<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\RentPaymentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\RentPaymentStatusEnum;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(
            requirements: ['id' => '\\d+'],
            normalizationContext: ['groups' => ['rent_payment:get']],
            security: 'is_granted(\'GET_ITEM\', object)',
        ),
        new Patch(
            normalizationContext: ['groups' => ['rent_payment:get']],
            denormalizationContext: ['groups' => ['rent_payment:update']],
            security: 'is_granted(\'PUT_ITEM\', object)',
            securityPostDenormalize: 'object !== user or object.getRole() === previous_object.getRole()',
        ),
        new Delete(
            security: 'is_granted(\'DELETE_ITEM\', object)',
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['rent_payment:getAll']],
            security: 'is_granted(\'GET_COLLECTION\', object)',
        ),
        new Post(
            normalizationContext: ['groups' => ['rent_payment:get']],
            denormalizationContext: ['groups' => ['rent_payment:create']],
            securityPostDenormalize: 'is_granted(\'POST_COLLECTION\', object)',
        )
    ],
)]

#[ORM\Entity(repositoryClass: RentPaymentRepository::class)]
/**
 * RentPayment class is the payment of the rent during a period in a month. 
 * It can be full month (from 1 to 30/31) or partial if a Tenant come in the middle of the month. 
 */
class RentPayment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'rent_payment:get',
        'rent_payment:getAll',
        'rent_payment:create',
        'rent_payment:update',
    ])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups([
        'rent_payment:get',
        'rent_payment:getAll',
        'rent_payment:create',
        'rent_payment:update',
    ])]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups([
        'rent_payment:get',
        'rent_payment:getAll',
        'rent_payment:create',
        'rent_payment:update',
    ])]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column]
    #[Groups([
        'rent_payment:get',
        'rent_payment:getAll',
        'rent_payment:create',
        'rent_payment:update',
    ])]
    private ?float $amount = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups([
        'rent_payment:get',
        'rent_payment:getAll',
        'rent_payment:create',
        'rent_payment:update',
    ])]
    private ?\DateTimeInterface $payedAt = null;

    #[ORM\Column]
    #[Groups([
        'rent_payment:get',
        'rent_payment:getAll',
        'rent_payment:create',
        'rent_payment:update',
    ])]
    private RentPaymentStatusEnum $status = RentPaymentStatusEnum::PENDING;

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

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPayedAt(): ?\DateTimeInterface
    {
        return $this->payedAt;
    }

    public function setPayedAt(?\DateTimeInterface $payedAt): static
    {
        $this->payedAt = $payedAt;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}
