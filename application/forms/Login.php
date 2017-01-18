<?php
/**
 * World DB demo
 * 
 * @author Sheila Fenelon (sheila@shefen.com)
 *
 */
class Application_Form_Login extends Zend_Form
{
    public function init()
    {
        $this->setName("login");
        $this->setMethod('post');
        $this->addAttribs(array( 'class' => 'form-horizontal'));
        
        $username = new Zend_Form_Element_Text('username'); 
        $username->setLabel('Username: ');
        $username->size = 20;  
        $username->setRequired(true)->addValidator('NotEmpty', true);
        // add some bootstrap classes for jQuery validation
        $username->setOptions(
            array(
              'data-validation'=>'required',
              'data-validation-error-msg'=>'Please enter a username'
            )
        ); 
                
        $password = new Zend_Form_Element_Password('password');        
        $password->setLabel('Password: ');
        $password->size = 20;
        $password->setRequired(true)->addValidator('NotEmpty', true);
        // for jQuery validation
        $password->setOptions(
            array(
              'data-validation'=>'required',
              'data-validation-error-msg'=>'Please enter a password'
            )
        ); 
        
        $this->addElement($username);
        $this->addElement($password);
        
        // don't add submit yet or the next bit will add <label></label> to the submit element
        
		$this->setElementDecorators(array(
            array('ViewHelper'),
            array('Errors'),
            array('Description'),
            array('Label', array('class' => 'control-label')),
            array('HtmlTag', array('tag' => 'div', 'class'=>'form-group')),  // Bootstrap form css
        ));
        
        // wrapper for elements
        $this->addDecorator('FormElements')
             ->addDecorator('Form');
         
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Login');
        $submit->removeDecorator('DtDdWrapper');
        $this->addElement($submit);

    }
}
