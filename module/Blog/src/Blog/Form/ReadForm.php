<?php
namespace Blog\Form;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Blog\Form\ReadFilter;

class ReadForm extends Form
{
	public function __construct($name = null, $options = array())
	{
		parent::__construct('blog');

		$this->setAttribute('method','post');
// 		$this->setInputFilter(new ReadFilter());
		$this->setHydrator(new ClassMethods());
		$this->add(array(
				'name' => 'id',
				'type' => 'hidden',

		));
		$this->add(array(
				'name' => 'comment',
				'type' => 'textarea',
				'attributes' => array(
						'rows' => 1,
						'cols' => 50,
						'placeholder' => 'Write a comment...',
						'id'=>'comment-section',	
						'maxlength' => 100,
						'class'=>'form-control',
				),
		));
		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						'type' => 'submit',
						'value' => 'Comment',
						'id' => 'commentid',
						'class' => 'btn btn-primary mb-2',
				),
		));
		


	}
}

?>