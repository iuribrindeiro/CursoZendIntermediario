<?php

namespace SONUser\Service;

use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator;

abstract class AbstractService {
    
    /**
     * @var EntityManager 
     */
    protected $em;

    protected $entity;

    public function __construct($em) {
        $this->em = $em;
    }
    
    public function inserir(array $data) {
        $entity = new $this->entity($data);
        
        $this->em->persist($entity);
        $this->em->flush();
        
        return $entity;
    }
    
    public function alterar(array $data) {
        $entity = $this->em->getReference($this->entity, $data['id']);
        (new Hydrator\ClassMethods())->hydrate($data, $entity);
        
        $this->em->persist($entity);
        $this->em->flush();
        
        return $entity;
    }
    
    public function deletar($id) {
        $entity = $this->em->getReference($this->entity, $id);
        
        if ($entity) {
            $this->em->remove($entity);
            $this->em->flush();
            return $id;
        }        
    }
}
