<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{
	private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
         $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)/*creation d'un admin*/
    {
    	$admin = new User();

    	$admin
    		->setEmail("admin@admin.fr")
    		->setUsername("admin")    		
    		->setPassword($this->passwordEncoder->encodePassword($admin,'admin_afpa28'))
    		->setRole("admin");

        // $product = new Product();
        // $manager->persist($product);
    	$manager->persist($admin);
        $manager->flush();
    }
}
