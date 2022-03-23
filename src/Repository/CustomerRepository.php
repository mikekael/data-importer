<?php

namespace App\Repository;

use App\Contract\Repository\CustomerRepositoryInterface;
use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository implements CustomerRepositoryInterface
{
    /**
     * @see ServiceEntityRepository
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    /**
     * @see CustomerRepositoryInterface
     */
    public function findByEmailAddress(string $email): ?Customer
    {
        return $this->findOneBy(['email' => $email]);
    }

    /**
     * @see CustomerRepositoryInterface
     */
    public function save(Customer $customer): Customer
    {
        $this->_em->persist($customer);
        $this->_em->flush();

        return $customer;
    }
}
