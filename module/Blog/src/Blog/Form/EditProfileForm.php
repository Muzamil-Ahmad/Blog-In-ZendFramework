<?php
namespace Blog\Form;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
// use Blog\Form\UserProfileFilter;

class EditProfileForm extends  Form
{
	public function __construct($name = null, $options = array())
	{
		parent::__construct('blog');

		$this->setAttribute('method','post');
// 		$this->setInputFilter(new UserProfileFilter());
		$this->setHydrator(new ClassMethods());
		$this->add(array(
				'name' => 'id',
				'type' => 'hidden',

		));
		$this->add(array(
				'name' => 'username',
				'type' => 'text',
				
				'options' => array(
						'label' => 'Username:',
					'label_attributes' => array(
								'class' => 'pull-left',
								),
						
						
						
						),
				'attributes' =>array(
						'placeholder' => 'Username...',
						'id'=>'usernameid',
						'label'=>'Username:',	
						'maxlength' => 100,
						'class'=>'form-control',
				),
		));
		$this->add(array(
				'name' => 'password',
				'type' => 'password',
				
				'options'=> array(
						'label'=>'Password:',
						'label_attributes' => array(
								'class' => 'pull-left',
								),
				),
				'attributes' => array(
						'placeholder' => 'Enter Password...',
						'id'=>'password',
						'maxlength' => 100,
						'class'=>'form-control',
				),
		));
		$this->add(array(
				'name' => 'email',
				'type' => 'text',
				'options'=> array(
						'label'=>'E-mail Id:',
						'label_attributes' => array(
								'class' => 'pull-left',
								),
				),
				'attributes' => array(
						'placeholder' => 'Enter your email-id...',
						'id' => 'email',
						'maxlength' => 100,
						'class'=>'form-control',
				),
		));
		$this->add(array(
				'name' => 'phoneno',
				'type' => 'text',
				'options'=> array(
						'label'=>'Mobile No:',
						'label_attributes' => array(
								'class' => 'pull-left',
						),
						
				),
				'attributes' => array(
						'placeholder' => 'Enter phone no...',
						'id'=>'phone',
						'class'=>'form-control',
				),
		));
		$this->add(array(
				'name' => 'address',
				'type' => 'text',
				'options'=> array(
						'label'=>'Address:',
    					'label_attributes' => array(
								'class' => 'pull-left',
								),
				),
				'attributes' => array(
						'placeholder' => 'Enter your address...',
						'maxlength' => 100,
						'id'=>'addressid',
						'class'=>'form-control',
				),
		));	
		$this->add(array(
				'name' => 'profession',
				'type' => 'text',
				'options'=> array(
						'label'=>'Profession:',
						'label_attributes' => array(
								'class' => 'pull-left',
						),
				),
				'attributes' => array(
						'placeholder' => 'Enter your designation...',
						'maxlength' => 100,
						'id'=>'professionid',
						'class'=>'form-control',
				),
		));
		
		$this->add(array(
				'name' => 'submit',
				'type' => 'submit',
				'attributes' => array(
						'value' => 'Submit',
						'id' => 'profileid',
						'class' => 'btn btn-primary',
				),
		));
		


	}
}

?>