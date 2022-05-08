<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;

#[ORM\Entity]
#[ORM\Table(name: '`budget_month`')]
#[ApiResource()]
class BudgetMonth
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    private $id;

    #[ORM\ManyToOne(targetEntity: 'Budget', inversedBy: 'budget_months', cascade: ['persist', 'remove'])]
    #[ApiSubresource(maxDepth: 1)]
    public ?Budget $budget = null;

    #[ORM\OneToMany(targetEntity: 'BudgetMonthCategory', mappedBy: 'budget_month', cascade: ['persist', 'remove'])]
    #[ApiSubresource(maxDepth: 1)]
    public iterable $budget_month_categories;

    #[ORM\Column(type: 'integer')]
    public int $year = 0;

    #[ORM\Column(type: 'integer')]
    public int $month = 0;

    public function getId()
    {
        return $this->id;
    }
}
