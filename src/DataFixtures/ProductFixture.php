<?php
namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixture extends Fixture implements DependentFixtureInterface
{
    public const PRODUCT_REF = 'product-ref_%s';


    public function load(ObjectManager $manager)
    {

        //fixtures Products

        $dataPhonesCollection = [
            [
                "name"=>"name1",
                "description"=>"Description1",
                "picture"=>"image1",
                "alternative_attribute"=>"alt1",
                "screen"=>"screen1",
                "photo_resolution"=>"photo_resolution1",
                "battery"=>"battery1",
                "network"=>"network",
                "color"=>"color",
                "storage"=>"storage"
            ],
            [
                "name"=>"name2",
                "description"=>"Description2",
                "picture"=>"image2",
                "alternative_attribute"=>"alt2",
                "screen"=>"screen2",
                "photo_resolution"=>"photo_resolution2",
                "battery"=>"battery2",
                "network"=>"network",
                "color"=>"color",
                "storage"=>"storage"
            ],
            [
                "name"=>"name3",
                "description"=>"Description3",
                "picture"=>"image3",
                "alternative_attribute"=>"alt3",
                "screen"=>"screen3",
                "photo_resolution"=>"photo_resolution3",
                "battery"=>"battery3",
                "network"=>"network",
                "color"=>"color",
                "storage"=>"storage"
            ],
            [
                "name"=>"name4",
                "description"=>"Description4",
                "picture"=>"image4",
                "alternative_attribute"=>"alt4",
                "screen"=>"screen4",
                "photo_resolution"=>"photo_resolution4",
                "battery"=>"battery4",
                "network"=>"network",
                "color"=>"color",
                "storage"=>"storage"
            ],
            [
                "name"=>"name5",
                "description"=>"Description5",
                "picture"=>"image5",
                "alternative_attribute"=>"alt5",
                "screen"=>"screen5",
                "photo_resolution"=>"photo_resolution5",
                "battery"=>"battery5",
                "network"=>"network",
                "color"=>"color",
                "storage"=>"storage"
            ],
        ];

        for($i = 0 ; $i < count($dataPhonesCollection) ; $i++ ) {

            $faker = Factory::create('fr_FR');
            $colorRandom = rand(1,4);
            $storageRandom = rand(0,4);
            $product = new Product(); 

            $product->setName($dataPhonesCollection[$i]['name']);
            $product->setDescription($dataPhonesCollection[$i]['description']);
            $product->setPicture($dataPhonesCollection[$i]['picture']);
            $product->setAlternativeAttribute($dataPhonesCollection[$i]['alternative_attribute']);
            $product->setScreen($dataPhonesCollection[$i]['screen']);
            $product->setPhotoResolution($dataPhonesCollection[$i]['photo_resolution']);
            $product->setBattery($dataPhonesCollection[$i]['battery']);
            $product->setNetwork($dataPhonesCollection[$i]['network']);
            $product->setColor($this->getReference('color-ref_'.$colorRandom));
            $product->setStorage($this->getReference('storage-ref_'.$storageRandom));
            $product->setCreatedAt($faker->dateTime());
            $product->setUpdatedAt($faker->dateTime()); 

            $manager->persist($product); 
            $manager->flush();
            $this->addReference(sprintf(self::PRODUCT_REF, $i), $product); 
        }

    }

    public function getDependencies()
    {
        return [
            ColorFixture::class,
            StorageFixture::class,
            CustomerFixture::class
        ];
    }
}