<?php

namespace Atrapalo\InheritancesBundle\Tests\Notary\Services;

use Atrapalo\InheritancesBundle\Services\Notary\Distributor;
use Atrapalo\InheritancesBundle\Tests\Abstracts\AbstractTest;

class DistributorTest extends AbstractTest
{

    public function testdistributeProperties()
    {
        $nanny = $this->mockObject('Atrapalo\InheritancesBundle\Services\Member\Nanny');
        
        $distributor = new Distributor($nanny);

        
    }



}