<?php

namespace Atrapalo\InheritancesBundle\Controller;

use Atrapalo\InheritancesBundle\Entity\Member;
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
        $this->get('atrapalo.inheritances.notary.distributor')->distributeInheritance($manel, 20 , 1000, 8);


        $sons = $manel->getSons();

        /** @var Member $son */
        foreach ($sons as $son) {
            echo $son->getName()." - ".$son->getInheritanceMoney()." - ".$son->getInheritanceLands()." - ".$son->getInheritanceProperties()."<br /><br />";
            if($grandsons = $son->getSons()) {
                foreach ($grandsons as $grandson) {
                    echo "&nbsp;&nbsp;&nbsp;".$grandson->getName()." - ".$grandson->getInheritanceMoney()." - ".$grandson->getInheritanceLands()." - ".$grandson->getInheritanceProperties()."<br /><br />";
                }
            }
        }
        return $this->render('AtrapaloInheritancesBundle:Default:index.html.twig');
    }
}
