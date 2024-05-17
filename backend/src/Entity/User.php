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
use App\Dto\User\UserInitPasswordRequest;
use App\Dto\User\UserPasswordResetRequest;
use App\Dto\User\UserUpdatePasswordRequest;
use App\Enum\Role;
use App\Filter\UserSearchFilter;
use App\Repository\UserRepository;
use App\State\NewUserProcessor;
use App\State\UserInitPasswordRequestProcessor;
use App\State\UserInitPasswordRequestProvider;
use App\State\UserPasswordResetRequestProcessor;
use App\State\UserUpdatePasswordRequestProcessor;
use App\State\UserUpdatePasswordRequestProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(
            requirements: ['id' => '\\d+'],
            normalizationContext: ['groups' => ['user:get']],
            security: 'is_granted(\'GET_ITEM\', object)',
        ),
        new Patch(
            normalizationContext: ['groups' => ['user:get']],
            denormalizationContext: ['groups' => ['user:update']],
            security: 'is_granted(\'PUT_ITEM\', object)',
            securityPostDenormalize: 'object !== user or object.getRole() === previous_object.getRole()',
        ),
        new Delete(
            security: 'is_granted(\'DELETE_ITEM\', object)',
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['user:getAll']],
            security: 'is_granted(\'GET_COLLECTION\', object)',
        ),
        new Post(
            normalizationContext: ['groups' => ['user:get']],
            denormalizationContext: ['groups' => ['user:create']],
            securityPostDenormalize: 'is_granted(\'POST_COLLECTION\', object)',
            processor: NewUserProcessor::class,
        ),
        new Post(
            uriTemplate: '/users/init_password',
            openapiContext: [
                'summary' => 'Envoie une demande de réinitialisation de mot de passe',
                'responses' => [
                    '204' => ['description' => 'La demande de réinitialisation a été prise en compte', 'content' => []],
                    '400' => ['description' => 'Requête invalide', 'content' => []],
                ],
            ],
            input: UserPasswordResetRequest::class,
            output: false,
            processor: UserPasswordResetRequestProcessor::class,
        ),
        new Post(
            uriTemplate: '/users/init_password/{token}',
            uriVariables: [
                'token' => new Link(
                    toProperty: 'initPasswordToken',
                    fromClass: UserInitPasswordRequest::class,
                    toClass: User::class,
                ),
            ],
            openapiContext: [
                'summary' => 'Réinitialise le mot de passe à l\'aide d\'un token',
                'responses' => [
                    '204' => ['description' => 'Mot de passe réinitialisé', 'content' => []],
                    '400' => ['description' => 'Requête invalide', 'content' => []],
                ],
            ],
            denormalizationContext: ['groups' => ['user:initPassword']],
            input: UserInitPasswordRequest::class,
            output: false,
            provider: UserInitPasswordRequestProvider::class,
            processor: UserInitPasswordRequestProcessor::class,
        ),
        new Patch(
            uriTemplate: '/users/{user}/change_password',
            uriVariables: [
                'user' => new Link(
                    toProperty: 'id',
                    fromClass: UserUpdatePasswordRequest::class,
                    toClass: User::class,
                ),
            ],
            openapiContext: [
                'summary' => 'Met à jour le mot de passe de l\'utilisateur',
                'tags' => ['User'],
                'responses' => [
                    '200' => ['description' => 'Mot de passe modifié', 'content' => []],
                    '400' => ['description' => 'Requête invalide', 'content' => []],
                    '404' => ['description' => 'Utilisateur inconnu', 'content' => []],
                ],
            ],
            denormalizationContext: ['groups' => ['userUpdatePasswordRequest:put']],
            security: 'object.getUser() === user',
            input: UserUpdatePasswordRequest::class,
            output: false,
            provider: UserUpdatePasswordRequestProvider::class,
            processor: UserUpdatePasswordRequestProcessor::class,
        ),
    ],
)]

#[ApiFilter(UserSearchFilter::class)]
#[ApiFilter(SearchFilter::class, properties: [
    'firstName' => 'partial',
    'lastName' => 'partial',
    'email' => 'exact',
    'role' => 'exact',
])]
#[ApiFilter(filterClass: OrderFilter::class, properties: [
    'firstName',
    'lastName',
    'email',
    'active',
    'role',
])]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(['email'])]
#[UniqueEntity(['initPasswordToken'])]
/**
 * User class reprensents users of the application, the owners of properties. They can additionnaly be admin.
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Column(type: Types::BIGINT)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[Groups([
        'user:get',
        'user:getAll',
        'user:create',
        'user:update',
    ])]
    private ?string $id = null;

    #[ORM\Column(type: Types::STRING, unique: true, nullable: false)]
    #[Assert\Email]
    #[Groups([
        'user:get',
        'user:getAll',
        'user:create',
        'user:update',
    ])]
    private string $email;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    #[Assert\NotBlank]
    #[Groups([
        'user:get',
        'user:getAll',
        'user:create',
        'user:update',
    ])]
    private string $firstName;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    #[Assert\NotBlank]
    #[Groups([
        'user:get',
        'user:getAll',
        'user:create',
        'user:update',
    ])]
    private string $lastName;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(type: Types::STRING, nullable: false, enumType: Role::class)]
    #[Assert\NotNull]
    #[Groups([
        'user:get',
        'user:getAll',
        'user:create',
        'user:update',
    ])]
    private Role $role;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false)]
    #[Groups([
        'user:get',
        'user:getAll',
        'user:create',
        'user:update',
    ])]
    private bool $active = false;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $initPasswordTokenExpiration = null;

    #[ORM\Column(type: Types::STRING, length: 128, unique: true, nullable: true)]
    private ?string $initPasswordToken = null;

    /**
     * @var Collection<int, RentalProperty>
     */
    #[ORM\ManyToMany(targetEntity: RentalProperty::class, mappedBy: 'owners')]
    #[Groups([
        'user:get'
    ])]
    private Collection $rentalProperties;

    public function __construct()
    {
        $this->rentalProperties = new ArrayCollection();
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function eraseCredentials(): void
    {
        return;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): User
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): User
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function setRole(Role $role): User
    {
        $this->role = $role;

        return $this;
    }

    public function getRoles(): array
    {
        return [$this->role->value];
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): User
    {
        $this->active = $active;

        return $this;
    }

    public function getInitPasswordTokenExpiration(): ?\DateTimeImmutable
    {
        return $this->initPasswordTokenExpiration;
    }

    public function setInitPasswordTokenExpiration(?\DateTimeImmutable $initPasswordTokenExpiration): User
    {
        $this->initPasswordTokenExpiration = $initPasswordTokenExpiration;

        return $this;
    }

    public function getInitPasswordToken(): ?string
    {
        return $this->initPasswordToken;
    }

    public function setInitPasswordToken(?string $initPasswordToken): User
    {
        $this->initPasswordToken = $initPasswordToken;

        return $this;
    }

    /**
     * @return Collection<int, RentalProperty>
     */
    public function getRentalProperties(): Collection
    {
        return $this->rentalProperties;
    }

    public function addRentalProperty(RentalProperty $rentalProperty): static
    {
        if (!$this->rentalProperties->contains($rentalProperty)) {
            $this->rentalProperties->add($rentalProperty);
            $rentalProperty->addOwner($this);
        }

        return $this;
    }

    public function removeRentalProperty(RentalProperty $rentalProperty): static
    {
        if ($this->rentalProperties->removeElement($rentalProperty)) {
            $rentalProperty->removeOwner($this);
        }

        return $this;
    }
}
