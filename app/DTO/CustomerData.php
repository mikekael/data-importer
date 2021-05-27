<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class CustomerData extends DataTransferObject
{
    /**
     * @var string
     */
    public string $firstName;
    
    /**
     * @var string
     */
    public string $lastName;

    /**
     * @var string
     */
    public string $username;

    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $password;

    /**
     * @var string
     */
    public string $gender;

    /**
     * @var string
     */
    public string $country;

    /**
     * @var string
     */
    public string $city;

    /**
     * @var string
     */
    public string $phone;
}