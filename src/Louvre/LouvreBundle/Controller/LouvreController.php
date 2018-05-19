<?php
/**
 * Created by PhpStorm.
 * User: kevinavignon
 * Date: 11/04/2018
 * Time: 15:42
 */

namespace Louvre\LouvreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Louvre\LouvreBundle\Entity\Booking;
use Louvre\LouvreBundle\Form\BookingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LouvreController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function homeAction()
    {
        return $this->render('LouvreLouvreBundle:Default:home.html.twig');
    }

    /**
     * @Route("/notice", name="notice")
     */
    public function noticeAction()
    {
        return $this->render('LouvreLouvreBundle:Default:notice.html.twig');
    }

    /**
     * @Route("/order", name="order")
     *
     */
    public function orderAction(Request $request)
    {
        $booking = new Booking();

        $form = $this->get('form.factory')->create(BookingType::class, $booking);
        $form->handleRequest($request);


        if ($form->isSubmitted()) {
            $session = $request->getSession();
            $booking = $form->getData();
            $session->set('booking', $booking);

            if ($form->isValid()) {
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

        return $this->render('LouvreLouvreBundle:Default:order.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/payment", name="payment")
     */
    public function paymentAction(SessionInterface $session)
    {
        $booking = $session->get('booking');
        if ($booking === null) {
            return $this->redirectToRoute("home");
        }
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
     * @Route("/checkout", name="order_checkout")
     */
    public function checkoutAction(SessionInterface $session)
    {
        $booking = $session->get('booking');
        if ($booking === null) {
            return $this->redirectToRoute("home");
        }
        // if booking null -> rediriger page accueil
        $amount = $booking->getPrice();
        $token = $_POST['stripeToken'];

        $stripeService = $this->container->get('louvre_louvre.stripe');

        try {
            $stripeService->stripePayment($token, $amount);
            return $this->redirectToRoute("resume");
        } catch (\Stripe\Error\Card $e) {
            return $this->redirectToRoute("order_checkout");
        }
    }

    /**
     * @Route("/resume", name="resume")
     */
    public function resumeAction(SessionInterface $session)
    {
        $booking = $session->get('booking');
        if ($booking === null) {
            return $this->redirectToRoute("home");
        }
        $em = $this->getDoctrine()->getManager();

        $email = $booking->getEmail();
        $bookingService = $this->container->get('louvre_louvre.booking');
        $bookingService->sendMail($email);

        $em->persist($booking);
        $em->flush();
        $session->remove('booking');


        return $this->render('LouvreLouvreBundle:Default:resume.html.twig', array(
            'booking' => $booking,
        ));
    }
}
