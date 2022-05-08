<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;

#[ORM\Entity]
#[ORM\Table(name: '`budget_month_category`')]
#[ApiResource()]
class BudgetMonthCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    private $id;

    #[ORM\ManyToOne(targetEntity: 'BudgetMonth', inversedBy: 'budget_month_categories', cascade: ['persist', 'remove'])]
    #[ApiSubresource(maxDepth: 1)]
    public ?BudgetMonth $budget_month = null;

    // TODO: Link to a category?
    // ManyToMany
    // BudgetMonth >--< Category

    #[ORM\Column(type: 'decimal', precision:12, scale:3, nullable: false)]
    public float $assigned = 0.0;

    public function getId()
    {
        return $this->id;
    }
}
