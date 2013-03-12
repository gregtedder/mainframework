<?php

class TestController extends mfw\system\Controller {
	
	public function get() {
		echo "Get Method";
	}
	
	public function getView($description) {
		$parameters = array(
			'description' => $description
		);
		$template = new mfw\system\Template('test.php');
		$this->loadView('test_view_two', $parameters);
	}
	
	public function getTemplateView() {
		$parameters = array(
			'date' => date('Y-m-d')
		);
		$template = new mfw\system\Template('test.php');
		$this->loadViewToTemplate($template, 'test_view', $parameters);
	}
	
}

?>