<?php

namespace SONUser\Controller;

use SONUser\Controller\AbstractController;

class UserController extends AbstractController {
    
    public function __construct() {
        $this->entity = 'SONUser\Entity\User';
        $this->controller = 'user';
        $this->form = 'SONUser\Form\UserForm';
        $this->route = 'user-admin/default';
        $this->service = 'UserService';
    }
    
    public function novoAction() {
        return parent::novoAction('Usuário Cadastrado com Sucesso!');
    }
    
    public function alterarAction() {
        return parent::alterarAction('Usuário Alterado com Sucesso!');
    }
}
