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

class BookingService
{
    protected $mailer;
    protected $templating;
    protected $calculAge;

    public function __construct(\Swift_Mailer $mailer, $templating, CalculAge $calculAge)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->calculAge = $calculAge;
    }
    // Calcul de l'age à partir de la date de naissance
    public function calculateAge($booking)
    {
        $this->calculAge->calculateAge($booking);
    }

    public function calculatePrice()
    {
        $session = new Session();
        $booking = $session->get('booking');
        $totalPrice = 0;
        $type = $booking->getType();
        foreach ($booking->getTickets() as $ticket) {
            $age = $ticket->getAge();
            $ticket->getPriceTicket();
            $priceTicket = 0;
            $discount = $ticket->getDiscount();

            if ($age > 12 && $age < 60 && $discount === false) {
                if ($type == 'Demi-journée') {
                    $priceTicket = 16/2;
                    $ticket->setPriceTicket($priceTicket);
                } else {
                    $priceTicket = 16;
                    $ticket->setPriceTicket($priceTicket);
                }
            } elseif ($age <= 12 && $age >= 4) {
                if ($type == 'Demi-journée') {
                    $priceTicket = 8/2;
                    $ticket->setPriceTicket($priceTicket);
                } else {
                    $priceTicket = 8;
                    $ticket->setPriceTicket($priceTicket);
                }
            } elseif ($age >= 60 && $discount === false) {
                if ($type == 'Demi-journée') {
                    $priceTicket = 12/2;
                    $ticket->setPriceTicket($priceTicket);
                } else {
                    $priceTicket = 12;
                    $ticket->setPriceTicket($priceTicket);
                }
            } elseif ($age < 4) {
                $priceTicket = 0;
                $ticket->setPriceTicket($priceTicket);
            } elseif ($age > 12 && $age < 60 && $discount === true) {
                if ($type == 'Demi-journée') {
                    $priceTicket = 10/2;
                    $ticket->setPriceTicket($priceTicket);
                } else {
                    $priceTicket = 10;
                    $ticket->setPriceTicket($priceTicket);
                }
            } elseif ($age >= 60 && $discount === true) {
                if ($type == 'Demi-journée') {
                    $priceTicket = 10/2;
                    $ticket->setPriceTicket($priceTicket);
                } else {
                    $priceTicket = 10;
                    $ticket->setPriceTicket($priceTicket);
                }
            } else {
                echo 'Erreur';
            }

            $totalPrice += $ticket->getPriceTicket();
        }

        return $totalPrice;
    }


    public function getTotalTickets($day)
    {
        $session = new Session();
        $booking = $session->get('booking');
        $quantityPerDay = 0;
        foreach ($booking->getTickets() as $ticket) {
            $quantityPerDay++;
        }

        $repository = $this->em->getRepository('LouvreLouvreBundle:Ticket');
        $tickets = $repository->findBy(array('dateVisit' => $day));
        $quantity = 0;
        foreach ($tickets as $ticket) {
            $quantity++;
        }

        $totalTickets = $quantityPerDay + $quantity;
        return $totalTickets;
    }

    public function sendMail($email)
    {
        $session = new Session();
        $booking = $session->get('booking');
        $message = (new \Swift_Message('E-Billet'))
            ->setFrom('kavignonpro@gmail.com')
            ->setTo($email)
            ->setBody(
                $this->templating->render(
                    'LouvreLouvreBundle:Default:mail.html.twig',
                    array('booking' => $booking)
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }
}
