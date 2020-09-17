<?php
namespace Blog\Form;

use Zend\InputFilter\InputFilter;
use Zend\Form\Element\Hidden;

class BlogFilter extends InputFilter
{
	public function __construct()
	{
// 		$this->add(array(
// 				'name' => 'id',
// 				'required' => true,
// 				'filters' => array(
// 						array('name' => 'Int'),
// 				),
// 		));

		$this->add(array(
				'name' => 'title',
				'required' => true,
				'filters' => array(
						array('name' => 'StripTags'),
						array('name' => 'StringTrim'),
				),
				'validators' => array(
						array(
								'value' => 'hidden',
								'name' => 'StringLength',
								'options' => array(
										'encoding' => 'UTF-8',
										'max' => 100
								),
						),
				),
		));
		
	}
}