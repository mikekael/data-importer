<?php

namespace App\Service;

use App\Contract\Repository\CustomerRepositoryInterface;
use App\Contract\Service\CustomerServiceInterface;
use App\DataTransfer\CustomerViewData;
use Generator;

class CustomerService implements CustomerServiceInterface
{
    /**
     * Create instance of the customer service
     *
     * @param CustomerRepositoryInterface $repository
     */
    public function __construct(
        protected CustomerRepositoryInterface $repository
    ) {}

    /**
     * @see CustomerServiceInterface
     */
    public function get(string|int $id): ?CustomerViewData
    {
        if ($customer = $this->repository->find($id)) {
            return new CustomerViewData($customer);
        }

        return null;
    }

    /**
     * @see CustomerServiceInterface
     */
    public function all(): Generator
    {
        foreach ($this->repository->all() as $customer) {
            yield new CustomerViewData($customer);
        }
    }
}