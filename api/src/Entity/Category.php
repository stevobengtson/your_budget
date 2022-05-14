<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: '`category`')]
#[ApiResource(
    normalizationContext: [ 'groups' => ['category:read']],
    denormalizationContext: [ 'groups' => ['category:write']]
)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['category:read', 'transaction:read'])]
    private \Ramsey\Uuid\UuidInterface $id;

    #[ORM\ManyToOne(targetEntity: 'Budget', inversedBy: 'categories', cascade: ['persist', 'remove'])]
    #[Groups(['category:read', 'category:write'])]
    private ?Budget $budget;

    #[ORM\ManyToOne(targetEntity: 'CategoryGroup', inversedBy: 'categories', cascade: ['persist', 'remove'])]
    #[Groups(['category:read', 'category:write', 'transaction:read'])]
    private ?CategoryGroup $category_group;

    #[ORM\Column(type: Types::STRING, length: 1024)]
    #[Groups(['category:read', 'category:write', 'transaction:read'])]
    private string $name;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable(on: 'create')]
    #[Groups(['category:read', 'transaction:read'])]
    private \DateTime $created;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable(on: 'update')]
    #[Groups(['category:read', 'transaction:read'])]
    private \DateTime $updated;

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

    public function getBudget(): ?Budget
    {
        return $this->budget;
    }

    public function setBudget(?Budget $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getCategoryGroup(): ?CategoryGroup
    {
        return $this->category_group;
    }

    public function setCategoryGroup(?CategoryGroup $category_group): self
    {
        $this->category_group = $category_group;

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
