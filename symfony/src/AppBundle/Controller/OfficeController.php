<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class OfficeController extends Controller
{
    /**
     * @Route("/offices")
     */
    public function updateAction(Request $request)
    {
        //TEMP
        $em = $this->getDoctrine()->getManager();
        $offices = $em->getRepository('AppBundle:Offices')->findAll();
        dump($offices); // Dump to the Symfony Development Toolbar.
        //END TEMP


        //Get querystring parameters.
        $name = $request->get('location');
        $weekend = $request->get('weekend');
        $support = $request->get('support');

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Offices');

        $query = $repository->createQueryBuilder('o')
            ->select('o.id, o.street, o.city, o.latitude, o.longitude, o.isOpenInWeekends, o.hasSupportDesk')
            ->where('o.city = :city')
            ->setParameter('city', $name);
            //->setParameter('support', $supportdesk)
            //->setParameter('weekend', $weekend)

        if($weekend)
        {
            $query->andWhere('o.isOpenInWeekends = :weekend')
                  ->setParameter('weekend', $weekend);
        }
        if($support)
        {
            $query->andWhere('o.hasSupportDesk = :support')
                ->setParameter('support', $support);
        }

        $offices = $query->getQuery()->getResult();

        return $this->render('AppBundle:Office:index.html.twig', array(
            "offices"=> $offices
        ));
    }

}
