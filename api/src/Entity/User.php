<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(["read"])]
    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(["read", "write"])]
    public string $email = '';

    #[ORM\Column(type: 'json')]
    #[Groups(["read"])]
    public $roles = [];

    // This will NOT get stored in the Database
    #[Groups(["write"])]
    public ?string $plainPassword = null;

    // This is stored in the database but never shown to the user
    #[ORM\Column(type: 'string')]
    public string $password = '';

    #[ORM\OneToMany(targetEntity: 'Budget', mappedBy: 'user', cascade: ['persist', 'remove'])]
    #[ApiSubresource(maxDepth: 1)]
    public iterable $budgets;

    public function getId()
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->email;
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

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }
}
