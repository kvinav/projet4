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



        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
           $session = $request->getSession();
           $booking = $form->getData();
           $session->set('booking', $booking);
           $session->getFlashBag()->add('info', 'Les billets ont bien été enregistrés, vous pouvez procéder au paiement.');





            return $this->redirectToRoute('payment');

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


        return $this->render('LouvreLouvreBundle:Default:payment.html.twig');
    }

}