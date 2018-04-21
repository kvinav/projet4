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

class LouvreController extends Controller
{
    public function homeAction()
    {
        $content = $this->get('templating')->render('LouvreLouvreBundle:Default:home.html.twig');
        return new Response($content);
    }

    public function noticeAction()
    {
        $content = $this->get('templating')->render('LouvreLouvreBundle:Default:notice.html.twig');
        return new Response($content);
    }

    public function orderAction(Request $request)
    {
        $booking = new Booking();
        $form   = $this->get('form.factory')->create(BookingType::class, $booking);


        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($booking);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Réservation effectuée');
            return $this->redirectToRoute('louvre_louvre_home');

        }
        return $this->render('LouvreLouvreBundle:Default:order.html.twig',array(
            'form' => $form->createView(),
        ));
    }

}