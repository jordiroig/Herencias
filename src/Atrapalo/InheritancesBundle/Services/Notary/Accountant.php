<?php

namespace Atrapalo\InheritancesBundle\Services\Notary;

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

    

}