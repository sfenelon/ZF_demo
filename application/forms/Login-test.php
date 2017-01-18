<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        $this->setName("login");
        $this->setMethod('post');
        
        $this->addElement('text', 'username', array(
			'filters' => array('StringTrim', 'StringToLower'),
			'validators' => array(
                array('StringLength', false, array(0, 25)),
            ),
			'required' => true,
			'label' => 'Username:',
        ));

        $this->addElement('password', 'password', array(
			'filters' => array('StringTrim'),
			'validators' => array(
                array('StringLength', false, array(0, 25)),
            ),
			'required' => true,
			'label' => 'Password:',
        ));

        $this->addElement('submit', 'login', array(
			'required' => false,
			'ignore' => true,
			'label' => 'Login',
        ));
        
        
         $this->setElementDecorators(array(
            array('ViewHelper'),
            array('Errors'),
            array('Description'),
            array('Label', array('class' => 'control-label', 'separator'=>'<br/>')),
            array('HtmlTag', array('tag' => 'div', 'class'=>'form-group')),
        ));
        
        // wrapper for elements
        $this->addDecorator('FormElements')
         ->addDecorator('HtmlTag', array('tag' => '<div>', 'class'=>'form-group center-block'))
         ->addDecorator('Form');
    }
}
