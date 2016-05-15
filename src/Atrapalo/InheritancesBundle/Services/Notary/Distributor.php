<?php

namespace Atrapalo\InheritancesBundle\Services\Notary;

use Atrapalo\InheritancesBundle\Entity\Member;

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

            //We must order the sons by its age
           uasort($sons->toArray(), function(Member $a, Member $b){
               return ($a->getBirthdate() < $b->getBirthdate())?1:-1;
           });
            
            //We distribute the money to the sons
            $money_son = floor($money / $sons_number);
            $money_rest = ($money % $sons_number);
            /** @var Member $son */
            foreach ($sons as $son) {
                $rest = 0;
                if($money_rest > 0) {
                    $rest = 1;
                    $money_rest--;
                }
                $son->addInheritanceMoney($money_son + $rest);
            }

            //We distribute the lands to the sons



            
            
        }
    }







}