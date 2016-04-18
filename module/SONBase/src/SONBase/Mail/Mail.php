<?php

namespace SONBase\Mail;

use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Message;
use Zend\View\Model\ViewModel;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class Mail {
    
    
    private $transport;    
    private $view;
    private $body;
    private $message;
    private $subject;
    private $to;
    private $data;
    private $page;
    
    public function __construct(SmtpTransport $transport, $view, $page) {
        $this->transport = $transport;
        $this->view = $view;
        $this->page = $page;
    }
    
    public function setSubject($subject) {
        $this->subject = $subject;
        return $this;
    }
    
    public function setTo($to) {
        $this->to = $to;
        return $this;
    }
    
    public function setData($data) {
        $this->data = $data;
        return $this;
    }
    
    //cria o email com todo o conteudo já inserido
    public function renderView($page, array $data) {
        $model = new ViewModel();
        $model->setTemplate("mailer/{$page}.phtml");
        $model->setOption("has_parent", true);
        $model->setVariables($data);
        
        //retorna a pagina com o email                
        return $this->view->render($model);
    }
    //prepara o email para ser enviado, isto é: 
    //configura a maneira como será enviado e invoca a função renderView()
    public function prepare() {
        //retorna um html com a pagina do email criada.
        $html = new MimePart($this->renderView($this->page, $this->data));
        $html->type = "text/html";
                
        $body = new MimeMessage();
        $body->setParts(array($html));
        $this->body = $body;
        
        $config = $this->transport->getOptions()->toArray();
        
        $this->message = new Message();
        $this->message->addFrom($config['connection_config']['from'])
                ->addTo($this->to)
                ->setSubject($this->subject)
                ->setBody($this->body);
        
        return $this;
    }
    
    //por fim, envia o email
    public function send() {        
        $this->transport->send($this->message);
    }
}
