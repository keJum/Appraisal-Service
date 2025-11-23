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

    #[Assert\Type('integer')]
    #[Assert\NotBlank]
    public ?int $appraisalId {
        set(?int $appraisalId) {
            $this->appraisalId = $appraisalId;
        }
        get => $this->appraisalId;
    }

    public function __construct(?string$email, ?string $appraisalId)
    {
       $this->email = $email;
       $this->appraisalId = $appraisalId;
    }
}
