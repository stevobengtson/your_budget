<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;

#[ORM\Entity]
#[ORM\Table(name: '`transaction`')]
#[ApiResource()]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    private $id;

    #[ORM\ManyToOne(targetEntity: 'Account', inversedBy: 'transactions', cascade: ['persist', 'remove'])]
    public ?Account $account = null;

    #[ORM\Column(type: 'datetime')]
    public ?\DateTimeInterface $date = null;

    #[ORM\OneToOne(targetEntity: 'Payee')]
    #[ApiSubresource(maxDepth: 1)]
    public ?Payee $payee = null;

    #[ORM\OneToOne(targetEntity: 'Category')]
    #[ApiSubresource(maxDepth: 1)]
    public ?Category $category = null;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 3, nullable: false)]
    public float $credit = 0.0;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 3, nullable: false)]
    public float $debit = 0.0;

    #[ORM\Column(type: 'boolean', nullable: false)]
    public bool $cleared = false;

    public function getId()
    {
        return $this->id;
    }
}
