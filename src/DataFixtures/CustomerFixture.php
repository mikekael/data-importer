<?php

namespace App\DataFixtures;

use App\DataTransfer\CustomerData;
use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerFixture extends Fixture
{
    /**
     * Load customer fixture into the database
     *
     * @param  ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $manager->persist(new Customer(new CustomerData(
            'john@example.org',
            'johnny12',
            'bdc87b9c894da5168059e00ebffb9077',
            'Johnny',
            'Doe',
            'male',
            'Australia',
            'Mackay',
            '04-3987-1147',
        )));

        $manager->flush();
    }
}
