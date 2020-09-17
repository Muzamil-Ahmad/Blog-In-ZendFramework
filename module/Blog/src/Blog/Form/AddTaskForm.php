<?php
namespace Blog\Form;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
Class AddTaskForm extends Form
{
	public function __construct($name = null, $options = array())
	{
 		parent::__construct('blog');
		$this->setAttribute('method','post');
		$this->setAttribute('id','myForm');
		$this->setHydrator(new ClassMethods());
		$this->setInputFilter(new AddTaskFilter());
		$this->add(array(
				'name' => 'taskname',
				'type' => 'text',
				'options' => array(
						'label' => 'Task Name',
				),
				'attributes' => array(
						 'id' => 'taskname',
						 'class'=>'form-control',
						 'placeholder'=>'Enter Taskname...',
						 'maxlength' => 100,
				)
		));
		$this->add(array(
				'name' => 'duedate',
				'type' => 'date',
				'options' => array(
						'label' => 'Due Date'
						
				),
				'attributes' => array(
						'id' => 'duedate',
						'class'=>'form-control',			
				)
		));
		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						'id' => 'sub',
						'type' => 'button',
						'value' => 'Add',
						'class'=>'btn btn-success button-position',
				),
		));
		$this->add(array(
				'name' => 'taskstatus',
				'type' => 'checkbox',
				'options' => array(
						
						'label_attributes' => array('class'=>'checkbox'),
				),
				'attributes' => array(
						'onchange'=>'completeTask(this)',
				),
				
		));
		
	}
}
?>