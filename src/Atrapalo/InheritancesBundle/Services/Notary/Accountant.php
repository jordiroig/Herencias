<?php

namespace Atrapalo\InheritancesBundle\Services\Notary;

use Atrapalo\InheritancesBundle\Entity\Member;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @param ArrayCollection $branch
     * @return Member
     */
    public function updateFamilyStatusByDate(Member $member, DateTime $moment, ArrayCollection $branch = null)
    {
        if($member->isDead($moment) && $sons = $member->getSons()) {
            $this->distributor->distributeInheritance($member, $member->getTotalLands(), $member->getTotalMoney(), $member->getTotalProperties());

            foreach($sons as $son) {
                if($branch && $branch->contains($son)) $this->updateFamilyStatusByDate($son, $moment);
            }
        }

        return $member;
    }

    /**
     * Get member's total heritage
     *
     * @param Member $member
     * @return int
     */
    public function getTotalHeritageByMember(Member $member)
    {
        return ($member->getTotalLands() * 300) + $member->getTotalMoney() + ($member->getTotalProperties() * 1000000);
    }

    /**
     * Get member's family head and branch
     *
     * @param Member $member
     * @return array
     */
    public function getFamilyHeadAndBranch(Member $member)
    {
        $branch = new ArrayCollection();
        $father = ($member->getFather())?$member->getFather():$member;

        $branch->add($father);
        while ($father->getFather() != null) {
            $father = $father->getFather();
            $branch->add($father);
        }

        return array('head' => $father, 'branch' => $branch);
    }

    /**
     * Get member's total heritage on a given date
     * 
     * @param Member $member
     * @param DateTime $moment
     * @return int
     */
    public function getTotalHeritageByMemberAndDate(Member $member, DateTime $moment)
    {
        $head_and_branch = $this->getFamilyHeadAndBranch($member);
        $head = $head_and_branch['head'];
        $branch = $head_and_branch['branch'];

        $this->updateFamilyStatusByDate($head, $moment, $branch);
        return ($member->isDead($moment))?0:$this->getTotalHeritageByMember($member);
    }
}