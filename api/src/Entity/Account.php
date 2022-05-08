<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: '`account`')]
#[ApiResource()]
class Account
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    private $id;

    #[ORM\Column(type: 'string', length: 1024)]
    #[Assert\NotBlank]
    public string $name = '';

    #[ORM\Column(type: 'text')]
    public string $description = '';

    #[ORM\Column(type: 'decimal', precision:12, scale:3, nullable: false)]
    public float $balance = 0.0;

    #[ORM\ManyToOne(targetEntity: 'Budget', inversedBy: 'accounts', cascade: ['persist', 'remove'])]
    public ?Budget $budget = null;

    #[ORM\OneToMany(targetEntity: 'Transaction', mappedBy: 'account', cascade: ['persist', 'remove'])]
    #[ApiSubresource(maxDepth: 1)]
    public iterable $transactions;

    public function getId()
    {
        return $this->id;
    }
}