<?php

namespace App\Contract\Repository;

use App\Entity\Customer;

interface CustomerRepositoryInterface
{
    /**
     * Find a customer using its email address
     *
     * @param string $email
     *
     * @return Customer|null
     */
    public function findByEmailAddress(string $email): ?Customer;

    /**
     * Save current customer retrieved the current customer with identity
     *
     * @param  Customer $customer
     *
     * @return Customer
     */
    public function save(Customer $customer): Customer;
}