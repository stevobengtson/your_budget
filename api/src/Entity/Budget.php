<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: '`budget`')]
#[ApiResource(
    normalizationContext: ['groups' => ['budget:read']],
    denormalizationContext: ['groups' => ['budget:write']],
)]
class Budget
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(["budget:read"])]
    private \Ramsey\Uuid\UuidInterface $id;

    #[ORM\Column(type: Types::STRING, length: 1024)]
    #[Assert\NotBlank]
    #[Groups(["budget:read", "budget:write"])]
    private string $name;

    #[ORM\ManyToOne(targetEntity: 'User', inversedBy: 'budgets', cascade: ['persist', 'remove'])]
    #[Groups(["budget:read"])]
    #[ApiSubresource(maxDepth: 1)]
    private User $user;

    #[ORM\OneToMany(targetEntity: 'Account', mappedBy: 'budget', cascade: ['persist', 'remove'])]
    #[ApiSubresource(maxDepth: 1)]
    #[Groups(["budget:read"])]
    private Collection $accounts;

    #[ORM\OneToMany(targetEntity: 'BudgetMonth', mappedBy: 'budget', cascade: ['persist', 'remove'])]
    #[ApiSubresource(maxDepth: 1)]
    #[Groups(["budget:read"])]
    private Collection $budget_months;

    #[ORM\OneToMany(targetEntity: 'Payee', mappedBy: 'budget', cascade: ['persist', 'remove'])]
    #[ApiSubresource(maxDepth: 1)]
    #[Groups(["budget:read"])]
    private Collection $payees;

    #[ORM\OneToMany(targetEntity: 'Category', mappedBy: 'budget', cascade: ['persist', 'remove'])]
    #[ApiSubresource(maxDepth: 1)]
    #[Groups(["budget:read"])]
    private Collection $categories;

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
        $this->accounts = new ArrayCollection();
        $this->budget_months = new ArrayCollection();
        $this->payees = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): \Ramsey\Uuid\UuidInterface
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Account[]
     */
    public function getAccounts(): Collection
    {
        return $this->accounts;
    }

    public function addAccount(Account $account): self
    {
        if (!$this->accounts->contains($account)) {
            $this->accounts[] = $account;
            $account->setBudget($this);
        }

        return $this;
    }

    public function removeAccount(Account $account): self
    {
        if ($this->accounts->removeElement($account)) {
            // set the owning side to null (unless already changed)
            if ($account->getBudget() === $this) {
                $account->setBudget(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BudgetMonth[]
     */
    public function getBudgetMonths(): Collection
    {
        return $this->budget_months;
    }

    public function addBudgetMonth(BudgetMonth $budgetMonth): self
    {
        if (!$this->budget_months->contains($budgetMonth)) {
            $this->budget_months[] = $budgetMonth;
            $budgetMonth->setBudget($this);
        }

        return $this;
    }

    public function removeBudgetMonth(BudgetMonth $budgetMonth): self
    {
        if ($this->budget_months->removeElement($budgetMonth)) {
            // set the owning side to null (unless already changed)
            if ($budgetMonth->getBudget() === $this) {
                $budgetMonth->setBudget(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Payee[]
     */
    public function getPayees(): Collection
    {
        return $this->payees;
    }

    public function addPayee(Payee $payee): self
    {
        if (!$this->payees->contains($payee)) {
            $this->payees[] = $payee;
            $payee->setBudget($this);
        }

        return $this;
    }

    public function removePayee(Payee $payee): self
    {
        if ($this->payees->removeElement($payee)) {
            // set the owning side to null (unless already changed)
            if ($payee->getBudget() === $this) {
                $payee->setBudget(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setBudget($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getBudget() === $this) {
                $category->setBudget(null);
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
