<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Address;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AddressFixture extends Fixture implements DependentFixtureInterface
{
    public const ADDRESS_REF = 'address-ref_%s';

    public function load(ObjectManager $manager)
    {

        //fixtures Address

        for($i = 0 ; $i < 15 ; $i++ ) {

            $faker = Factory::create('fr_FR');

            $userRandom = rand(0,9);
            $customerRandom = 0;

            $address = new Address(); 

            $address->setNumber($faker->randomNumber(2, true));
            $address->setPath($faker->words(2, true));
            $address->setApartment($faker->randomDigitNot(0));
            $address->setFloor($faker->randomDigitNot(0));
            $address->setZipCode(rand(10000, 95000));
            $address->setCity($faker->words(1, true));
            $address->setBilling($faker->boolean());
            $address->setDelivery($faker->boolean());
            $address->setResident($this->getReference('user-ref_'.$userRandom));
            $address->setCustomer($this->getReference('customer-ref_'.$customerRandom)); 
            $address->setCreatedAt($faker->dateTime());
            $address->setUpdatedAt($faker->dateTime()); 

            $manager->persist($address); 
            $manager->flush();
            $this->addReference(sprintf(self::ADDRESS_REF, $i), $address); 
        }

    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
            CustomerFixture::class
        ];
    }
}