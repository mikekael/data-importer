<?php

namespace App\Repository;

use App\Contract\Repository\CustomerRepositoryInterface;
use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;

class CustomerRepository implements CustomerRepositoryInterface
{
    /**
     * Create instance of the customer repository
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(
        protected EntityManagerInterface $em
    ) {}

    /**
     * @see CustomerRepositoryInterface
     */
    public function find(int|string $id): ?Customer
    {
        try {
            return $this->builder()
                ->where('customers.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $ex) {}

        return null;
    }

    /**
     * @see CustomerRepositoryInterface
     */
    public function findByEmailAddress(string $email): ?Customer
    {
        try {
            return $this->builder()
                ->where('customers.email = :email')
                ->setParameter('email', $email)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $ex) {}

        return null;
    }

    /**
     * @see CustomerRepositoryInterface
     */
    public function save(Customer $customer): Customer
    {
        $this->em->persist($customer);
        $this->em->flush();

        return $customer;
    }

    /**
     * @see CustomerRepositoryInterface
     */
    public function all(): iterable
    {
        return $this->builder()
            ->getQuery()
            ->getResult();
    }

    /**
     * Create query builder instance
     *
     * @param  string $alias
     *
     * @return QueryBuilder
     */
    protected function builder(string $alias = 'customers'): QueryBuilder
    {
        return $this->em->createQueryBuilder()
            ->select([$alias])
            ->from(Customer::class, $alias);
    }
}
