<?php

namespace App\Tests;

use App\Entity\Appraisal;
use App\Entity\Order;
use App\Entity\User;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AppraisalTest extends WebTestCase
{
    public function testSecurePageAfterLogin(): void
    {
        $client = static::createClient();

        $appraisal = new Appraisal();
        $appraisal->setName('Test');
        $appraisal->setPrice('30');

        $user = new User();
        $user->setEmail('test2@example.com');
        $user->setPassword('123456'); // Symfony автоматически хэширует при сохранении

        $container = self::getContainer();
        $em = $container->get(EntityManagerInterface::class);
        $em->persist($user);
        $em->flush();
        $em->persist($appraisal);
        $em->flush();

        $client->loginUser($user);

        $crawler = $client->request('GET', '/appraisal');

        self::assertResponseIsSuccessful();

        $form = $crawler->selectButton('Подтвердить')->form([
            'email' => 'test1@test.com'
        ]);
        $form['name']->select('Test');
        $client->submit($form);
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Заказать услугу оценки');

        $order = $em->getRepository(Order::class)->findOneBy(['email' => 'test1@test.com']);
        self::assertNotNull($order);

        $purger = new ORMPurger($em);
        $purger->purge();
    }

    public function testSecurePageAfterLoginEmailRequierd(): void
    {
        $client = static::createClient();

        $appraisal = new Appraisal();
        $appraisal->setName('Test');
        $appraisal->setPrice('30');

        $user = new User();
        $user->setEmail('test2@example.com');
        $user->setPassword('123456');


        $container = self::getContainer();
        $em = $container->get(EntityManagerInterface::class);
        $em->persist($user);
        $em->flush();
        $em->persist($appraisal);
        $em->flush();

        $client->loginUser($user);

        $crawler = $client->request('GET', '/appraisal');

        self::assertResponseIsSuccessful();

        $form = $crawler->selectButton('Подтвердить')->form([
            'email' => 'test'
        ]);
        $form['name']->select('Test');
        $client->submit($form);
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Заказать услугу оценки');
        self::assertSelectorTextContains('#error', 'This value is not a valid email address.');

        $purger = new ORMPurger($em);
        $purger->purge();
    }
}
