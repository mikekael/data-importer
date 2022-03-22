<?php

namespace App\Entity;

use App\Contract\Domain\ValueObject\IdentityInterface;
use App\Entity\ValueObject\FirstName;
use App\Entity\ValueObject\LastName;
use App\Entity\ValueObject\Username;

class Customer extends AbstractEntity
{
    /**
     * Create customer entity
     *
     * @param IdentityInterface $id
     * @param FirstName $firstName
     * @param LastName $lastName
     * @param string $password
     * @param string|null $gender
     * @param string|null $city
     * @param string|null $phone
     */
    public function __construct(
        IdentityInterface $id,
        private FirstName $firstName,
        private LastName $lastName,
        private Username $username,
        private string $password,
        private ?string $gender = null,
        private ?string $country = null,
        private ?string $city = null,
        private ?string $phone = null
    ) {
        parent::__construct($id);
    }

    /**
     * Retrieve customer first name
     *
     * @return FirstName
     */
    public function getFirstName(): FirstName
    {
        return $this->firstName;
    }

    /**
     * Retrieve customer last name
     *
     * @return LastName
     */
    public function getLastName(): LastName
    {
        return $this->lastName;
    }

    /**
     * Retrieve customer username
     *
     * @return Username
     */
    public function getUsername(): Username
    {
        return $this->username;
    }

    /**
     * Retrieve the customer hashed password
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Retrieve the customer gender
     *
     * @return string|null
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * Retrieve the customer country
     *
     * @return string|null
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * Retrieve the customer city
     *
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Retrieve the customer phone
     *
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }
}