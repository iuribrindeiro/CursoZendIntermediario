<?php

namespace SONUser\Form;

use Zend\Form\Form;
use Zend\Form\Element as Frm;

class UserForm extends Form {
    
    public function __construct($name = null) {
        parent::__construct('user');               
        
        $this->setInputFilter(new UserFilter());
        $this->setAttributes(array('method' => 'POST',
            'class' => 'form-horizontal'));          
        
        $this->add(new Frm\Hidden('id'));
        
        $nome = new Frm\Text('nome');
        $nome->setLabel('Nome')
                ->setAttributes(array('placeholder' => 'Entre com o Nome',
                                      'class' => 'form-control'));                  
        $this->add($nome);
        
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
        
        $confirmacao = new Frm\Password('confirmacao');
        $confirmacao->setLabel('Confirmaçao de Senha')
                    ->setAttributes(array('placeholder' => 'Redigite a Senha',
                                          'class' => 'form-control'));                 
        $this->add($confirmacao);
               
        $this->add(new Frm\Csrf('security'));
        
        $submit = new Frm\Submit('submit');
        $submit->setAttributes(array('value' => 'Salvar','class' => 'btn btn-success form-group'));
        $this->add($submit);
    }
}
