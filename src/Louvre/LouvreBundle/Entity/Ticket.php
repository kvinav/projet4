<?php

namespace Louvre\LouvreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="Louvre\LouvreBundle\Repository\TicketRepository")
 */
class Ticket
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\Length(min = 2, max = 50, minMessage = "Votre nom doit contenir au moins {{ limit }} caractères", maxMessage = "Votre nom doit contenir moins de {{ limit }} caractères")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     * @Assert\Length(min = 2, max = 50, minMessage = "Votre prénom doit contenir au moins {{ limit }} caractères", maxMessage = "Votre prénom doit contenir moins de {{ limit }} caractères")
     */

    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="Country", type="string", length=255)
     * @Assert\Country(message="Merci de renseigner un pays valide")
     */
    private $country;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateOfBirth", type="date")
     * @Assert\Date(message="Merci de renseigner une date valide")
     * @Assert\LessThan("today", message="Veuillez rentrer une date valide")
     */
    private $dateOfBirth;

    /**
     * @var bool
     *
     * @ORM\Column(name="Discount", type="boolean")
     */
    private $discount = false;

    /**
     * @ORM\ManyToOne(targetEntity="Louvre\LouvreBundle\Entity\Booking", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $booking;
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
     * Set name.
     *
     * @param string $name
     *
     * @return Ticket
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname.
     *
     * @param string $surname
     *
     * @return Ticket
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname.
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set country.
     *
     * @param string $country
     *
     * @return Ticket
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country.
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set dateOfBirth.
     *
     * @param \DateTime $dateOfBirth
     *
     * @return Ticket
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth.
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set discount.
     *
     * @param bool $discount
     *
     * @return Ticket
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount.
     *
     * @return bool
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set booking.
     *
     * @param \Louvre\LouvreBundle\Entity\Booking $booking
     *
     * @return Ticket
     */
    public function setBooking(\Louvre\LouvreBundle\Entity\Booking $booking)
    {
        $this->booking = $booking;

        return $this;
    }

    /**
     * Get booking.
     *
     * @return \Louvre\LouvreBundle\Entity\Booking
     */
    public function getBooking()
    {
        return $this->booking;
    }

}
