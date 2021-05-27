<?php

namespace App\Services\Importer\Contracts;

interface DataProvider
{
    /**
     * Retrieved list of customers
     *
     * @return \App\DTO\CustomerData[]
     */
    public function getCustomers();
}