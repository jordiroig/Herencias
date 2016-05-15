<?php

namespace Atrapalo\InheritancesBundle\Repository;

use Atrapalo\InheritancesBundle\Entity\Member;
use Doctrine\ORM\EntityRepository;

class MemberRepository extends EntityRepository
{
    /**
     * @param $id
     * @return Member
     */
    public function find($id)
    {
        return parent::find($id);
    }
    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @return Member
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}
