<?php
/**
 * Created by PhpStorm.
 * User: kevinavignon
 * Date: 12/05/2018
 * Time: 10:04
 */
// tests/Louvre/LouvreBundle/Controller/LouvreControllerTest.php
namespace Tests\Louvre\LouvreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class LouvreControllerTestControllerTest extends WebTestCase
{
    public function testHomeAction()
    {
        $client = static::createClient();

        $crawler = $client->request(Request::METHOD_GET, '/');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Bienvenue sur la billetterie du musée du Louvre")')->count()
        );
    }

    public function testNoticeAction()
    {
        $client = static::createClient();

        $crawler = $client->request(Request::METHOD_GET, '/notice');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Informations légales")')->count()
        );
    }

    public function testOrderAction()
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/order');

        $this->assertContains('Commande de billets', $client->getResponse()->getContent());
    }
}