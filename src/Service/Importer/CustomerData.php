<?php

namespace App\Service\Importer;

class CustomerData
{
    /**
     * Create instance of the customer data that will provided by the data provider
     *
     * @param string $email
     * @param string $username
     * @param string $plainPassword
     * @param string $firstName
     * @param string $lastName
     * @param string $gender
     * @param string $city
     * @param string $country
     * @param string $phone
     */
    public function __construct(
        protected string $email,
        protected string $username,
        protected string $plainPassword,
        protected string $firstName,
        protected string $lastName,
        protected string $gender,
        protected string $country,
        protected string $city,
        protected string $phone
    ) {}

    /**
     * Retrieve the email address
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Retrieve the username
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Retrieve the plain password
     *
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * Retrieve the first name
     *
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Retrieve the last name
     *
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Retrieve the gender
     *
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * Retrieve the gender
     *
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * Retrieve the city
     *
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * Retrieve the phone
     *
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }
}