<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: '`budget_month_category`')]
#[ApiResource(
    normalizationContext: ['groups' => ['budget_month_category:read']],
    denormalizationContext: ['groups' => ['budget_month_category:write']],
)]
class BudgetMonthCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['budget_month_category:read'])]
    private \Ramsey\Uuid\UuidInterface $id;

    #[ORM\ManyToOne(targetEntity: 'BudgetMonth', inversedBy: 'budget_month_categories', cascade: ['persist', 'remove'])]
    #[ApiSubresource(maxDepth: 1)]
    #[Groups(['budget_month_category:read', 'budget_month_category:write'])]
    public ?BudgetMonth $budget_month;

    // TODO: Link to a category?
    // ManyToMany
    // BudgetMonth >--< Category

    #[ORM\Column(type: Types::DECIMAL, precision:12, scale:3, nullable: false)]
    #[Groups(['budget_month_category:read', 'budget_month_category:write'])]
    public float $assigned;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable(on: 'create')]
    #[Groups(['budget_month_category:read'])]
    private \DateTime $created;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable(on: 'update')]
    #[Groups(['budget_month_category:read'])]
    private \DateTime $updated;

    public function getId(): \Ramsey\Uuid\UuidInterface
    {
        return $this->id;
    }

    public function getAssigned(): ?string
    {
        return $this->assigned;
    }

    public function setAssigned(string $assigned): self
    {
        $this->assigned = $assigned;

        return $this;
    }

    public function getBudgetMonth(): ?BudgetMonth
    {
        return $this->budget_month;
    }

    public function setBudgetMonth(?BudgetMonth $budget_month): self
    {
        $this->budget_month = $budget_month;

        return $this;
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
