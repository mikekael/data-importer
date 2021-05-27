<?php

namespace App\Infrastructure\Repositories;

use App\Contracts\Domain\CustomerRepository as CustomerRepositoryInterface;
use App\Contracts\Domain\UniqueId;
use App\Entities\Customer;
use App\Infrastructure\Uuid;
use Doctrine\Persistence\ObjectRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Facades\EntityManager;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

class CustomerRepository implements CustomerRepositoryInterface
{
    use PaginatesFromParams;

    /**
     * @var \Doctrine\Persistence\ObjectRepository
     */
    protected ObjectRepository $customers;

    /**
     * Create instance
     *
     * @param \Doctrine\Persistence\ObjectRepository $customers
     */
    public function __construct(ObjectRepository $customers)
    {
        $this->customers = $customers;
    }

    /**
     * @inheritDoc
     */
    public function getNextIdentity(): UniqueId
    {
        return new Uuid;
    }

    /**
     * @inheritDoc
     */
    public function findByEmail(string $email): ?Customer
    {
        return $this->customers->findOneBy(['email' => $email]);
    }

    /**
     * @inheritDoc
     */
    public function find(UniqueId $id): ?Customer
    {
        return $this->customers->find($id);
    }

    /**
     * @inheritDoc
     */
    public function all(int $perPage = 100, int $page = 1): LengthAwarePaginator
    {
        return $this->paginateAll($perPage, $page);
    }

    /**
     * @inheritDoc
     */
    public function createQueryBuilder($alias, $indexBy = null)
    {
        return EntityManager::createQueryBuilder()
            ->select([$alias])
            ->from(Customer::class, $alias, $indexBy);
    }
}