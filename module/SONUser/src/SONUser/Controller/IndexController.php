<?php

namespace SONUser\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

use SONUser\Form\UserForm;

class IndexController extends AbstractActionController {
    
    public function registerAction() {        
        $objForm = new UserForm();
        $objRequest = $this->getRequest();
        $objFlashMessage = $this->flashMessenger()
                                ->setNamespace('SONUser');
        
        if ($objRequest->isPost()) {
            $objForm->setData($objRequest->getPost()->toArray());
            
            if ($objForm->isValid()) {
                $objUserService = $this->getServiceLocator()
                                       ->get('UserService');
                if ($objUserService->inserir($objForm->getData())) {
                    $objFlashMessage->addMessage('Usuario cadastrado '
                            . 'com Sucesso!');
                    return $this->redirect()->toRoute('sonuser-register');                    
                }                
            }            
        }                
        
        return new ViewModel(array('objForm' => $objForm, 
            'mensagens' => $objFlashMessage->getMessages()));
    }
    
    public function ativarAction() {        
        $this->getServiceLocator()
                ->get('UserService')
                ->ativar($this->params('key', null));
        
        return $this->redirect()->toRoute('user-login');
    }
}
