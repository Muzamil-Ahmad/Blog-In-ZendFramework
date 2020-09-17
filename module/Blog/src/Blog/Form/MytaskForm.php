<?php
namespace Blog\Form;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Blog\Form\ReadFilter;
class MytaskForm extends Form
{
	public function __construct($name = null, $options = array())
	{
	parent::__construct('blog');
	
	$this->setAttribute('method','post');
// 	$this->setInputFilter(new TaskFilter());
	$this->setHydrator(new ClassMethods());

         $this->add(array(
				'name' => 'taskstatus',
				'type' => 'checkbox',
				'options' => array(
// 						'label' => 'Task Status',
						'label_attributes' => array('class'=>'checkbox'),
				),
		));
         $this->add(array(
         		'name' => 'submit',
         		'attributes' => array(
         				'type' => 'submit',
         				'value' => 'Done',
         				'class' => 'btn btn-primary',
         		),
         ));
}
}