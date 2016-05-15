<?php

namespace Atrapalo\InheritancesBundle\Services\Notary;

use ArrayIterator;
use Atrapalo\InheritancesBundle\Entity\Member;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Distributor
{
    public function __construct()
    {

    }

    public function distributeInheritance(Member $member, $lands = 0, $money = 0, $properties = 0)
    {
        $sons = $member->getSons();
        if(count($sons)) {
            //We must order the sons by its age(desc)
            $sons = $this->orderSonsByAge($sons);

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

            /** @var Member $son */
            foreach ($sons as $son) {
                echo $son->getName()." - ".$son->getInheritanceMoney()." - ".$son->getInheritanceLands()." - ".$son->getInheritanceProperties()."<br /><br />";
            }
        }
    }

    /**
     * Order sons by age
     *
     * @param Collection $sons
     * @return ArrayCollection
     */
    private function orderSonsByAge(Collection $sons)
    {
        $iterator = $sons->getIterator();
        /** @var ArrayIterator $iterator */
        $iterator->uasort(function (Member $a, Member $b) {
            if($a->getBirthdate() == $b->getBirthdate()) return ($a->getName() < $b->getName()) ? -1:1;
            return ($a->getBirthdate() < $b->getBirthdate()) ? -1:1;
        });
        return new ArrayCollection(iterator_to_array($iterator));
    }

    private function distributeMoney(ArrayCollection $sons, $money)
    {
        $sons_number = count($sons);
        $money_son = floor($money / $sons_number);
        $money_rest = ($money % $sons_number);
        /** @var Member $son */
        foreach ($sons as $son) {
            $rest = 0;
            if ($money_rest > 0) {
                $rest = 1;
                $money_rest--;
            }
            $son->addInheritanceMoney($money_son + $rest);
        }
    }

    private function distributeLands(ArrayCollection $sons, $lands)
    {
        /** @var Member $oldest_son */
        $oldest_son = $sons->first();
        $oldest_son->addInheritanceLands($lands);
    }

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