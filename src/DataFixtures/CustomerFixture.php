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

        $dataRoleCustomerCollection = [
            "OrangeUser", 
            "BouyguesUser", 
            "SFRUser", 
            "freeUser",
            "OrangeAdmin", 
            "BouyguesAdmin", 
            "SFRAdmin", 
            "freeAdmin"
        ];


        // for ($i = 0; $i < count($dataRoleCustomerCollection); $i++) {  

        //     if(stristr($dataRoleCustomerCollection[$i],"User") === "User"){

        //         $this->fixturesByAccessRole->generateFixturesForRoleUser(new Customer(), $dataRoleCustomerCollection[$i]);
        //         $this->addReference(sprintf(self::CUSTOMER_REF, $i), new Customer()); 

        //     } else if (stristr($dataRoleCustomerCollection[$i],"Admin") === "Admin") {
        //         $this->fixturesByAccessRole->generateFixturesForRoleAdmin(new Customer(), $dataRoleCustomerCollection[$i]);
        //         $this->addReference(sprintf(self::CUSTOMER_REF, $i), new Customer()); 
        //     }
        // }


        // $this->fixturesByAccessRole->generateFixturesForRoleUser($dataRoleCustomerCollection[0],0);
        // $this->fixturesByAccessRole->generateFixturesForRoleUser($dataRoleCustomerCollection[1],1);
        // $this->fixturesByAccessRole->generateFixturesForRoleUser($dataRoleCustomerCollection[2],2);
        // $this->fixturesByAccessRole->generateFixturesForRoleUser($dataRoleCustomerCollection[3],3);
        // $this->fixturesByAccessRole->generateFixturesForRoleAdmin($dataRoleCustomerCollection[4],4);
        // $this->fixturesByAccessRole->generateFixturesForRoleAdmin($dataRoleCustomerCollection[5],5);
        // $this->fixturesByAccessRole->generateFixturesForRoleAdmin($dataRoleCustomerCollection[6],6);
        // $this->fixturesByAccessRole->generateFixturesForRoleAdmin($dataRoleCustomerCollection[7],7);
        $faker = Factory::create('fr_FR');

        // Création d'un user "normal" orange
        $orangeUser = new Customer();
        $orangeUser->setName("orange");
        $orangeUser->setEmail("user@orangeapi.com");
        $orangeUser->setRoles(["ROLE_USER"]);
        $orangeUser->setPassword($this->userPasswordHasher->hashPassword($orangeUser, "password"));
        $orangeUser->setCreatedAt($faker->dateTime());
        $orangeUser->setUpdatedAt($faker->dateTime());
        $manager->persist($orangeUser);
        $this->addReference(sprintf(self::CUSTOMER_REF, 0), $orangeUser); 

        // Création d'un user admin orange
        $orangeAdmin = new Customer(); 
        $orangeAdmin->setName("orange");
        $orangeAdmin->setEmail("admin@orangeapi.com");
        $orangeAdmin->setRoles(["ROLE_ADMIN"]);
        $orangeAdmin->setPassword($this->userPasswordHasher->hashPassword($orangeAdmin, "password"));
        $orangeAdmin->setCreatedAt($faker->dateTime());
        $orangeAdmin->setUpdatedAt($faker->dateTime());
        $manager->persist($orangeAdmin);
        $this->addReference(sprintf(self::CUSTOMER_REF, 1), $orangeAdmin); 

        $manager->flush();
        
    } 

}

