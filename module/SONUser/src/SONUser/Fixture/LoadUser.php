<?php

namespace SONUser\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\Persistence\ObjectManager;

use SONUser\Entity\User;

class LoadUser extends AbstractFixture {
    
    public function load(ObjectManager $manager) {
        $user = new User();
        
        
        
        $user->setNome("Arlindo")
             ->setEmail("arlindo@email.com")
             ->setActive(true)
             ->setPassword(1495);                
        
        $manager->persist($user);
        
        $manager->flush();
    }
}
