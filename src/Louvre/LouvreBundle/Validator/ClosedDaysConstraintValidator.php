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


class ClosedDaysConstraintValidator extends ConstraintValidator
{
    public function validate($booking, $constraint)
    {

        $session = new Session();


        if ($booking = $session->get('booking') !== null) {
            $booking = $session->get('booking');
            $closedDay = $booking->getDateVisit()->format('w');
            $publicHoliday = $booking->getDateVisit()->format('d-m');


            if ($closedDay == 0 || $closedDay == 2 || $publicHoliday == '01-05' || $publicHoliday == '01-10' || $publicHoliday == '25-12') {
                $this->context->buildViolation($constraint->message)->atPath('type')->addViolation();
                $session->remove('booking');

            }
        }



    }
}