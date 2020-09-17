<?php
namespace Registration\Form;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class RegForm extends Form
{
	public function __construct($name = null, $options = array())
	{
		parent::__construct('registration');

		$this->setAttribute('method','post');
		
    	$this->setInputFilter(new RegFilter());
		$this->setHydrator(new ClassMethods());
		$this->add(array(
				'name' => 'userid',
				'type' => 'hidden',
				
		));
			
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
				'name' => 'password',
				 'type' => 'Zend\Form\Element\Password',
				
				'attributes' => array(
						'id' => 'form_password',
						'maxlength' => 100,
						'placeholder' => 'Enter Password',
						'class'=>'form-control',
				),
		
		
				'options' => array(
						'label' => 'Password',
		
		
		
				),
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