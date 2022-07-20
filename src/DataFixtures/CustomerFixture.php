<?php
namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Customer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CustomerFixture extends Fixture
{
    public const CUSTOMER_REF = 'customer-ref_%s';

    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager)
    {

        //fixtures Customers

        $dataCustomerCollection = ["Orange","Bouygues","Sfr","Free"];

        for($i = 0 ; $i < count($dataCustomerCollection) ; $i++ ) {

            $faker = Factory::create('fr_FR');
            
            $customer = new Customer(); 

            $customer->setName($dataCustomerCollection[$i]);
            $customer->setEmail('admin@'.$dataCustomerCollection[$i].'api.com');
            $customer->setRoles(["ROLE_ADMIN"]);
            $customer->setPassword($this->userPasswordHasher->hashPassword($customer, "admin"));
            $customer->setCreatedAt($faker->dateTime());
            $customer->setUpdatedAt($faker->dateTime());
            $manager->persist($customer); 
            $manager->flush();
            $this->addReference(sprintf(self::CUSTOMER_REF, $i), $customer);  
        }
    } 

}

