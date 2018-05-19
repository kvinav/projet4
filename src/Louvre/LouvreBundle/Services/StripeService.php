<?php
/**
 * Created by PhpStorm.
 * User: kevinavignon
 * Date: 23/04/2018
 * Time: 14:46
 */
namespace Louvre\LouvreBundle\Services;

use Louvre\LouvreBundle\Entity\Booking;
use Louvre\LouvreBundle\Entity\Ticket;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;

class StripeService
{
    private $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function stripePayment($token, $amount)
    {
        \Stripe\Stripe::setApiKey($this->key);


        $charge = \Stripe\Charge::create(array(
                "amount" => $amount*100,
                "currency" => "eur",
                "source" => $token,
                "description" => "Billetterie Louvre"
            ));
    }
}
