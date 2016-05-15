<?php

namespace Atrapalo\InheritancesBundle\Services\Notary;

use Atrapalo\InheritancesBundle\Entity\Member;
use Atrapalo\InheritancesBundle\Services\Member\Nanny;
use Doctrine\Common\Collections\ArrayCollection;

class Distributor
{
    private $nanny;

    /**
     * Distributor constructor
     * 
     * @param Nanny $nanny
     */
    public function __construct(
        Nanny $nanny
    ) {
        $this->nanny = $nanny;
    }

    /**
     * Distribute member's inheritance
     * 
     * @param Member $member
     * @param int $lands
     * @param int $money
     * @param int $properties
     */
    public function distributeInheritance(Member $member, $lands = 0, $money = 0, $properties = 0)
    {
        $sons = $member->getSons();

        if(count($sons)) {
            //We must order the sons by its age(desc)
            $sons = $this->nanny->orderSonsByAge($sons);

            //We distribute the money to the sons
            if($money > 0) {
                $this->distributeMoney($sons, $money);
            }

            //We distribute the lands to the sons
            if($lands > 0) {
                $this->distributeLands($sons, $lands);
            }

            //We distribute the properties to the sons
            if($properties > 0) {
                $this->distributeProperties($sons->toArray(), $properties);
            }
        }
    }

    /**
     * Distribute money to the sons of a member
     *
     * @param ArrayCollection $sons
     * @param $money
     */
    private function distributeMoney(ArrayCollection $sons, $money)
    {
        $sons_number = count($sons);
        if($sons_number > 0) {
            $money_son = floor($money / $sons_number);
            $money_rest = ($money % $sons_number);
            /** @var Member $son */
            foreach ($sons as $son) {
                if ($money_rest > 0) {
                    $money_inheritance = $money_son + 1;
                    $money_rest--;
                } else {
                    $money_inheritance = $money_son;
                }

                $grandsons = $son->getSons();
                if (count($grandsons) > 0) {
                    $grandsons = $this->nanny->orderSonsByAge($grandsons);
                    $son_inheritance = ceil($money_inheritance / 2);
                    $son->addInheritanceMoney($son_inheritance);
                    $grandsons_inheritance = floor($money_inheritance / 2);
                    if ($grandsons_inheritance > 0) {
                        $this->distributeMoney($grandsons, $grandsons_inheritance);
                    }
                } else {
                    $son->addInheritanceMoney($money_inheritance);
                }
            }
        }
    }

    /**
     * Distribute lands to the sons of a member
     *
     * @param ArrayCollection $sons
     * @param $lands
     */
    private function distributeLands(ArrayCollection $sons, $lands)
    {
        /** @var Member $oldest_son */
        $oldest_son = $sons->first();
        $oldest_son->addInheritanceLands($lands);
    }

    /**
     * Distribute properties to the sons of a member
     *
     * @param array $sons_array
     * @param $properties
     */
    private function distributeProperties(Array $sons_array, $properties)
    {
        $sons_array = array_reverse($sons_array);

        /** @var Member $son */
        foreach ($sons_array as $son) {
            $son->addInheritanceProperties(1);
            $properties--;
            if($properties == 0) break;
        }

        if($properties > 0) {
            $this->distributeProperties($sons_array, $properties);
        }
    }
}