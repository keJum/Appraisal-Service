<?php

namespace App\Exception;

use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class ValidateException extends Exception
{
    public ConstraintViolationListInterface $errors {
        get {
            return $this->errors;
        }
    }

    public function __construct(ConstraintViolationListInterface $errors, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = (string) $errors;
        $this->errors = $errors;
    }
}
