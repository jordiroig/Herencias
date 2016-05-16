<?php

namespace Atrapalo\InheritancesBundle\Tests\Services\Member;

use Atrapalo\InheritancesBundle\Entity\Member;
use Atrapalo\InheritancesBundle\Services\Member\Nanny;
use Atrapalo\InheritancesBundle\Tests\Abstracts\AbstractTest;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

class NannyTest extends AbstractTest
{
    public function testOrderSonsByAge()
    {
        $son1 = new Member();
        $son1->setName('son1')
             ->setBirthdate(DateTime::createFromFormat('d-m-Y', '01-01-1995'));
        $son2 = new Member();
        $son2->setName('son2')
             ->setBirthdate(DateTime::createFromFormat('d-m-Y', '01-01-1980'));
        $son3 = new Member();
        $son3->setName('son3')
             ->setBirthdate(DateTime::createFromFormat('d-m-Y', '01-01-1990'));
        $son4 = new Member();
        $son4->setName('son4')
            ->setBirthdate(DateTime::createFromFormat('d-m-Y', '01-01-1985'));

        $sons = new ArrayCollection();
        $sons->add($son1);
        $sons->add($son2);
        $sons->add($son3);
        $sons->add($son4);

        $nanny = new Nanny();
        $ordered_sons = $nanny->orderSonsByAge($sons);
        
        $previous = null;
        /** @var Member $ordered_son */
        foreach ($ordered_sons as $ordered_son) {
            if($previous instanceof Member) {
                $this->assertTrue($previous->getBirthdate() < $ordered_son->getBirthdate());
            }
            $previous = $ordered_son;
        }
    }
}