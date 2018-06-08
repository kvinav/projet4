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
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BookingService
{
    protected $mailer;
    protected $templating;
    protected $calculAge;
    protected $normal;
    protected $reduit;
    protected $senior;
    protected $enfant;

    public function __construct(\Swift_Mailer $mailer, $templating, CalculAge $calculAge, $normal, $senior, $reduit, $enfant)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->calculAge = $calculAge;
        $this->normal = $normal;
        $this->reduit = $reduit;
        $this->senior = $senior;
        $this->enfant = $enfant;
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
                    $priceTicket = $this->normal/2;
                    $ticket->setPriceTicket($priceTicket);
                } else {
                    $priceTicket = $this->normal;
                    $ticket->setPriceTicket($priceTicket);
                }
            } elseif ($age <= 12 && $age >= 4) {
                if ($type == 'Demi-journée') {
                    $priceTicket = $this->enfant/2;
                    $ticket->setPriceTicket($priceTicket);
                } else {
                    $priceTicket = $this->enfant;
                    $ticket->setPriceTicket($priceTicket);
                }
            } elseif ($age >= 60 && $discount === false) {
                if ($type == 'Demi-journée') {
                    $priceTicket = $this->senior/2;
                    $ticket->setPriceTicket($priceTicket);
                } else {
                    $priceTicket = $this->senior;
                    $ticket->setPriceTicket($priceTicket);
                }
            } elseif ($age < 4) {
                $priceTicket = 0;
                $ticket->setPriceTicket($priceTicket);
            } elseif ($age > 12 && $age < 60 && $discount === true) {
                if ($type == 'Demi-journée') {
                    $priceTicket = $this->reduit/2;
                    $ticket->setPriceTicket($priceTicket);
                } else {
                    $priceTicket = $this->reduit;
                    $ticket->setPriceTicket($priceTicket);
                }
            } elseif ($age >= 60 && $discount === true) {
                if ($type == 'Demi-journée') {
                    $priceTicket = $this->reduit/2;
                    $ticket->setPriceTicket($priceTicket);
                } else {
                    $priceTicket = $this->reduit;
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
