<?php

namespace SONUser\Controller;

use Zend\Authentication\Storage\Session as SessionStorage,
    Zend\Authentication\AuthenticationService,
    Zend\View\Model\ViewModel,
    Zend\Mvc\Controller\AbstractActionController;

use SONUser\Form\LoginForm;

class AuthController extends AbstractActionController {
    
    public function indexAction() {
        $objForm = new LoginForm();
        $objRequest = $this->getRequest();
        $error = false;
                        
        if ($objRequest->isPost()) {                        
            $objForm->setData($objRequest->getPost());
            if ($objForm->isValid()) {
                $objSessionStorage = new SessionStorage('SONUser');
                $objUsuario = $objRequest->getPost()->toArray();
                $objAuth = new AuthenticationService();
                $objAuth->setStorage($objSessionStorage);
                $objService = $this->getServiceLocator()->get('AuthAdapterService');
                
                $objService->setUsername($objUsuario['email']);
                $objService->setPassword($objUsuario['password']);                
                
                $objResult = $objAuth->authenticate($objService);
                
                if ($objResult->isValid()) {
                    $objSessionStorage->write($objAuth->getIdentity()['objUser']);
                    return $this->redirect()->toRoute('user-admin/default', 
                            array('action' => 'index'));
                }else {
                    $error = true;
                }
            }
        }
        return new ViewModel(array('objForm' => $objForm, 'error' => $error));
    }
}
