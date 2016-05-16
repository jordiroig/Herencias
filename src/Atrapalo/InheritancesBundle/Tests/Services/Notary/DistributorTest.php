<?php

namespace Atrapalo\InheritancesBundle\Tests\Notary\Services;

use Atrapalo\InheritancesBundle\Entity\Member;
use Atrapalo\InheritancesBundle\Services\Notary\Distributor;
use Atrapalo\InheritancesBundle\Tests\Abstracts\AbstractTest;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

class DistributorTest extends AbstractTest
{
    public function testdistributeProperties()
    {
        $father = new Member();
        $father ->setName('father')
                ->setBirthdate(DateTime::createFromFormat('d-m-Y', '01-01-1975'))
                ->setLands(2)
                ->setMoney(1000)
                ->setProperties(4);

        $son1 = new Member();
        $son1->setName('son1')
             ->setFather($father)
             ->setBirthdate(DateTime::createFromFormat('d-m-Y', '01-01-1995'));
        $son2 = new Member();
        $son2->setName('son2')
             ->setFather($father)
             ->setBirthdate(DateTime::createFromFormat('d-m-Y', '01-01-1996'));
        $son3 = new Member();
        $son3->setName('son3')
             ->setFather($father)
             ->setBirthdate(DateTime::createFromFormat('d-m-Y', '01-01-1997'));

        $sons = new ArrayCollection(array($son1, $son2, $son3));
        $father->setSons($sons);

        $grandson1 = new Member();
        $grandson1->setName('grandson1')
                  ->setFather($son1)
                  ->setBirthdate(DateTime::createFromFormat('d-m-Y', '01-01-2015'));

        $grandsons = new ArrayCollection(array($grandson1));
        $son1->setSons($grandsons);

        $nanny = $this->mockObject('Atrapalo\InheritancesBundle\Services\Member\Nanny', [
            ['method' => 'OrderSonsByAge', 'times' => 2, 'return' => $this->onConsecutiveCalls($sons, $grandsons)]
        ]);

        $distributor = new Distributor($nanny);
        $distributor->distributeInheritance($father, $father->getLands(), $father->getMoney(), $father->getProperties());

        //Oldest son
        $this->assertEquals(2, $son1->getInheritanceLands());
        $this->assertEquals(167, $son1->getInheritanceMoney());
        $this->assertEquals(2, $son1->getInheritanceProperties());

        //Middle son
        $this->assertEquals(0, $son2->getInheritanceLands());
        $this->assertEquals(333, $son2->getInheritanceMoney());
        $this->assertEquals(1, $son2->getInheritanceProperties());

        //Youngest son
        $this->assertEquals(0, $son3->getInheritanceLands());
        $this->assertEquals(333, $son3->getInheritanceMoney());
        $this->assertEquals(1, $son3->getInheritanceProperties());

        //Grandson
        $this->assertEquals(0, $grandson1->getInheritanceLands());
        $this->assertEquals(167, $grandson1->getInheritanceMoney());
        $this->assertEquals(0, $grandson1->getInheritanceProperties());
    }
}