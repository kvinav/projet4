<?php
/**
 * Created by PhpStorm.
 * User: kevinavignon
 * Date: 12/05/2018
 * Time: 12:01
 */

namespace Louvre\LouvreBundle\Services;


class CalculAge
{
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
}