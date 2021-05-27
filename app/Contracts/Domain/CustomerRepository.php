<?php

namespace App\Contracts\Domain;

use App\Contracts\Domain\UniqueId;
use App\Entities\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CustomerRepository
{
    /**
     * Retrieved the next unique identity
     *
     * @return \App\Contracts\Domain\UniqueId
     */
    public function getNextIdentity(): UniqueId;

    /**
     * Find a customer record based on its unique email address
     *
     * @param  string $email
     *
     * @return \App\Entities\Customer|null
     */
    public function findByEmail(string $email): ?Customer;

    /**
     * Find a customer record based on its unique identity
     *
     * @param  \App\Contracts\Domain\UniqueId $id
     *
     * @return \App\Entities\Customer|null
     */
    public function find(UniqueId $id): ?Customer;

    /**
     * Retrieved all customers
     *
     * @param int $perPage
     * @param int $page
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all(int $perPage = 100, int $page = 1): LengthAwarePaginator;
}