<?php
namespace Registration\Form;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class LoginForm extends Form
{
	public function __construct($name = null, $options = array())
	{
		parent::__construct('login');

		$this->setAttribute('method','post');
		
    	$this->setInputFilter(new LoginFilter());
		$this->setHydrator(new ClassMethods());
		
			
		$this->add(array(
				'name' => 'username',
				'type' => 'text',
				
				
				'options' => array(
						'label' => 'Username',
// 						'class'=>'form-control',
                      
						
// 						'label_attributes' => array('class'=>'form-control'),
						
				),
				'attributes' => array(
						'id' => 'form_username',
						'maxlength' => 50,
						'placeholder' => 'Enter username',
						'class'=>'form-control',
				)
		));
		
		
		
		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						
						'type' => 'submit',
						
						'value' => 'create account',
						'class' => 'btn btn-primary',
						
		
				),
		));
	
		
	}
}

?>