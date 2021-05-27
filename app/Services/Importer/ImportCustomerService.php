<?php

namespace App\Services\Importer;

use App\Contracts\Domain\CustomerRepository;
use App\Entities\Customer;
use App\Services\Importer\Contracts\DataProvider;
use Doctrine\ORM\EntityManagerInterface;

class ImportCustomerService
{
    /**
     * @var \App\Services\Importer\Contracts\DataProvider
     */
    protected DataProvider $provider;

    /**
     * @var \App\Contracts\Domain\CustomerRepository
     */
    protected CustomerRepository $repository;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected EntityManagerInterface $em;

    /**
     * Create instance
     *
     * @param \App\Services\Importer\Contracts\DataProvider $provider
     * @param \App\Contracts\Domain\CustomerRepository $repository
     * @param \Doctrine\ORM\EntityManagerInterface
     */
    public function __construct(DataProvider $provider, CustomerRepository $repository, EntityManagerInterface $em)
    {
        $this->provider = $provider;
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * Run current customer importer
     *
     * @return void
     */
    public function run(): void
    {
        foreach ($this->provider->getCustomers() as $data) {
            if ($customer = $this->repository->findByEmail($data->email)) {
                $customer = $customer->update($data);
            } else {
                $customer = new Customer($this->repository->getNextIdentity(), $data);
            }

            $this->em->persist($customer);
            $this->em->flush();
        }
    }
}