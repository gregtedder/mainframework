<?php

class HomeController extends mfw\system\Controller {
	
	public function get() {
		$parameters = array(
			'date' => date('Y-m-d')
		);
		$template = new mfw\system\Template('default.php');
		$this->loadViewToTemplate($template, 'home', $parameters);
	}
	
}

?>