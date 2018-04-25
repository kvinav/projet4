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

            $session = new Session();


                if ($booking = $session->get('booking') !== null) {
                    $booking = $session->get('booking');
                    $dateVisit = $booking->getDateVisit()->format('Y-m-d');
                    $dateBooking = $booking->getDateBooking()->format('Y-m-d');
                    $timeBooking = $booking->getDateBooking()->format('H');
                    $type = $booking->getType();


                    if ($timeBooking >= 14 && $type == 'Journée' && ($dateVisit === $dateBooking)) {
                        $this->context->buildViolation($constraint->message)->atPath('type')->addViolation();
                        $session->remove('booking');

                    }
                }



    }
}