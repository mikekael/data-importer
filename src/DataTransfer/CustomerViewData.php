<?php

namespace App\DataTransfer;

use App\Entity\Customer;

class CustomerViewData
{
    /**
     * Create instance of the customer view data
     *
     * @param Customer $customer
     */
    public function __construct(
        protected Customer $customer
    ) {}

    /**
     * Retrieved customer identity
     *
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->customer->getId();
    }

    /**
     * Retrieve customer email address
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->customer->getEmail();
    }

    /**
     * Retrieve customer username
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->customer->getUsername();
    }

    /**
     * Retrieve customer first name
     *
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->customer->getFirstName();
    }

    /**
     * Retrieve customer last name
     *
     * @return string
     */
    public function getLastName(): string
    {
        return $this->customer->getLastName();
    }

    /**
     * Retrieve customer full name
     *
     * @return string
     */
    public function getFullName(): string
    {
        return $this->customer->getFullName();
    }

    /**
     * Retrieve customer gender
     *
     * @return string
     */
    public function getGender(): string
    {
        return $this->customer->getGender();
    }

    /**
     * Retrieve customer gender
     *
     * @return string
     */
    public function getCountry(): string
    {
        return $this->customer->getCountry();
    }

    /**
     * Retrieve customer city
     *
     * @return string
     */
    public function getCity(): string
    {
        return $this->customer->getCity();
    }

    /**
     * Retrieve customer phone
     *
     * @return string
     */
    public function getPhone(): string
    {
        return $this->customer->getPhone();
    }
}