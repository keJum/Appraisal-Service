<?php

namespace App\Tests;

use App\DataFixtures\AppFixtures;
use App\Entity\User;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    protected KernelBrowser $client;
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();

        $container = self::getContainer();
        $this->em = $container->get(EntityManagerInterface::class);
    }

    protected function loadFixtures(): void
    {
        $purger = new ORMPurger($this->em);
        $executor = new ORMExecutor($this->em, $purger);
        $executor->execute([new AppFixtures()]);
    }

    public function testWithData(): void
    {
        $this->loadFixtures();
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Войти')->form([
            '_username' => 'test@example.com',
            '_password' => '12345',
        ]);
        $this->client->submit($form);

        self::assertResponseRedirects('/appraisal');

        $purger = new ORMPurger($this->em);
        $purger->purge();
    }

    public function testSecurePageAfterLogin(): void
    {
        $client = $this->client;

        // 1. Создаём или получаем пользователя
        $user = new User();
        $user->setEmail('test1@example.com');
        $user->setPassword('123456'); // Symfony автоматически хэширует при сохранении


        $container = self::getContainer();
        $em = $container->get(EntityManagerInterface::class);
        $em->persist($user);
        $em->flush();

        // 2. Авторизуем пользователя в клиенте
        $client->loginUser($user);


        // 3. Проверяем доступ к защищённой странице
        $client->request('GET', '/appraisal');
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Заказать услугу оценки');

        $purger = new ORMPurger($em);
        $purger->purge();
    }
}
