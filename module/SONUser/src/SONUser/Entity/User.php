<?php

namespace SONUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Math\Rand, 
    Zend\Crypt\Key\Derivation\Pbkdf2,
    Zend\Stdlib\Hydrator;


/** 
 *
 * @ORM\Table(name="tab_users")
 * @ORM\Entity 
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="SONUser\Entity\UserRepository")
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="usr_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_nome", type="string", length=255, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_salt", type="string", length=255, nullable=false)
     */
    private $salt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="usr_active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="usr_activation_key", type="string", length=255, nullable=false)
     */
    private $activationKey;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="usr_update_at", type="datetime", nullable=false)
     */
    private $updateAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="usr_created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getActive() {
        return $this->active;
    }

    function getActivationKey() {
        return $this->activationKey;
    }

    function getUpdateAt() {
        return $this->updateAt;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function setId($id) {
        $this->id = $id;
        return $this;
    }

    function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    function setPassword($password) {
        $this->password = $this->encryptPassword($password);
        return $this;
    }
    
    function encryptPassword($password) {        
        return base64_encode(Pbkdf2::calc('sha256', $password, $this->salt, 1000, strlen($password)*2));
    }

    function setActive($active) {
        $this->active = $active;
        return $this;
    }
    
    function getSalt() {
        return $this->salt;
    }
    
    function setActivationKey($activationKey) {
        $this->activationKey = $activationKey;
    }

    function setCreatedAt(\DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

        
    
    /**
     * @ORM\PrePersist
     */
    function setUpdateAt() {
        $this->updateAt = new \DateTime("now");        
    }
    
    function __toString() {
        return $this->nome;
    }
            
    public function __construct(array $options = array()) {          
        $this->salt = base64_encode(Rand::getBytes(8, true));
        $this->activationKey = md5($this->salt.$this->email);
        (new Hydrator\ClassMethods())->hydrate($options, $this);
        
        $this->createdAt= new \DateTime("now");
        $this->updateAt = new \DateTime("now");                                
    }
    
    
    public function toArray() {
        return (new Hydrator\ClassMethods())->extract($this);
    }
}

