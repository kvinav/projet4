<?php
/**
 * Created by PhpStorm.
 * User: kevinavignon
 * Date: 12/05/2018
 * Time: 10:45
 */
namespace Tests\Louvre\LouvreBundle\Services;

use Louvre\LouvreBundle\Services\StripeService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class checkoutAccessTest extends WebTestCase
{

    public function testCheckoutAccess()
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/checkout');

        $this->assertEquals(Response::HTTP_METHOD_NOT_ALLOWED, $client->getResponse()->getStatusCode());

    }
}