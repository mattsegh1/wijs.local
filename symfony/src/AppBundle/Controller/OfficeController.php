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
        return $this->render('AppBundle:Office:index.html.twig', array(
            "testval"=>"123"
        ));
    }

}
