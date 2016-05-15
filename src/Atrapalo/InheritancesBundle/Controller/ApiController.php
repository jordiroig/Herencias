<?php

namespace Atrapalo\InheritancesBundle\Controller;

use Atrapalo\InheritancesBundle\Entity\Member;
use DateTime;
use FOS\RestBundle\Controller\Annotations\Get;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends FOSRestController
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('AtrapaloInheritancesBundle:Default:index.html.twig');
    }

    /**
     * @Get("/heritage/{name}/{date}", name="get_heritage")
     * 
     * @param $name
     * @param $date
     * @return JsonResponse
     */
    public function getTweetsAction($name, $date)
    {
        $member = $this->getDoctrine()->getRepository('AtrapaloInheritancesBundle:Member')->findOneBy(array('name' => $name));
        $moment = DateTime::createFromFormat('d-m-Y', $date);

        $result = array();
        if($member instanceof Member && $moment instanceof DateTime) {
            $result['name'] = $member->getName();
            $result['age'] = $member->getAgeByDate($moment);
            $result['alive'] = ($member->isDead($moment))?false:true;
            $result['heritage'] = $this->get('atrapalo.inheritances.notary.accountant')->getTotalHeritageByMemberAndDate($member, $moment);
        }
        else {
            $result['error'] = '400';
            $result['error_text'] = 'Not found';
        }

        return new JsonResponse($result);
    }
}
