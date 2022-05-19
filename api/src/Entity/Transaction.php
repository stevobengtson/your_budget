<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: '`transaction`')]
#[ApiResource(
    normalizationContext: [ 'groups' => ['transaction:read']],
    denormalizationContext: [ 'groups' => ['transaction:write']]
)]
#[ApiFilter(OrderFilter::class, properties: ['date' => 'asc', 'memo', 'credit', 'debit', 'cleared'])]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['transaction:read', 'account:read'])]
    private \Ramsey\Uuid\UuidInterface $id;

    #[ORM\ManyToOne(targetEntity: 'Account', inversedBy: 'transactions', cascade: ['persist', 'remove'])]
    #[Groups(['transaction:read', 'transaction:write'])]
    #[ApiFilter(SearchFilter::class, properties: ['account.name' => 'ipartial'])]
    private ?Account $account;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['transaction:read', 'transaction:write', 'account:read'])]
    #[ApiFilter(DateFilter::class, strategy: DateFilter::EXCLUDE_NULL)]
    private ?\DateTimeInterface $date;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['transaction:read', 'transaction:write', 'account:read'])]
    #[ApiFilter(SearchFilter::class, properties: ['memo' => 'ipartial'])]
    private ?string $memo;   

    #[ORM\ManyToOne(targetEntity: 'Payee', cascade: ['persist'])]
    #[ApiSubresource(maxDepth: 1)]
    #[Groups(['transaction:read', 'transaction:write', 'account:read'])]
    #[ApiFilter(SearchFilter::class, properties: ['payee.name' => 'ipartial'])]
    private ?Payee $payee;

    #[ORM\ManyToOne(targetEntity: 'Category', cascade: ['persist'])]
    #[ApiSubresource(maxDepth: 1)]
    #[Groups(['transaction:read', 'transaction:write', 'account:read'])]
    #[ApiFilter(SearchFilter::class, properties: ['category.name' => 'ipartial'])]
    private ?Category $category;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 3, nullable: true)]
    #[Groups(['transaction:read', 'transaction:write', 'account:read'])]
    #[ApiFilter(NumericFilter::class)]
    private ?float $credit;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 3, nullable: true)]
    #[Groups(['transaction:read', 'transaction:write', 'account:read'])]
    #[ApiFilter(NumericFilter::class)]
    private ?float $debit;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false)]
    #[Groups(['transaction:read', 'transaction:write', 'account:read'])]
    #[ApiFilter(BooleanFilter::class)]
    public bool $cleared;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable(on: 'create')]
    #[Groups(['account:read'])]
    private \DateTime $created;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable(on: 'update')]
    #[Groups(['account:read'])]
    private \DateTime $updated;

    public function getId(): \Ramsey\Uuid\UuidInterface
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCleared(): ?bool
    {
        return $this->cleared;
    }

    public function setCleared(bool $cleared): self
    {
        $this->cleared = $cleared;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getPayee(): ?Payee
    {
        return $this->payee;
    }

    public function setPayee(?Payee $payee): self
    {
        $this->payee = $payee;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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

    public function getCredit(): ?string
    {
        return $this->credit;
    }

    public function setCredit(?string $credit): self
    {
        $this->credit = $credit;

        return $this;
    }

    public function getDebit(): ?string
    {
        return $this->debit;
    }

    public function setDebit(?string $debit): self
    {
        $this->debit = $debit;

        return $this;
    }

    public function getMemo(): ?string
    {
        return $this->memo;
    }

    public function setMemo(?string $memo): self
    {
        $this->memo = $memo;

        return $this;
    }
}
