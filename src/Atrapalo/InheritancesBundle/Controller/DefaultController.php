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
        $julia = $this->getDoctrine()->getRepository('AtrapaloInheritancesBundle:Member')->find(5);
        $moment = DateTime::createFromFormat('d-m-Y', '01-01-2075');
        echo $this->get('atrapalo.inheritances.notary.accountant')->getTotalHeritageByMemberAndDate($julia, $moment)."<br /><br /><br />";

        return $this->render('AtrapaloInheritancesBundle:Default:index.html.twig');
    }
}