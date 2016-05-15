<?php

namespace Atrapalo\InheritancesBundle\Services\Notary;

use ArrayIterator;
use Atrapalo\InheritancesBundle\Entity\Member;
use Doctrine\Common\Collections\ArrayCollection;

class Distributor
{
    public function __construct()
    {

    }

    public function distributeInheritance(Member $member, $lands = 0, $money = 0, $properties = 0)
    {
        $sons = $member->getSons();
        $sons_number = count($sons);
        if($sons_number) {
            //We must order the sons by its age(desc)
            $iterator = $sons->getIterator();
            /** @var ArrayIterator $iterator */
            $iterator->uasort(function (Member $a, Member $b) {
                if($a->getBirthdate() == $b->getBirthdate()) return ($a->getName() < $b->getName()) ? -1:1;
                return ($a->getBirthdate() < $b->getBirthdate()) ? -1:1;
            });
            $sons = new ArrayCollection(iterator_to_array($iterator));

            //We distribute the money to the sons
            if($money > 0) {
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

            //We distribute the lands to the sons
            if($lands > 0) {
                /** @var Member $oldest_son */
                $oldest_son = $sons->first();
                $oldest_son->addInheritanceLands($lands);
            }

            //We distribute the properties to the sons
            if($properties > 0) {
                $sons_array = $sons->toArray();
                $this->distributeProperties($sons_array, $properties);
            }
        }
    }
    
    private function distributeProperties(Array $sons_array, $properties)
    {
        /** @var Member $son */
        foreach ($sons_array as $son) {
            $son->addInheritanceProperties(1);
            $properties--;
            if($properties == 0) break;
        }
        if($properties > 0) {
            $sons_array = array_reverse($sons_array);
            $this->distributeProperties($sons_array, $properties);
        }
    }







}