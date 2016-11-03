<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OfficeController extends Controller
{

    /**
     * @Route("/api/v1/offices")
     */
    public function searchAction(Request $request)
    {
        //Get querystring parameters.
        $name = $request->get('location');
        $weekend = $request->get('weekend');
        $support = $request->get('support');

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Offices');

        $weekend = ($weekend == 1 ? 'Y' : 'N');
        $support = ($support == 1 ? 'Y' : 'N');

        $offices = $repository->createQueryBuilder('o')
            ->select('o.id, o.street, o.city, o.latitude, o.longitude, o.isOpenInWeekends, o.hasSupportDesk')
            ->where('o.city = :city AND o.isOpenInWeekends = :weekend AND o.hasSupportDesk = :support')
            ->setParameter('city', $name)
            ->setParameter('weekend', $weekend)
            ->setParameter('support', $support)
            ->getQuery()
            ->getResult();

        $response = new Response();
        $response->setContent(json_encode($offices));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
