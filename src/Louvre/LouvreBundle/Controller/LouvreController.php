<?php
/**
 * Created by PhpStorm.
 * User: kevinavignon
 * Date: 11/04/2018
 * Time: 15:42
 */
namespace Louvre\LouvreBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
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

    public function orderAction()
    {
        $content = $this->get('templating')->render('LouvreLouvreBundle:Default:order.html.twig');
        return new Response($content);
    }

}