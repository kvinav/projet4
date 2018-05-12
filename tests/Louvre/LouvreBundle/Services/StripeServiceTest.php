<?php
/**
 * Created by PhpStorm.
 * User: kevinavignon
 * Date: 12/05/2018
 * Time: 10:45
 */
namespace Tests\Louvre\LouvreBundle\Services;

use Louvre\LouvreBundle\Services\StripeService;
use PHPUnit\Framework\TestCase;

class StripeServiceTest extends TestCase
{

    private $key = 'pk_test_YyJYkgu1VfUxiveZoEb4Ru3z';

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function testStripePayment()
    {
        $stripe = new StripeService();
        $result = $stripe->stripePayment(tok_1CQtQ6LCuwd0oUHH5bHfCytI, 10);

        // assert that your calculator added the numbers correctly!
        $this->assertTrue($client->getResponse()->isRedirect('/checkout'));
    }
}