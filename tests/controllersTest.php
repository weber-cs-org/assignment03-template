<?php

use Silex\WebTestCase;

class controllersTest extends WebTestCase
{
    public function testGetHomepage()
    {
        $client = $this->createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertContains('Twig - Assignment #3', $crawler->filter('title')->text());
        $this->assertContains('Welcome to', $crawler->filter('body')->text());
        $this->assertContains('Assignment #3', $crawler->filter('body')->text());
        $this->assertContains('!', $client->getResponse()->getContent());
    }

    public function test404page()
    {
        $client = $this->createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/nothere');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertContains("0", $crawler->filter('body')->text());
    }

    public function testCookiesTemplate()
    {
        $client = $this->createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertContains('Time: ', $crawler->filter('body')->text());
        $this->assertContains('Time ', $crawler->filter('body')->text());
        $this->assertContains('cookies', $crawler->filter('body')->text());
    }

    public function testUsersSuccess()
    {
        $client = $this->createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/');
        $this->app['users'] = [
            new \Assignment\User('anne@example.com', 'Anne Anderson'),
            new \Assignment\User('ben@example.com', 'Ben Barlow'),
            new \Assignment\User('chris@example.com', 'Chris Christensen'),
        ];

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertContains('Members', $crawler->filter('body')->text());
        $this->assertContains('Anne Anderson email is "anne@example.com"', $crawler->filter('body')->text());
        $this->assertContains('Ben Barlow email is "ben@example.com"', $crawler->filter('body')->text());
        $this->assertContains('Chris Christensen email is "chris@example.com"', $crawler->filter('body')->text());
    }

    public function testUsersFailure()
    {
        $client = $this->createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/users_test');
        $this->app['users'] = [];

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertContains('No members', $crawler->filter('body')->text());
    }

    public function testUsersEmptyArgumentsException()
    {
        // arrange
        $actual = null;
        $expected = "empty arguments";
        // act
        try {
            new \Assignment\User("","");
        } catch(\Exception $e) {
            $actual = $e->getMessage();
            $this->assertEquals(\InvalidArgumentException::class, get_class($e));
        }
        // assert
        $this->assertEquals($expected, $actual);
    }

    public function testUsersNotStringsException()
    {
        // arrange
        $actual = null;
        $expected = "arguments are not strings";
        // act
        try {
            new \Assignment\User(1,1);
        } catch(\Exception $e) {
            $actual = $e->getMessage();
            $this->assertEquals(\InvalidArgumentException::class, get_class($e));
        }
        // assert
        $this->assertEquals($expected, $actual);
    }

    public function testEmailNotValidException()
    {
        // arrange
        $actual = null;
        $expected = "email is not valid";
        // act
        try {
            new \Assignment\User("anne@example","Anne Able");
        } catch(\Exception $e) {
            $actual = $e->getMessage();
            $this->assertEquals(\InvalidArgumentException::class, get_class($e));
        }
        // assert
        $this->assertEquals($expected, $actual);
    }

    public function createApplication()
    {
        $app = require __DIR__.'/../src/app.php';
        require __DIR__.'/../config/dev.php';
        require __DIR__.'/../src/controllers.php';
        $app['session.test'] = true;

        return $this->app = $app;
    }
}
