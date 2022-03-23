<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use App\DataTransfer\CustomerData;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 254)]
    private string $email;

    #[ORM\Column(type: 'string', length: 32)]
    private string $username;

    #[ORM\Column(type: 'string', length: 32)]
    private string $password;

    #[ORM\Column(type: 'string', length: 32)]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 64)]
    private string $lastName;

    #[ORM\Column(type: 'string', length: 10)]
    private string $gender;

    #[ORM\Column(type: 'string', length: 90)]
    private string $country;

    #[ORM\Column(type: 'string', length: 189)]
    private string $city;

    #[ORM\Column(type: 'string', length: 20)]
    private string $phone;

    /**
     * Create a new customer
     *
     * @param CustomerData $data
     */
    public function __construct(CustomerData $data)
    {
        $this->fill($data);
    }

    /**
     * Retrieve the identity
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retrieve the email
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
     * Retrieve the password
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
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
     * Retrieve the country
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

    /**
     * Updates the current data
     *
     * @param CustomerData $data
     *
     * @return void
     */
    public function update(CustomerData $data): void
    {
        $this->fill($data);
    }

    /**
     * Fill the entity with customer data
     *
     * @param CustomerData $data
     *
     * @return void
     */
    protected function fill(CustomerData $data): void
    {
        $this->firstName = $data->getFirstName();
        $this->lastName = $data->getLastName();
        $this->username = $data->getUsername();
        $this->password = $data->getPassword();
        $this->email = $data->getEmail();
        $this->gender = $data->getGender();
        $this->country = $data->getCountry();
        $this->city = $data->getCity();
        $this->phone = $data->getPhone();
    }
}
