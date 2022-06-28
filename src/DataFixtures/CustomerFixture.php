<?php
namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Customer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
// use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CustomerFixture extends Fixture
{
    public const CUSTOMER_REF = 'customer-ref_%s';

    // public function __construct( UserPasswordHasherInterface $passwordHasher)
    // {
    //     $this->passwordHasher = $passwordHasher;
    // }

    public function load(ObjectManager $manager)
    {

        //fixtures Customers

        $dataCustomerCollection = [
            [
                "name"=>"Orange"

            ],
            [
                "name"=>"Bouygues"
            ],
            [
                "name"=>"SFR"
            ],
            [
                "name"=>"free"
            ]
        ];

        for($i = 0 ; $i < count($dataCustomerCollection) ; $i++ ) {

            $faker = Factory::create('fr_FR');
            
            $customer = new Customer(); 

            $plainPassword = $faker->word();

            // $passwordHashed = $this->passwordHasher->hashPassword($customer, $plainPassword);

            $customer->setName($dataCustomerCollection[$i]["name"]);
            $customer->setEmail($faker->email());
            // $customer->setPassword($passwordHashed);
            $customer->setPassword($plainPassword);
            $customer->setCreatedAt($faker->dateTime());
            $customer->setUpdatedAt($faker->dateTime());
            $manager->persist($customer); 
            $manager->flush();
            $this->addReference(sprintf(self::CUSTOMER_REF, $i), $customer); 
        }

    }

}