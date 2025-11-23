<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 'orders')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(nullable: false)]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    private string $email;

    #[ORM\ManyToOne(targetEntity: Appraisal::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(name: "appraisal_id", referencedColumnName: "id")]
    private Appraisal $appraisal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setAppraisal(Appraisal $appraisal): static
    {
        $this->appraisal = $appraisal;

        return $this;
    }

    public function getAppraisal(): Appraisal
    {
        return $this->appraisal;
    }
}
