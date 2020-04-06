<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Creation;
use App\Entity\Commentaires;

class CreationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        //10 creations avec 2 types different
    	for($i=0; $i<10; $i++)
    	{
			if($i<5)
			{	
				$creation = new Creation();
				$creation
					->setTitre($faker->words(3,true))
					->setDescription($faker->sentences(3,true))
					->setImage("https://via.placeholder.com/250")
					->setCreatedAt($faker->dateTimeBetween('-6 months'))
					->setType("video");
			}
			else
			{
				$creation = new Creation();
				$creation
					->setTitre($faker->words(3,true))
					->setDescription($faker->sentences(3,true))
					->setImage("https://via.placeholder.com/250")
					->setCreatedAt($faker->dateTimeBetween('-6 months'))
					->setType("image");
			}
			
    		$manager->persist($creation);

    		//quelques commentaires entre 4 et 6
    		for($j=0;$j< mt_rand(4,6);$j++)
    		{
    			$commentaires = new Commentaires();

                /*date comprise entre date creation entity et date actuel*/
    			$now = new \DateTime();
    			$days = $now->diff($creation->getCreatedAt())->days;
    			$minimum = '-' . $days . ' days';

    			$commentaires
    				->setAuteur($faker->name())
    				->setCreatedAt($faker->dateTimeBetween($minimum))
    				->setCommentaire($faker->sentences(3,true))
    				->setCreation($creation);

    			$manager->persist($commentaires);
    		}
    	}

        $manager->flush();
    }
}
