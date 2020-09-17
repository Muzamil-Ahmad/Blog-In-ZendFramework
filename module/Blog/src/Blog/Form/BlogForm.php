<?php
namespace Blog\Form;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class BlogForm extends Form
{
	public function __construct($name = null, $options = array())
	{
		parent::__construct('blog');

		$this->setAttribute('method','post');
		$this->setInputFilter(new BlogFilter());
		$this->setHydrator(new ClassMethods());
		
		$this->add(array(
				'name' => 'id',
				'type' => 'hidden',
				
		));
		
		$this->add(array(
				'name' => 'title',
				'type' => 'text',
				
				
				'options' => array(
						'label' => 'Title',
// 						'class'=>'form-control',
                      
						
// 						'label_attributes' => array('class'=>'form-control'),
						
				),
				'attributes' => array(
						'id' => 'id',
						'maxlength' => 50,
						'placeholder' => 'Enter title',
						'class'=>'form-control',
				)
		));
		$this->add(array(
				'name' => 'userpost',
				'type' => 'textarea',
				'attributes' => array(
						'rows' => 10,
						'cols' => 116,
							
						'maxlength' => 1000,
						'class'=>'form-control',
				),
				'options' => array(
						'label' => 'Post',
							
						 
				),
		));
		$this->add(array(
				'name' => 'userphoto',
				'type' => 'file',
				'attributes' => array(
						'padding' => 2,
				         'class' =>'card-img-top',
		
				),
		
		
				'options' => array(
						'label' => 'Upload Image',
		
		
		
				),
		));
		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						'type' => 'submit',
						'value' => 'Go',
						'class' => 'btn btn-primary',
						'float' => 'right',
		
				),
		));
	
		
	}
}

?>