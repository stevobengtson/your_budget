<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: '`payee`')]
#[ApiResource()]
class Payee
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    private $id;

    #[ORM\ManyToOne(targetEntity: 'Budget', inversedBy: 'payees', cascade: ['persist', 'remove'])]
    public ?Budget $budget = null;

    #[ORM\Column(type: 'string', length: 1024)]
    #[Assert\NotBlank]
    public string $name = '';

    public function getId()
    {
        return $this->id;
    }
}
