<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WebTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        self::assertResponseRedirects('/login');
    }

    public function testLoginPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Вход');
    }

    public function testNotAccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/appraisal');

        self::assertResponseRedirects('/login');
    }
}
