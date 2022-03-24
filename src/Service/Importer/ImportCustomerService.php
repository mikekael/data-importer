<?php

namespace App\Service\Importer;

use App\Contract\Repository\CustomerRepositoryInterface;
use App\DataTransfer\CustomerData;
use App\Entity\Customer;
use App\Service\Importer\Contract\DataProviderFactoryInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class ImportCustomerService
{
    /**
     * Create instance of the customer service
     *
     * @param DataProviderFactoryInterface $factory
     * @param CustomerRepositoryInterface $repository
     * @param PasswordHasherInterface $hasher
     */
    public function __construct(
        protected DataProviderFactoryInterface $factory,
        protected CustomerRepositoryInterface $repository,
        protected PasswordHasherInterface $hasher
    ) {}

    /**
     * Execute the importing action
     *
     * @param  string|null $providerId
     *
     * @return void
     */
    public function run(?string $providerId = null): void
    {
        $customers = $this->factory->make($providerId)->getCustomers();

        foreach ($customers as $data) {
            $data = new CustomerData(
                $data->getEmail(),
                $data->getUsername(),
                $this->hasher->hash($data->getPlainPassword()),
                $data->getFirstName(),
                $data->getLastName(),
                $data->getGender(),
                $data->getCountry(),
                $data->getCity(),
                $data->getPhone()
            );

            if ($customer = $this->repository->findByEmailAddress($data->getEmail())) {
                $customer->update($data);
            } else {
                $customer = new Customer($data);
            }

            $this->repository->save($customer);
        }
    }
}