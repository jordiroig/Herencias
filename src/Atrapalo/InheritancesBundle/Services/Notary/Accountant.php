<?php

namespace Atrapalo\InheritancesBundle\Services\Notary;

use Atrapalo\InheritancesBundle\Entity\Member;
use DateTime;

class Accountant
{
    private $distributor;

    /**
     * Accountant constructor
     *
     * @param Distributor $distributor
     */
    public function __construct(
        Distributor $distributor
    ) {
        $this->distributor = $distributor;
    }

    /**
     * Update family status
     *
     * @param Member $member
     * @param DateTime $moment
     * @return Member
     */
    public function updateFamilyStatusByDate(Member $member, DateTime $moment)
    {
        if($member->isDead($moment) && $sons = $member->getSons()) {
            $lands = $member->getLands() + $member->getInheritanceLands();
            $money = $member->getMoney() + $member->getInheritanceMoney();
            $properties = $member->getProperties() + $member->getInheritanceProperties();

            $this->distributor->distributeInheritance($member, $lands, $money, $properties);

            foreach($sons as $son) {
                $this->updateFamilyStatusByDate($son, $moment);
            }
        }

        return $member;
    }

}