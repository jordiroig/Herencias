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
}