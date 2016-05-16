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

        $nanny = $this->mockObject('Atrapalo\InheritancesBundle\Services\Member\Nanny', [
            ['method' => 'OrderSonsByAge', 'times' => 1, 'return' => new ArrayCollection(array($son1, $son2, $son3))]
        ]);

        $distributor = new Distributor($nanny);
        $distributor->distributeInheritance($father, $father->getLands(), $father->getMoney(), $father->getProperties());


        die(var_dump($son1));
    }



}