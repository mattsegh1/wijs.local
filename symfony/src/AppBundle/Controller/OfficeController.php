<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class OfficeController extends Controller
{
    /**
     * @Route("/offices")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $offices = $em->getRepository('AppBundle:Offices')->findAll();

        dump($offices); // Dump to the Symfony Development Toolbar.

        return $this->render('AppBundle:Office:index.html.twig', array(
            "offices"=> $offices
        ));
    }

}
