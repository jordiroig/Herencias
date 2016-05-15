<?php

namespace Atrapalo\InheritancesBundle\Controller;

use Atrapalo\InheritancesBundle\Entity\Member;
use DateTime;
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
        $moment = DateTime::createFromFormat('d-m-Y', '01-01-2025');
        $this->get('atrapalo.inheritances.notary.accountant')->updateFamilyStatusByDate($manel, $moment);

        $sons = $manel->getSons();

        /** @var Member $son */
        foreach ($sons as $son) {
            echo $son->getName()." - ".($son->isDead($moment))?"mort":"viu"." - ".$son->getInheritanceMoney()." - ".$son->getInheritanceLands()." - ".$son->getInheritanceProperties()."<br /><br />";
            if($grandsons = $son->getSons()) {
                foreach ($grandsons as $grandson) {
                    echo "&nbsp;&nbsp;&nbsp;".$grandson->getName()." - ".($son->isDead($moment))?"mort":"viu"." - ".$grandson->getInheritanceMoney()." - ".$grandson->getInheritanceLands()." - ".$grandson->getInheritanceProperties()."<br /><br />";
                }
            }
        }
        return $this->render('AtrapaloInheritancesBundle:Default:index.html.twig');
    }
}
