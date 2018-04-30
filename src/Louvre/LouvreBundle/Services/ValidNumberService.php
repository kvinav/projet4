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
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;

class ValidNumberService
{

    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function getTotalTickets($day)
    {

        $session = new Session();
        $booking = $session->get('booking');
        $quantityPerDay = 0;
        foreach ($booking->getTickets() as $ticket) {
            $quantityPerDay++;
        }


        $repository = $this->em->getRepository('LouvreLouvreBundle:Booking');
        $tickets = $repository->findBy(array('dateVisit' => $day));
        $quantity = 0;
        foreach ($tickets as $ticket) {
            $quantity++;
        }

        $totalTickets = $quantityPerDay + $quantity;
        return $totalTickets;
    }

}

