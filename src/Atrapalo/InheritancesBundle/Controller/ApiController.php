<?php

namespace Atrapalo\InheritancesBundle\Controller;

use Atrapalo\InheritancesBundle\Entity\Member;
use DateTime;
use FOS\RestBundle\Controller\Annotations\Get;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        $moment = DateTime::createFromFormat('dd-mm-YYYY', $date);

        if($member instanceof Member && $moment instanceof DateTime) {
            $heritage = $this->get('atrapalo.inheritances.notary.accountant')->getTotalHeritageByMemberAndDate($member, $moment);
            return new JsonResponse($heritage);
        }

        throw new HttpException(400, "Not found");
    }
}
