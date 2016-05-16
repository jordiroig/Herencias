<?php

namespace Atrapalo\InheritancesBundle\Tests\Services\Notary;

use Atrapalo\InheritancesBundle\Entity\Member;
use Atrapalo\InheritancesBundle\Services\Notary\Accountant;
use Atrapalo\InheritancesBundle\Services\Notary\Distributor;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;

class AccountantTest extends PHPUnit_Framework_TestCase
{
    public function testUpdateFamilyStatusByDate()
    {
        $father = new Member();
        $father ->setName('father')
            ->setBirthdate(DateTime::createFromFormat('d-m-Y', '01-01-1975'));

        $son1 = new Member();
        $son1->setName('son1')
            ->setFather($father)
            ->setBirthdate(DateTime::createFromFormat('d-m-Y', '01-01-1995'));
        $son2 = new Member();
        $son2->setName('son2')
            ->setFather($father)
            ->setBirthdate(DateTime::createFromFormat('d-m-Y', '01-01-1998'));

        $sons = new ArrayCollection(array($son1, $son2));
        $father->setSons($sons);

        $grandson1 = new Member();
        $grandson1->setName('grandson1')
            ->setFather($son1)
            ->setBirthdate(DateTime::createFromFormat('d-m-Y', '01-01-2015'));

        $son1->addSon($grandson1);

        $grandson2 = new Member();
        $grandson2->setName('grandson2')
            ->setFather($son2)
            ->setBirthdate(DateTime::createFromFormat('d-m-Y', '01-01-2014'));

        $son2->addSon($grandson2);

        // We test that distributeInheritance method is called twice
        $distributor = $this->getMockBuilder('Atrapalo\InheritancesBundle\Services\Notary\Distributor')->disableOriginalConstructor()->getMock();
        $distributor
            ->expects($this->exactly(2))
            ->method('distributeInheritance');
        /** @var Distributor $distributor */
        $accountant = new Accountant($distributor);

        $accountant->updateFamilyStatusByDate($father, DateTime::createFromFormat('d-m-Y', '01-01-2096'));

        // Same test but with an specific branch
        $distributor_branch = $this->getMockBuilder('Atrapalo\InheritancesBundle\Services\Notary\Distributor')->disableOriginalConstructor()->getMock();
        $distributor_branch
            ->expects($this->exactly(2))
            ->method('distributeInheritance');
        /** @var Distributor $distributor_branch */
        $accountant_branch = new Accountant($distributor_branch);

        $branch = new ArrayCollection(array($grandson1, $son1, $father));
        $accountant_branch->updateFamilyStatusByDate($father, DateTime::createFromFormat('d-m-Y', '01-01-2110'), $branch);
    }

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

    public function testGetFamilyHeadAndBranch()
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

        $result = $accountant->getFamilyHeadAndBranch($grandson);

        $this->assertEquals($grandfather, $result['head']);
        $expected = new ArrayCollection(array($son, $father, $grandfather));
        $this->assertEquals($expected, $result['branch']);
    }

    public function testGetTotalHeritageByMemberAndDate()
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
            ->setBirthdate(DateTime::createFromFormat('d-m-Y', '01-01-1998'));

        $sons = new ArrayCollection(array($son1, $son2));
        $father->setSons($sons);

        $grandson1 = new Member();
        $grandson1->setName('grandson1')
            ->setFather($son1)
            ->setBirthdate(DateTime::createFromFormat('d-m-Y', '01-01-2015'));

        $son1->addSon($grandson1);

        $grandson2 = new Member();
        $grandson2->setName('grandson2')
            ->setFather($son2)
            ->setBirthdate(DateTime::createFromFormat('d-m-Y', '01-01-2014'));

        $son2->addSon($grandson2);

        $distributor = $this->getMockBuilder('Atrapalo\InheritancesBundle\Services\Notary\Distributor')->disableOriginalConstructor()->getMock();
        /** @var Distributor $distributor */
        $accountant = new Accountant($distributor);

        $result = $accountant->getTotalHeritageByMemberAndDate($grandson1, DateTime::createFromFormat('d-m-Y', '01-01-2096'));

        $this->assertEquals(2001100, $result);
    }
}