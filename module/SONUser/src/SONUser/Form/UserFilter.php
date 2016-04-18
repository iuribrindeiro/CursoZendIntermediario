<?php

namespace SONUser\Form;

use Zend\InputFilter\InputFilter;

class UserFilter extends InputFilter {
    
    public function __construct() {
        $this->add(array(
            'name' => 'nome',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim')
            ),
            'validators' => array(
                array('name' => 'NotEmpty', 
                    'options' => array(
                    'messages' => array(
                        'isEmpty' => 'Nao pode estar em branco'
                    )
                ))
            )
        ));
        
        $validEmail =   new \Zend\Validator\EmailAddress();
        $validEmail->setOptions(array('domain' => FALSE));
        
        $this->add(array(
            'name' => 'email',
            'validators' => array($validEmail,
                array('name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Nao pode estar em branco'                            
                        )
                    )
                ),
                array('name' => 'Regex',
                    'options' => array(
                        'pattern' => "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/",
                        'messages' => array(
                            'regexNotMatch' => 'Esse email não é válido. Insira por exemplo: email@email.com'
                        )
                    ))
            )
        ));
        
        $this->add(array(
            'name' => 'password',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim')
            ),
            'validators' => array(
                array('name' => 'NotEmpty', 
                    'options' => array(
                    'messages' => array(
                        'isEmpty' => 'Nao pode estar em branco'
                    )
                ))
            )
        ));
        
        $this->add(array(
            'name' => 'confirmacao',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim')
            ),
            'validators' => array(
                array('name' => 'NotEmpty',                                         
                    'options' => array(
                    'messages' => array(
                        'isEmpty' => 'Nao pode estar em branco'                        
                    )
                )
            ),
            array('name' => 'Identical', 'options' => array(
                'token' => 'password',
                'messages' => array(
                    'notSame' => 'Senhas diferentes'
                )))    
        )));
    }
}
