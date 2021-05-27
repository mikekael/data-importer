<?php

namespace App\Entities;

use App\Contracts\Domain\UniqueId;
use App\DTO\CustomerData;
use Illuminate\Support\Facades\Hash;

class Customer
{
    /**
     * @var mixed
     */
    protected UniqueId $id;

    /**
     * @var string
     */
    protected string $firstName;

    /**
     * @var string
     */
    protected string $lastName;

    /**
     * @var string
     */
    protected string $username;

    /**
     * @var string
     */
    protected string $email;

    /**
     * @var string
     */
    protected string $password;

    /**
     * @var string
     */
    protected string $gender;

    /**
     * @var string
     */
    protected string $country;

    /**
     * @var string
     */
    protected string $city;

    /**
     * @var string
     */
    protected string $phone;

    /**
     * Create instance of the customer entity
     *
     * @param \App\Contracts\Domain\UniqueId $id
     * @param \App\DTO\CustomerData $data
     */
    public function __construct(UniqueId $id, CustomerData $data)
    {
        $this->id = $id;
        $this->fill($data);
    }

    /**
     * Retrieved customer unique identity
     *
     * @return \App\Contracts\Domain\UniqueId
     */
    public function getId(): UniqueId
    {
        return $this->id;
    }

    /**
     * Retrieved customer first name
     *
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Retrieved customer last name
     *
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Retrieved customer username
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Retrieved customer email address
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Retrieved customer hashed password
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Retrieved customer gender
     *
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * Retrieved customer country location
     *
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * Retrieved customer city location
     *
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * Retrieved contact phone
     *
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * Retrieved customer full name
     *
     * @return string
     */
    public function getFullName(): string
    {
        return sprintf('%s %s', $this->getFirstName(), $this->getLastName());
    }

    /**
     * Updates the current entity from the given updated data
     *
     * @param  \App\DTO\CustomerData $data
     *
     * @return \App\Entities\Customer
     */
    public function update(CustomerData $data): Customer
    {
        $this->fill($data);

        return $this;
    }

    /**
     * Fill current customer entity from the raw data
     *
     * @param  \App\DTO\CustomerData $data
     *
     * @return void
     */
    protected function fill(CustomerData $data): void
    {
        $this->firstName = $data->firstName;
        $this->lastName = $data->lastName;
        $this->username = $data->username;
        $this->email = $data->email;
        $this->password = Hash::make($data->password);
        $this->gender = $data->gender;
        $this->country = $data->country;
        $this->city = $data->city;
        $this->phone = $data->phone;
    }
}