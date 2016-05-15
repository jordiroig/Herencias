<?php

namespace Atrapalo\InheritancesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $manel = $this->getDoctrine()->getRepository('AtrapaloInheritancesBundle:Member')->find(1);
        $this->get('atrapalo.inheritances.notary.distributor')->distributeInheritance($manel);
        
        return $this->render('AtrapaloInheritancesBundle:Default:index.html.twig');
    }
}
