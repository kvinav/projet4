<?php
/**
 * Created by PhpStorm.
 * User: kevinavignon
 * Date: 12/05/2018
 * Time: 10:45
 */
namespace Tests\Louvre\LouvreBundle\Services;

use Louvre\LouvreBundle\Services\BookingService;
use PHPUnit\Framework\TestCase;

class BookingServiceTest extends TestCase
{

    public function testCalculatePrice()
    {
        $booking = array(
            'order' => array(
                'dateVisit'   => array(
                    'day'   => 30,
                    'month' => 01,
                    'year'  => 2020,
                ),
                'type' => 'Journée',
                'email' => 'kavignonpro@gmail.com',
                'tickets'     => array(
                    'Ticket n°1' => array(
                        'name'      => 'Avignon',
                        'surname' => 'Kevin',
                        'country'   => 'FR',
                        'discount' => true,
                        'dateOfBirth' => array(
                            'day'    => 13,
                            'month'  => 02,
                            'year'   => 1994,
                        ),
                    ),
                ),
            )
        );
        $bookingService = new BookingService($booking);

        $result = $bookingService->calculatePrice($booking);


        $this->assertEquals(10, $result);

    }


}