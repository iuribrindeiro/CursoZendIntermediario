<?php

namespace SONUser\Form;

use Zend\Form\Form;
use Zend\Form\Element as Frm;

class LoginForm extends Form {
    
    public function __construct($name = null) {
        parent::__construct('login');               
              
        $this->setAttributes(array('method' => 'POST',
            'class' => 'form-horizontal'));                          
        
        $email = new Frm\Email('email');
        $email->setLabel('Email')
                ->setAttributes(array('placeholder' => 'Entre com o Email',
                                      'class' => 'form-control'));
        $this->add($email);
        
        $password = new Frm\Password('password');
        $password->setLabel('Senha')
                 ->setAttributes(array('placeholder' => 'Entre com a Senha',
                                       'class' => 'form-control'));                
        $this->add($password);                
        
        $submit = new Frm\Submit('submit');
        $submit->setAttributes(array('value' => 'Login','class' => 'btn btn-success form-group'));
        $this->add($submit);
    }
}
