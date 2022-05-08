<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;

#[ORM\Entity]
#[ORM\Table(name: '`category`')]
#[ApiResource()]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    private $id;

    #[ORM\ManyToOne(targetEntity: 'Budget', inversedBy: 'categories', cascade: ['persist', 'remove'])]
    public ?Budget $budget = null;

    #[ORM\ManyToOne(targetEntity: 'CategoryGroup', inversedBy: 'categories', cascade: ['persist', 'remove'])]
    public ?CategoryGroup $category_group = null;

    #[ORM\Column(type: 'string', length: 1024)]
    public string $name = '';

    public function getId()
    {
        return $this->id;
    }
}
