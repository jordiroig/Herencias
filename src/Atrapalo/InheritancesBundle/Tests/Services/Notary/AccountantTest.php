<?php

namespace Atrapalo\InheritancesBundle\Tests\Services\Notary;

use Atrapalo\InheritancesBundle\Entity\Member;
use Atrapalo\InheritancesBundle\Services\Notary\Accountant;
use Atrapalo\InheritancesBundle\Services\Notary\Distributor;
use PHPUnit_Framework_TestCase;

class AccountantTest extends PHPUnit_Framework_TestCase
{
    public function testGetTotalHeritageByMember()
    {
        $distributor = $this->getMockBuilder('Atrapalo\InheritancesBundle\Services\Notary\Distributor')->disableOriginalConstructor()->getMock();
        /** @var Distributor $distributor */
        $accountant = new Accountant($distributor);

        $member = new Member();
        $member
            ->setName('member')
            ->setLands(1)
            ->setInheritanceLands(2)
            ->setMoney(500)
            ->setInheritanceMoney(200)
            ->setProperties(1)
            ->setInheritanceProperties(2);

        $result = $accountant->getTotalHeritageByMember($member);

        $this->assertEquals(3001600, $result);
    }

    public function testGetFamilyHead()
    {
        $distributor = $this->getMockBuilder('Atrapalo\InheritancesBundle\Services\Notary\Distributor')->disableOriginalConstructor()->getMock();
        /** @var Distributor $distributor */
        $accountant = new Accountant($distributor);

        $grandfather = new Member();
        $grandfather->setName('Joan');

        $father = new Member();
        $father ->setName('Oriol')
                ->setFather($grandfather);

        $grandfather->addSon($father);

        $son = new Member();
        $son->setName('Manel')
            ->setFather($father);

        $father->addSon($son);

        $grandson = new Member();
        $grandson->setName('Enric')
                 ->setFather($son);

        $son->addSon($grandson);

        $result = $accountant->getFamilyHead($grandson);

        $this->assertEquals($grandfather, $result);
    }
}