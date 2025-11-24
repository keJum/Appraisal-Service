<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Пример: создаём пользователя
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setPassword('$2y$13$rdhCljXrO91ICXGFh9GrBeklXyXCFYBBde2toY9m/DjUIkMp28UaS');

        $manager->persist($user);

        $manager->flush();

        $manager->flush();
    }
}
