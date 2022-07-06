<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
// use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture implements DependentFixtureInterface
{

    public const USER_REF = 'user-ref_%s';

    // private $passwordHasher;

    // public function __construct( UserPasswordHasherInterface $passwordHasher)
    // {
    //     $this->passwordHasher = $passwordHasher;
    // }

    public function load(ObjectManager $manager)
    {

        //fixtures Users

        for($i = 0 ; $i < 10 ; $i++ ) {

            $faker = Factory::create('fr_FR');

            $customerRandom = 0;

            $user = new User(); 

            $plainPassword = $faker->word();

            // $passwordHashed = $this->passwordHasher->hashPassword($user, $plainPassword);

            $user->setCustomer($this->getReference('customer-ref_'.$customerRandom)); 
            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setEmail($faker->email());
            // $user->setPassword($passwordHashed);
            $user->setPassword($plainPassword);
            $user->setCreatedAt($faker->dateTime());
            $user->setUpdatedAt($faker->dateTime());

            $manager->persist($user); 
            $manager->flush();
            $this->addReference(sprintf(self::USER_REF, $i), $user); 
        }

    }

    public function getDependencies()
    {
        return [
            CustomerFixture::class
        ];
    }
}