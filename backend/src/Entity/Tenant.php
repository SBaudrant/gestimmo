<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

#[ORM\Entity(repositoryClass: TenantRepository::class)]
/**
 * Tenant class is the person living in the house/appartment for  
 */
class Tenant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'tenant:get',
        'tenant:getAll',
        'tenant:create',
        'tenant:update',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'tenant:get',
        'tenant:getAll',
        'tenant:create',
        'tenant:update',
    ])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'tenant:get',
        'tenant:getAll',
        'tenant:create',
        'tenant:update',
    ])]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'tenant:get',
        'tenant:getAll',
        'tenant:create',
        'tenant:update',
    ])]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'tenant:get',
        'tenant:getAll',
        'tenant:create',
        'tenant:update',
    ])]
    private ?string $email = null;

    /**
     * @var Collection<int, Lease>
     */
    #[ORM\ManyToMany(targetEntity: Lease::class, inversedBy: 'tenants')]
    #[Groups([
        'tenant:get',
        'tenant:getAll',
        'tenant:create',
        'tenant:update',
    ])]
    private Collection $Lease;

    public function __construct()
    {
        $this->Lease = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): Tenant
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Lease>
     */
    public function getLease(): Collection
    {
        return $this->Lease;
    }

    public function addLease(Lease $lease): static
    {
        if (!$this->Lease->contains($lease)) {
            $this->Lease->add($lease);
        }

        return $this;
    }

    public function removeLease(Lease $lease): static
    {
        $this->Lease->removeElement($lease);

        return $this;
    }
}
