<?php

namespace App\Service\Importer\Contract;

interface DataProviderInterface
{
    /**
     * Provide list of customers
     *
     * @return \App\Service\Importer\CustomerData[]
     */
    public function getCustomers(): iterable;
}