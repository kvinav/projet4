<?php
/**
 * Created by PhpStorm.
 * User: kevinavignon
 * Date: 24/04/2018
 * Time: 16:11
 */
namespace Louvre\LouvreBundle\Validator;

use Louvre\LouvreBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\Session\Session;
use Louvre\LouvreBundle\Entity\Booking;


class HalfdayConstraintValidator extends ConstraintValidator
{
    public function validate($booking, $constraint)
    {

           /* $session = new Session();*/


                if ($booking !== null) {

                    // $booking = $session->get('booking');
                    $dateVisit = $booking->getDateVisit()->format('Y-m-d');
                    $dateBooking = new \DateTime();
                    $dateBookingFormat = $dateBooking->format('Y-m-d');
                    $timeBooking = $dateBooking->format('H');
                    $type = $booking->getType();


                    if ($timeBooking >= 12 && $type == 'Journée' && ($dateVisit === $dateBookingFormat)) {
                        $this->context->buildViolation($constraint->message)->atPath('type')->addViolation();

                    }
                }



    }
}