<?php
/**
 * Created by PhpStorm.
 * User: kevinavignon
 * Date: 11/04/2018
 * Time: 15:42
 */
namespace Louvre\LouvreBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Louvre\LouvreBundle\Entity\Booking;
use Louvre\LouvreBundle\Entity\Ticket;
use Louvre\LouvreBundle\Form\BookingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class LouvreController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function homeAction()
    {
        $content = $this->get('templating')->render('LouvreLouvreBundle:Default:home.html.twig');
        return new Response($content);
    }

    /**
     * @Route("/notice", name="notice")
     */
    public function noticeAction()
    {
        $content = $this->get('templating')->render('LouvreLouvreBundle:Default:notice.html.twig');
        return new Response($content);
    }

    /**
     * @Route("/order", name="order")
     *
     */
    public function orderAction(Request $request)
    {
        $booking = new Booking();

        $form   = $this->get('form.factory')->create(BookingType::class, $booking);
        $form->handleRequest($request);


        if ($form->isSubmitted()) {


             $session = $request->getSession();
             $booking = $form->getData();
             $session->set('booking', $booking);


            if ($form->isValid()){

                $bookingService = $this->container->get('louvre_louvre.booking');
                $bookingService->calculateAge($booking);



                $price = $bookingService->calculatePrice($booking);
                $booking->setPrice($price);

                $session->getFlashBag()->add('info', 'Les billets ont bien été enregistrés, vous pouvez procéder au paiement.');



                return $this->redirectToRoute('payment', array(
                    'price' => $price,
                ));

            }
        }

        return $this->render('LouvreLouvreBundle:Default:order.html.twig',array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @Route("/payment", name="payment")
     */
    public function paymentAction(Request $request)
    {

        $session = new Session();
        $booking = $session->get('booking');
        $validNumberService = $this->container->get('louvre_louvre.validNumber');
        $todayDate = $booking->getDateVisit();
        $totalTickets = $validNumberService->getTotalTickets($todayDate);


        if ($totalTickets > 1000) {
            $session->getFlashBag()->add(
                'notice',
                'Les réservations sont complètes pour ce jour là'
            );
            return $this->redirectToRoute('order');

        }

        return $this->render('LouvreLouvreBundle:Default:payment.html.twig', array(
            'booking' => $booking,
        ));
    }

    /**
     * @Route("/checkout", name="order_checkout", methods="POST")
     */
    public function checkoutAction(Request $request)
    {
        $session = new Session();
        $booking = $session->get('booking');
        $amount = $booking->getPrice();

        \Stripe\Stripe::setApiKey("sk_test_qAyRDTaNGJTzEnxhPHrBsvm1");

        // Get the credit card details submitted by the form
        $token = $_POST['stripeToken'];


        // Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $amount*100, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Billetterie Louvre"
            ));
            $this->addFlash("success","Bravo ça marche !");
            return $this->redirectToRoute("resume");
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("error","Snif ça marche pas :(");
            return $this->redirectToRoute("order_checkout");
            // The card has been declined
        }
    }

    /**
     * @Route("/resume", name="resume")
     */
    public function resumeAction()
    {

        $session = new Session();
        $booking = $session->get('booking');



        return $this->render('LouvreLouvreBundle:Default:resume.html.twig', array(
            'booking' => $booking,
        ));

    }

}