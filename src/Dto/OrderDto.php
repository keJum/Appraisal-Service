<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class OrderDto
{
    #[Assert\Email]
    #[Assert\NotBlank]
    public ?string $email {
        set {
            $this->email = $value;
        }
        get => $this->email;
    }

    #[Assert\NotBlank]
    public ?string $name {
        set(?string $name) {
            $this->name = $name;
        }
        get => $this->name;
    }

    public function __construct(?string $email, ?string $name)
    {
       $this->email = $email;
       $this->name = $name;
    }
}
