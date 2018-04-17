<?php

namespace Louvre\LouvreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="Louvre\LouvreBundle\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateBooking", type="datetime")
     */
    private $dateBooking;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateVisit", type="datetime")
     * @Asserts\Date()
     */
    private $dateVisit;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;
    /**
     * @ORM\OneToMany(targetEntity="Louvre\LouvreBundle\Entity\Ticket", mappedBy="booking")
     */
    private $tickets;

    public function __construct()
    {
        $this->dateBooking = new \Datetime();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateBooking.
     *
     * @param \DateTime $dateBooking
     *
     * @return Booking
     */
    public function setDateBooking($dateBooking)
    {
        $this->dateBooking = $dateBooking;

        return $this;
    }

    /**
     * Get dateBooking.
     *
     * @return \DateTime
     */
    public function getDateBooking()
    {
        return $this->dateBooking;
    }
    

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return Booking
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Booking
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set price.
     *
     * @param int $price
     *
     * @return Booking
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Add ticket.
     *
     * @param \Louvre\LouvreBundle\Entity\Ticket $ticket
     *
     * @return Booking
     */
    public function addTicket(\Louvre\LouvreBundle\Entity\Ticket $ticket)
    {
        $this->tickets[] = $ticket;

        return $this;
    }

    /**
     * Remove ticket.
     *
     * @param \Louvre\LouvreBundle\Entity\Ticket $ticket
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTicket(\Louvre\LouvreBundle\Entity\Ticket $ticket)
    {
        return $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Set dateVisit.
     *
     * @param \DateTime $dateVisit
     *
     * @return Booking
     */
    public function setDateVisit($dateVisit)
    {
        $this->dateVisit = $dateVisit;

        return $this;
    }

    /**
     * Get dateVisit.
     *
     * @return \DateTime
     */
    public function getDateVisit()
    {
        return $this->dateVisit;
    }
}
