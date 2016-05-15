<?php

namespace Atrapalo\InheritancesBundle\Services\Member;

use ArrayIterator;
use Atrapalo\InheritancesBundle\Entity\Member;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Nanny
{
    /**
     * Order sons by age
     *
     * @param Collection $sons
     * @return ArrayCollection
     */
    public function orderSonsByAge(Collection $sons)
    {
        $iterator = $sons->getIterator();
        /** @var ArrayIterator $iterator */
        $iterator->uasort(function (Member $a, Member $b) {
            if($a->getBirthdate() == $b->getBirthdate()) return ($a->getName() < $b->getName()) ? -1:1;
            return ($a->getBirthdate() < $b->getBirthdate()) ? -1:1;
        });
        return new ArrayCollection(iterator_to_array($iterator));
    }
}