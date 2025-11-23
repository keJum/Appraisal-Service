<?php

namespace App\Validator;

use App\Exception\ValidateException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

trait Validator
{
    /**
     * @throws ValidateException
     */
    public function validate(ValidatorInterface $validator, object $dto): void
    {
        $errors = $validator->validate($dto);
        if (count($errors) > 0) {
            throw new ValidateException($errors);
        }
    }
}
