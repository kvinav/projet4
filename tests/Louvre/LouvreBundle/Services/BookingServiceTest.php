<?php
/**
 * Created by PhpStorm.
 * User: kevinavignon
 * Date: 12/05/2018
 * Time: 10:45
 */
namespace Tests\Louvre\LouvreBundle\Services;

use Louvre\LouvreBundle\Entity\Booking;
use Louvre\LouvreBundle\Services\CalculAge;
use PHPUnit\Framework\TestCase;

class BookingServiceTest extends TestCase
{
    protected $booking;

    public function setUp()
    {
        parent::setUp();

        $dateVisit = new \DateTime('2020-01-30');
        $dateNaissance = new \DateTime('1994-02-13');


        $this->booking = new Booking();
        $this->booking->setDateVisit($dateVisit);
        $ticket = $this->booking->getTickets()[0];
        $ticket->setDateOfBirth($dateNaissance);
        $this->booking->addTicket($ticket);
        $calculAge = new CalculAge();

        $calculAge->calculateAge($this->booking);

    }

    public function testCalculateAge()
    {

        $ticket = $this->booking->getTickets()[0];

        $this->assertEquals(24, $ticket->getAge());

    }


}