<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Color;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class ColorFixture extends Fixture
{
    public const COLOR_REF = 'color-ref_%s';

    public function load(ObjectManager $manager)
    {

        //fixtures Colors

        $dataColorCollection = [
            [
                "color"=>"Black",
                "createdAt"=>"",
                "updatedAt"=>""
            ],
            [
                "color"=>"white",
                "createdAt"=>"",
                "updatedAt"=>""
            ],
            [
                "color"=>"grey",
                "createdAt"=>"",
                "updatedAt"=>""
            ],
            [
                "color"=>"blue",
                "createdAt"=>"",
                "updatedAt"=>""
            ],
            [
                "color"=>"orange",
                "createdAt"=>"",
                "updatedAt"=>""
            ],

        ];

        for($i = 0 ; $i < count($dataColorCollection) ; $i++ ) {

            $faker = Factory::create('fr_FR');

            $color = new Color(); 

            $color->setColor($dataColorCollection[$i]["color"]);
            $color->setCreatedAt($faker->dateTime());
            $color->setUpdatedAt($faker->dateTime());
            $manager->persist($color); 
            $manager->flush();
            $this->addReference(sprintf(self::COLOR_REF, $i), $color); 
        }

    }
}