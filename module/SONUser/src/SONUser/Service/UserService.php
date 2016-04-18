<?php


namespace SONUser\Service;

use SONUser\Service\AbstractService;
use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator,
    Zend\Mail\Transport\Smtp as SmtpTransport,
    SONBase\Mail\Mail;

class UserService extends AbstractService {
   
    private $transport;
    private $view;
    
    public function __construct($em, SmtpTransport $transport, $view) {
        parent::__construct($em);
        
        $this->entity = 'SONUser\Entity\User';
        $this->transport = $transport;
        $this->view = $view;
    }
    
    public function inserir(array $data) {
        $entity = parent::inserir($data);
        
        if ($entity) {
            $dataEmail = array('nome' => $data['nome'], 'activationKey' => $entity->getActivationKey());
            
            $mail = new Mail($this->transport, $this->view, 'add-user');
            $mail->setData($dataEmail)
                    ->setSubject('Cadastro de UsuárioS')
                    ->setTo($data['email'])
                    ->prepare()->send();
            
            return $entity;                    
        }
        return false;
    }
    
    public function ativar($key) {
        $objRepository = $this->em->getRepository('SONUser\Entity\User');
        $objUser = $objRepository->findOneByActivationKey($key);
                        
        if ($objUser && !$objUser->getActive()) {
            $objUser->setActive(true);            
            $this->em->persist($objUser);
            $this->em->flush();
            
            return $objUser;
        }
    }
    
    public function alterar(array $data) {
        $entity = $this->em->getReference($this->entity, $data['id']);
        
        if (empty($data['password'])) {
            unset($data['password']);
        }
        
        (new Hydrator\ClassMethods())->hydrate($data, $entity);
        
        $this->em->persist($entity);
        $this->em->flush();
        
        return $entity;
    }
}
