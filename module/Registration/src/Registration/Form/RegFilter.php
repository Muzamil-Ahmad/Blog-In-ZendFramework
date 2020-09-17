<?php

namespace Registration\Form;

use Zend\InputFilter\InputFilter;
use Zend\Form\Element\Hidden;

class RegFilter extends InputFilter {
	public function __construct()
	{
		$this->add(array(
				'name' => 'username',
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