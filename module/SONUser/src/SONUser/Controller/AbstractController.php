<?php

namespace SONUser\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

use Zend\Paginator\Paginator,
    Zend\Paginator\Adapter\ArrayAdapter;    

abstract class AbstractController extends AbstractActionController {
    
    private $em;
    protected $service;
    protected $entity;
    protected $form;
    protected $route;    
    protected $controller;


    public function indexAction() {
        $objetos = $this->getEm()
                        ->getRepository($this->entity)
                        ->findAll();
        
        $page = $this->params('page');
        $paginator = new Paginator(new ArrayAdapter($objetos));
        $paginator->setCurrentPageNumber($page)
                  ->setDefaultItemCountPerPage(5);
        
        return new ViewModel(array('objetos' => $paginator, 'page' => $page));
    }
    
    public function novoAction($mensagem) {
        $objForm = new $this->form();         
        $objRequest = $this->getRequest();
        $objFlashMessage = $this->flashMessenger()
                                ->setNamespace('SONUser');
        
        if ($objRequest->isPost()) {            
            $objForm->setData($objRequest->getPost()->toArray());
            
            if ($objForm->isValid()) {
                $objService = $this->getServiceLocator()
                                       ->get($this->service);
                if ($objService->inserir($objForm->getData())) {
                    $objFlashMessage->addMessage($mensagem);
                    return $this->redirect()->toRoute($this->route,
                            array('controller' => $this->controller,
                                  'action' => 'novo'));                    
                }                
            }            
        }                
                
        return new ViewModel(array('objForm' => $objForm, 
            'mensagens' => $objFlashMessage->getMessages()));
    }
            
    public function alterarAction($mensagem) {
        $objForm = new $this->form();
        $objRequest = $this->getRequest();
        $objFlashMessage = $this->flashMessenger()
                                ->setNamespace('SONUser');        
        if ($objRequest->isPost()) {
            $objForm->setData($objRequest->getPost()->toArray());
            if ($objForm->isValid()) {
                $objService = $this->getServiceLocator()
                                       ->get($this->service);
                if ($objService->alterar($objForm->getData())) {
                    $objFlashMessage->addMessage($mensagem);
                    return $this->redirect()->toRoute($this->route,
                            array('controller' => $this->controller,
                                  'action' => 'alterar', 
                                'id' => $this->params('id')));                    
                }                
            }
        }        
        
        $objRepository = $this->getEm()->getRepository($this->entity);
        if ($this->params('id', 0)){            
            $objForm->setData($objRepository->find($this->params('id'))->toArray());
        }
        
        return new ViewModel(array('objForm' => $objForm, 
            'mensagens' => $objFlashMessage->getMessages()));
    }
    
    public function deletarAction() {        
        $objService = $this->getServiceLocator()->get($this->service);        
        
        if ($this->params('id', 0)) {
            if($objService->deletar($this->params('id', 0))){
                return $this->redirect()->toRoute($this->route, 
                        array('controller' => $this->controller));
            }
        }
    }
    
    /**
     * @return 'Doctrine\ORM\EntityManager'
     */
    public function getEm() {
        if ($this->em === null) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
            
            return $this->em;
        }
    }
}
