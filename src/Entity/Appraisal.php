<?php

namespace App\Entity;

use App\Repository\AppraisalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppraisalRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_NAME', fields: ['name'])]
#[ORM\Table('appraisals')]
class Appraisal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(nullable: false)]
    public ?int $id = null;

    #[ORM\Column(length: 180, nullable: false)]
    private string $name;

    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: "appraisal")]
    private mixed $orders;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, options: ['unsigned' => true])]
    private int $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setOrders(mixed $orders): static
    {
        $this->orders = $orders;

        return $this;
    }

    /**
     * @return list<Order>
     */
    public function getOrders(): array
    {
        return $this->orders;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}
