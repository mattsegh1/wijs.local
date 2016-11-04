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
        $location = $request->get('location');
        $weekend = $request->get('weekend');
        $support = $request->get('support');
        $range = $request->get('range');

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Offices');

        $weekend = ($weekend == 1 ? 'Y' : 'N');
        $support = ($support == 1 ? 'Y' : 'N');

        // Get location and latitude for the location
        $geoLoc = $this->container
            ->get('bazinga_geocoder.geocoder')
            ->using('google_maps')
            ->geocode("gent");
        $locLatLong = $geoLoc->first();
        $lat = $locLatLong->getLatitude();
        $long = $locLatLong->getLongitude();

        $classLoader = new \Doctrine\Common\ClassLoader('DoctrineExtensions', '/path/to/extensions');
        $classLoader->register();

        $offices = $repository->createQueryBuilder('o')
            ->select('o.id, o.street, o.city, o.latitude, o.longitude, o.isOpenInWeekends, o.hasSupportDesk')
            ->addSelect('6371 * 2 * ASIN ( SQRT (POWER(SIN((:lat - o.latitude)*pi()/180 / 2),2) + COS(:lat * pi()/180) * COS(o.latitude *pi()/180) * POWER(SIN((:long - o.longitude) *pi()/180 / 2), 2) ) ) as distance')
            ->where('o.isOpenInWeekends = :weekend AND o.hasSupportDesk = :support')
            ->having('distance < :range')
            ->setParameter('weekend', $weekend)
            ->setParameter('support', $support)
            ->setParameter('lat', $lat)
            ->setParameter('long', $long)
            ->setParameter('range', $range)
            ->orderBy('distance')
            ->getQuery()
            ->getResult();

        $response = new Response();
        $response->setContent(json_encode($offices));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
