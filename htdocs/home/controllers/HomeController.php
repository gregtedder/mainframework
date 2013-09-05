<?php

class HomeController extends mfw\system\Controller {
	
	public function get() {
		mfw\system\log\MFWLog::logMessage(new mfw\system\log\LogMessage('Message'));
		mfw\system\log\MFWLog::logMessage(new mfw\system\log\LogMessage('Message', false));
		$parameters = array(
			'date' => date('Y-m-d')
		);
		$template = new mfw\system\Template('default.php');
		$this->loadViewToTemplate($template, 'home', $parameters);
	}
	
}

?>