<?php

define('MAIN_FRAME_WORK', '/Users/gregtedder/git/mainframework/mfw/config/config.php');

define('DOC_ROOT', __DIR__);

include MAIN_FRAME_WORK;

class Form {
	
	private $form;
	
	private $paramerters;
	
	public function __construct($form, $parameters) {
		$this->form = $form;
		$this->paramerters = $parameters;
	}
	
	public function processField($label, $field) {
		if(!isset($field['type'])) 
			throw new Exception('Expecting: type, in field: ' . $label);
		$type = $field['type'];
		if(($type instanceof FormField) == false)
			throw new Exception("Type in field: $label, is not an instance of FormField");
		return $type->generateField($label, $field, $this->paramerters);
	}
	
	public function render() {
		foreach($this->form as $label => $field) {
			print_r( $this->processField($label, $field)); echo "\n\n";
		}
	}
	
}

interface FormField {
	public function generateField($label, $field, $parameters);
}

class FormFieldString implements FormField {
	public function __construct($id, $required = false) {
		$this->id = $id;
		$this->required = $required;
	}
	public function generateField($label, $field, $parameters) {
		// TODO Template
		$template = new \mfw\system\Template('forms/bootstrap.php');
		$template->id = $this->id;
		if(isset($field['name']))
			$template->name = $field['name'];
		else 
			$template->name = $template->id;
		$template->class = 'string';
		if($this->required)
			$template->class .= ' required';
		$template->value = '';
		if(isset($parameters[$template->name]))
			$template->value = $parameters[$template->name];
		$template->placeholder = '';
		if(isset($field['placeholder'])) 
			$template->placeholder = $field['placeholder'];
		return $template->getOutputBuffer();
	}
}

class FormFieldGroup implements FormField {
	
	public function processField($label, $field, $parameters) {
		if(!isset($field['type'])) 
			throw new Exception('Expecting: type, in field: ' . $label);
		$type = $field['type'];
		if(($type instanceof FormField) == false)
			throw new Exception("Type in field: $label, is not an instance of FormField");
		return $type->generateField($label, $field, $this->paramerters);
	}
	
	public function generateField($label, $field, $parameters) {
		$group = '';
		foreach($field as $sub_label => $sub_field) {
			if($sub_label == 'type')
				continue;
			$group .= $this->processField($sub_label, $sub_field, $parameters);
		}
		return $group;
	} 
	
}

class FormFieldRadio implements FormField {
	
	public function __construct($id, $required = false) {
		$this->id = $id;
		$this->required = $required;
	}
	
	public function generateField($label, $field, $parameters) {
		if(!isset($field['type'])) 
			throw new Exception('Expecting: type, in field: ' . $label);
		$type = $field['type'];
		if(($type instanceof FormField) == false)
			throw new Exception("Type in field: $label, is not an instance of FormField");
		
		$id = $this->id;
		if(isset($field['name']))
			$name = $field['name'];
		else 
			$name = $id;
		$required = '';
		if($this->required)
			$required = 'required';
		$field = "<input type='text' class='string $required' id='$id' name='$name'";
		if(isset($parameters[$name]) && $parameters[$name] == $field['value'])
			$field .= ' checked="checked"';
		$field .= '>';
		return $field;
	} 
	
}




$form = array(
	'First Name' => array(
		'type' => new FormFieldString('first_name', true),
		'required' => true,
		'id' => 'first_name',
		'placeholder' => 'First Name',
	),
	'Sex' => array(
		'type' => new FormFieldGroup(),
		'Male' => array(
			'type' => new FormFieldRadio('sex_male', true),
			'value' => 'M',
			'name' => 'sex'
		),
		'Female' => array(
			'type' => new FormFieldRadio('sex_female', true),
			'value' => 'F',
			'name' => 'sex'
		),
	),
);

$parameters = array(
	'first_name' => 'Alice',
	'sex' => 'F',
);


$form = new Form($form, $parameters);

$form->render();



?>