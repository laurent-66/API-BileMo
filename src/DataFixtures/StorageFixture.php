<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Storage;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;


class StorageFixture extends Fixture 
{
    public const STORAGE_REF = 'storage-ref_%s';

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager)
    {

            //fixtures storages

            $dataStorageCollection = [
                [
                    "capacity"=> 16,
                    "createdAt"=>"",
                    "updatedAt"=>""
                ],
                [
                    "capacity"=>32,
                    "createdAt"=>"",
                    "updatedAt"=>""
                ],
                [
                    "capacity"=>64,
                    "createdAt"=>"",
                    "updatedAt"=>""
                ],
                [
                    "capacity"=>128,
                    "createdAt"=>"",
                    "updatedAt"=>""
                ],
                [
                    "capacity"=>256,
                    "createdAt"=>"",
                    "updatedAt"=>""
                ]
            ];

            for($i = 0 ; $i < count($dataStorageCollection) ; $i++ ) {

                $faker = Factory::create('fr_FR');
                
                $storage = new Storage(); 

                $storage->setCapacity($dataStorageCollection[$i]["capacity"]);
                $storage->setCreatedAt($faker->dateTime());
                $storage->setUpdatedAt($faker->dateTime());

                $manager->persist($storage); 
                $manager->flush();
                
                $this->addReference(sprintf(self::STORAGE_REF, $i), $storage); 
            }

    }

}