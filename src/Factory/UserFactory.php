<?php

namespace App\Factory;

use App\Dto\UserDto;
use App\Entity\User as EntityUser;
use App\Exception\ValidateException;
use App\Repository\UserRepository;
use App\Validator\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class UserFactory
{
    use Validator;

    public function __construct(
        private ValidatorInterface $validator,
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $entityManager,
        private UserRepository         $userRepository
    ){}

    /**
     * @throws ValidateException
     */
    public function createOrChange(UserDto $dto): void
    {
        $this->validate($this->validator, $dto);

        $user = $this->userRepository->findOneBy(['email' => $dto->email]);
        if (is_null($user)) {
            $user = new EntityUser();
            $user->setEmail($dto->email);
        }
        $user->setPassword($this->hashPassword($user, $dto->password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    private function hashPassword(EntityUser $user, string $password): string
    {
        return $this->passwordHasher->hashPassword(
            $user,
            $password
        );
    }
}
