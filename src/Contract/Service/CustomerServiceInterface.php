<?php

namespace App\Contract\Service;

use App\DataTransfer\CustomerViewData;

interface CustomerServiceInterface
{
    /**
     * Retrieve all customer records
     *
     * @return iterable|CustomerViewData[]
     */
    public function all(): iterable;

    /**
     * Retrieve a single customer record by its identity
     *
     * @param string|int $id
     *
     * @return CustomerViewData|null
     */
    public function get(string | int $id): ?CustomerViewData;
}