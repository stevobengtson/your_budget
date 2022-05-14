<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: '`budget_month`')]
#[ApiResource(
    normalizationContext: ['groups' => ['budget_month:read']],
    denormalizationContext: ['groups' => ['budget_month:write']],
)]
class BudgetMonth
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['budget_month:read'])]
    private \Ramsey\Uuid\UuidInterface $id;

    #[ORM\ManyToOne(targetEntity: 'Budget', inversedBy: 'budget_months', cascade: ['persist', 'remove'])]
    #[ApiSubresource(maxDepth: 1)]
    #[Groups(['budget_month:read', 'budget_month:write'])]
    private ?Budget $budget;

    #[ORM\OneToMany(targetEntity: 'BudgetMonthCategory', mappedBy: 'budget_month', cascade: ['persist', 'remove'])]
    #[ApiSubresource(maxDepth: 1)]
    #[Groups(['budget_month:read', 'budget_month:write'])]
    private Collection $budget_month_categories;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    #[Groups(['budget_month:read', 'budget_month:write'])]
    private int $year;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    #[Groups(['budget_month:read', 'budget_month:write'])]
    private int $month;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable(on: 'create')]
    #[Groups(['budget_month:read'])]
    private \DateTime $created;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable(on: 'update')]
    #[Groups(['budget_month:read'])]
    private \DateTime $updated;

    public function __construct()
    {
        $this->budget_month_categories = new ArrayCollection();
    }

    public function getId(): \Ramsey\Uuid\UuidInterface
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function setMonth(int $month): self
    {
        $this->month = $month;

        return $this;
    }

    public function getBudget(): ?Budget
    {
        return $this->budget;
    }

    public function setBudget(?Budget $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * @return Collection|BudgetMonthCategory[]
     */
    public function getBudgetMonthCategories(): Collection
    {
        return $this->budget_month_categories;
    }

    public function addBudgetMonthCategory(BudgetMonthCategory $budgetMonthCategory): self
    {
        if (!$this->budget_month_categories->contains($budgetMonthCategory)) {
            $this->budget_month_categories[] = $budgetMonthCategory;
            $budgetMonthCategory->setBudgetMonth($this);
        }

        return $this;
    }

    public function removeBudgetMonthCategory(BudgetMonthCategory $budgetMonthCategory): self
    {
        if ($this->budget_month_categories->removeElement($budgetMonthCategory)) {
            // set the owning side to null (unless already changed)
            if ($budgetMonthCategory->getBudgetMonth() === $this) {
                $budgetMonthCategory->setBudgetMonth(null);
            }
        }

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
