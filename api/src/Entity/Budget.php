<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: '`budget`')]

#[ORM\HasLifecycleCallbacks]
#[ApiResource()]
class Budget
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

    #[ORM\Column(type: 'string', length: 1024)]
    #[Assert\NotBlank]
    #[Groups(["read", "write"])]
    public string $name = '';

    #[ORM\Column(type: 'date')]
    #[Groups(["read"])]
    public ?\DateTimeInterface $startDate = null;

    #[ORM\ManyToOne(targetEntity: 'User', inversedBy: 'budgets', cascade: ['persist', 'remove'])]
    #[Groups(["read"])]
    #[ApiSubresource()]
    public ?User $user = null;

    #[ORM\OneToMany(targetEntity: 'Account', mappedBy: 'budget', cascade: ['persist', 'remove'])]
    #[ApiSubresource(maxDepth: 1)]
    #[Groups(["read"])]
    public iterable $accounts;

    #[ORM\OneToMany(targetEntity: 'BudgetMonth', mappedBy: 'budget', cascade: ['persist', 'remove'])]
    #[ApiSubresource(maxDepth: 1)]
    #[Groups(["read"])]
    public iterable $budget_months;

    #[ORM\OneToMany(targetEntity: 'Payee', mappedBy: 'budget', cascade: ['persist', 'remove'])]
    #[ApiSubresource(maxDepth: 1)]
    #[Groups(["read"])]
    public iterable $payees;

    #[ORM\OneToMany(targetEntity: 'Category', mappedBy: 'budget', cascade: ['persist', 'remove'])]
    #[ApiSubresource(maxDepth: 1)]
    #[Groups(["read"])]
    public iterable $categories;

    public function getId()
    {
        return $this->id;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function ensureStartDateValue(): void
    {
        if ($this->startDate == null) {
            $this->startDate = new DateTimeImmutable();
        }
    }
}
