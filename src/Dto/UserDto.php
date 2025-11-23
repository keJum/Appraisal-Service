<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UserDto
{
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email {
        set(string $email) {$this->email = $email;}
        get {return $this->email;}
    }

    #[Assert\NotBlank]
    public string $password {
        set(string $password) {$this->password = $password;}
        get {return $this->password;}
    }
    public function __construct(
        string $email,
        string $password
    )
    {
        $this->email = $email;
        $this->password = $password;
    }
}
