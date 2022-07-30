<?php

namespace App\Service;

use Faker\Factory;
use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class FixturesByAccessRole 
{
    public const CUSTOMER_REF = 'customer-ref_%s';

    public function __construct(EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $manager;
        $this->passwordHasher = $passwordHasher;
    }

    function generateFixturesForRoleUser( string $nameRole="toto", int $index) {
        
        $customer = new Customer();
        $faker = Factory::create('fr_FR');
        $passwordHashed = $this->passwordHasher->hashPassword($customer, $faker->word());
        $customer->setName($nameRole);
        $customer->setEmail('user@'.$nameRole.'api.com');
        $customer->setRoles(["ROLE_USER"]);
        $customer->setPassword($passwordHashed);
        $customer->setCreatedAt($faker->dateTime());
        $customer->setUpdatedAt($faker->dateTime());
        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        // $this->addReference(sprintf(self::CUSTOMER_REF, $index), $customer); 
    }


     function generateFixturesForRoleAdmin(string $nameRole="toto") {
        $customer = new Customer();
        $faker = Factory::create('fr_FR');
        $passwordHashed = $this->passwordHasher->hashPassword($customer, $faker->word());
        $customer->setName($nameRole);
        $customer->setEmail('admin@'.$nameRole.'api.com');
        $customer->setRoles(["ROLE_ADMIN"]);
        $customer->setPassword($passwordHashed);
        $customer->setCreatedAt($faker->dateTime());
        $customer->setUpdatedAt($faker->dateTime());
        $this->entityManager->persist($customer); 
     }

}