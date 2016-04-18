<?php

namespace SONUser\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository {
    
    public function findByEmailAndPassowrd($email, $password) {
        $objUser = $this->findOneByEmail($email);        
        if ($objUser) {                                    
            if ($objUser->encryptPassword($password) 
                    == $objUser->getPassword()) {                
                return $objUser;
            }
        }
        return false;
    }
}
