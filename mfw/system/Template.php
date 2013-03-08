<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2013 Greg Tedder
 *
 * Permission is hereby granted, free of charge, to any person obtaining a 
 * copy of this software and associated documentation files (the "Software"), 
 * to deal in the Software without restriction, including without limitation 
 * the rights to use, copy, modify, merge, publish, distribute, sublicense, 
 * and/or sell copies of the Software, and to permit persons to whom the 
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included 
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS 
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER 
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING 
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER 
 * DEALINGS IN THE SOFTWARE.
 */

namespace mfw\system
{

/** 
 * 
 * This is a simple template engine that uses a flat list to store parameters
 * for the templates, and extracts them as local variables for the template.
 * 
 * <code>
 * $template = new Template('visa_pages/visa_side_bar.php');
 * $template->country = 'Brazil';
 * $template->render();
 * </code>
 * 
 */
class Template extends FlatList implements Renderable {
	
	/** 
	 * 
	 * This is a static method for use within the template files. It
	 * will auto detect how to output the given variable. 
	 * 
	 * It will either detect
	 * 1. that it is a view or template, and render
	 * 2. that it is a string and print
	 * 3. that it does not exist and ignore
	 * 
	 * @param mixed $variable
	 */
	public static function out($variable) {
		if(isset($variable) && is_object($variable) && $variable instanceof Renderable) { // method_exists($variable, 'render')) {
			$variable->render();
		} else if(isset($variable)) {
			echo $variable;
		}
	}
	
	/** 
	 * 
	 * @var string
	 */
	protected $template_file;
	
	/** 
	 * 
	 * @param string $template_file
	 */
	public function __construct($template_file) {
		if(substr($template_file, 0, 0) == '/') {
			throw new \ErrorException("Error: Do not lead file name with forward slash");
		}
		$this->template_file = MFW_PATH . '/content/templates/' . $template_file;
		if(!file_exists($this->template_file)) {
			throw new \ErrorException("Error: Template file does not exist");
		}
	}
	
	/** 
	 * 
	 * Get the output buffer of this template
	 * 
	 * @return string
	 */
	public function getOutputBuffer() {
		if(count($this->parameters) > 0)
			extract($this->parameters);
		ob_start();
		require($this->template_file);
		$output = ob_get_contents();
		ob_clean();
		return $output;
	}
	
	/** 
	 * 
	 * Render the template
	 */
	public function render() {
		if(count($this->parameters) > 0)
			extract($this->parameters);
		ob_start();
		require($this->template_file);
		ob_end_flush();
	}
	
}

}

?>