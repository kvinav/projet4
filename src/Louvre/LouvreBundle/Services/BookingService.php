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

class BookingService
{
    // Calcul de l'age à partir de la date de naissance
    public function calculateAge($booking)
    {
        $dateBooking = $booking->getDateBooking();

        foreach ($booking->getTickets() as $ticket) {
            $dateOfBirth = $ticket->getDateOfBirth();

        $birthYear =  $dateOfBirth->format('Y');
        $birthMonth = $dateOfBirth->format('m');
        $birthDay =  $dateOfBirth->format('d');
        $bookingYear = $dateBooking->format('Y');
        $bookingMonth = $dateBooking->format('m');
        $bookingDay = $dateBooking->format('d');


            $age = ($bookingYear - $birthYear);
            if( ($bookingMonth - $birthMonth) == 0 && ($bookingDay - $birthDay) < 0 )
            {
                $age = ($age - 1);
            }

            $ticket->setAge($age);
        }

            return $age;

    }

    public function calculatePrice($booking)
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

                }else{
                    $priceTicket = 16;
                    $ticket->setPriceTicket($priceTicket);
                }


            }elseif ($age <= 12 && $age >= 4) {

                if ($type == 'Demi-journée') {
                    $priceTicket = 8/2;
                    $ticket->setPriceTicket($priceTicket);

                }else{
                    $priceTicket = 8;
                    $ticket->setPriceTicket($priceTicket);
                }

            }elseif ($age >= 60 && $discount === false) {

                if ($type == 'Demi-journée') {
                    $priceTicket = 12/2;
                    $ticket->setPriceTicket($priceTicket);

                }else{
                    $priceTicket = 12;
                    $ticket->setPriceTicket($priceTicket);
                }

            }elseif ($age < 4) {

                $priceTicket = 0;
                $ticket->setPriceTicket($priceTicket);

            }elseif ($age > 12 && $age < 60 && $discount === true) {

                if ($type == 'Demi-journée') {
                    $priceTicket = 10/2;
                    $ticket->setPriceTicket($priceTicket);

                }else{
                    $priceTicket = 10;
                    $ticket->setPriceTicket($priceTicket);
                }

            }elseif ($age >= 60 && $discount === true) {

                if ($type == 'Demi-journée') {
                    $priceTicket = 10/2;
                    $ticket->setPriceTicket($priceTicket);

                }else{
                    $priceTicket = 10;
                    $ticket->setPriceTicket($priceTicket);
                }

            }else{
                echo 'Erreur';
            }

            $totalPrice += $ticket->getPriceTicket();

        }

        return $totalPrice;


    }


}