<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;

#[ORM\Entity]
#[ORM\Table(name: '`category_group`')]
#[ApiResource()]
class CategoryGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    private $id;

    #[ORM\OneToMany(targetEntity: 'Category', mappedBy: 'category_group', cascade: ['persist', 'remove'])]
    #[ApiSubresource(maxDepth: 1)]
    public iterable $categories;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 3, nullable: false)]
    public float $assigned = 0.0;

    #[ORM\Column(type: 'string', length: 1024)]
    public string $name = '';

    public function getId()
    {
        return $this->id;
    }
}
