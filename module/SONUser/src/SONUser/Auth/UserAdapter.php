<?php

namespace SONUser\Auth;

use Zend\Authentication\Adapter\AdapterInterface,
    Zend\Authentication\Result;    

use Doctrine\ORM\EntityManager;

class UserAdapter implements AdapterInterface {
    
    /*
     * @var EntityManager
     */
    private $em;
    private $username;
    private $password;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }
        
    public function authenticate() {        
        $objUser = $this->em->getRepository('SONUser\Entity\User')
                         ->findByEmailAndPassowrd($this->username, $this->password);
                
        if ($objUser) {
            return new Result(Result::SUCCESS, array('objUser' => $objUser), array('OK'));
        }        
        return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, array());
    }

}
