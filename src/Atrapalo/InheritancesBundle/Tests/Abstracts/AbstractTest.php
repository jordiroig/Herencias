<?php

namespace Atrapalo\InheritancesBundle\Tests\Abstracts;

use PHPUnit_Framework_TestCase;

class AbstractTest extends PHPUnit_Framework_TestCase
{
    protected function mockObject($class, $params = array())
    {
        $mocked = $this->getMockBuilder($class)->disableOriginalConstructor()->getMock();
        foreach( $params as $param )
        {
            $mocked->expects($this->exactly($param['times']))
                ->method($param['method'])
                ->willReturn($param['return']);
        }
        return $mocked;
    }

    protected function mockObjectWith($class, $params = array())
    {
        $mocked = $this->getMockBuilder($class)->disableOriginalConstructor()->getMock();
        foreach( $params as $param )
        {
            $mocked->expects($this->exactly($param['times']))
                ->method($param['method'])
                ->with($param['with'])
                ->willReturn($param['return']);
        }
        return $mocked;
    }
}