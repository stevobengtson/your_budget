<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class AuthenticationTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    public function testLogin(): void
    {
        $client = self::createClient();

        $user = new User();
        $user->setEmail('test@example.com');
        $user->setPassword('$2y$13$u9WiYYUzHZ.XknblK6wBcu/osDcAjIB545i4QG5mvc7jfMXtZ6YB2');

        $manager = self::getContainer()->get('doctrine')->getManager();
        $manager->persist($user);
        $manager->flush();

        // retrieve a token
        $response = $client->request('POST', '/authentication_token', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'test@example.com',
                'password' => '$3CR3T',
            ],
        ]);

        $json = $response->toArray();
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'token' => $json['token'],
        ]);

        // // test not authorized
        // $client->request('GET', '/greetings');
        // $this->assertResponseStatusCodeSame(401);

        // // test authorized
        // $client->request('GET', '/greetings', ['auth_bearer' => $json['token']]);
        // $this->assertResponseIsSuccessful();
    }
}
