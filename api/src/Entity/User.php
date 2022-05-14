<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']],
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['user:read'])]
    private \Ramsey\Uuid\UuidInterface $id;

    #[ORM\Column(type: Types::STRING, length: 180, unique: true, nullable: false)]
    #[Groups(['user:read', 'user:write'])]
    private string $email;

    #[ORM\Column(type: Types::JSON, nullable: false)]
    #[Groups(['user:read'])]
    private $roles = ['ROLE_USER'];

    // This will NOT get stored in the Database
    #[Groups(['user:write'])]
    private ?string $plainPassword = null;

    // This is stored in the database but never shown to the user
    #[ORM\Column(type: Types::STRING, nullable: false)]
    private string $password;

    #[ORM\OneToMany(targetEntity: 'Budget', mappedBy: 'user', cascade: ['persist', 'remove'])]
    #[Groups(['user:read', 'user:write'])]
    #[ApiSubresource(maxDepth: 1)]
    private Collection $budgets;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable(on: 'create')]
    #[Groups(['user:read'])]
    private \DateTime $created;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable(on: 'update')]
    #[Groups(['user:read'])]
    private \DateTime $updated;

    public function __construct()
    {
        $this->budgets = new ArrayCollection();
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getId(): \Ramsey\Uuid\UuidInterface
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->email;
    }

    public function setUsername(string $value): self
    {
        $this->email = $value;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $value): self
    {
        $this->email = $value;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = array_unique(array_merge($roles, ['ROLE_USER']));

        return $this;
    }

    public function addRole(string $role): self
    {
        $this->roles = array_unique(array_merge($this->roles, [$role]));

        return $this;
    }

    public function removeRole(string $role): self
    {
        $this->roles = array_unique(array_merge(array_diff($this->roles, [$role]), ['ROLE_USER']));

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $value): self
    {
        $this->plainPassword = $value;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $value): self
    {
        $this->password = $value;

        return $this;
    }

    public function getBudgets(): Collection
    {
        return $this->budgets;
    }

    public function setBudgets(Collection $budgets): self
    {
        $this->budgets = $budgets;

        return $this;
    }

    public function addBudget(Budget $budget): self
    {
        $budget->user = $this;
        $this->budgets->add($budget);

        return $this;
    }

    public function removeBudget(Budget $budget): self
    {
        $budget->user = null;
        $this->budgets->removeElement($budget);

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }
}
