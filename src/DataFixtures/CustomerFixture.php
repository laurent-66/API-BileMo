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

    // public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    // {
    //     $this->userPasswordHasher = $userPasswordHasher;
    // }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        // Création d'un user admin orange
        $orangeAdmin = new Customer(); 
        $orangeAdmin->setName("orange");
        $orangeAdmin->setEmail("admin@orangeapi.com");
        // $orangeAdmin->setRoles(["ROLE_ADMIN"]);
        // $orangeAdmin->setPassword($this->userPasswordHasher->hashPassword($orangeAdmin, "admin"));
        $orangeAdmin->setPassword("admin");
        $orangeAdmin->setCreatedAt($faker->dateTime());
        $orangeAdmin->setUpdatedAt($faker->dateTime());
        $manager->persist($orangeAdmin);
        $this->addReference(sprintf(self::CUSTOMER_REF, 0), $orangeAdmin); 

        $manager->flush();
        
    } 

}

