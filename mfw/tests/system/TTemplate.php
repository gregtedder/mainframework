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

require 'config.php';

class TRouter extends PHPUnit_Framework_TestCase {
	
	public function testTemplate() {
		$template = new mfw\system\Template('test.php');
		$this->assertTrue(is_object($template));
	}
	
	/** 
	 * 
	 * @expectedException ErrorException
	 */
	public function testTemplateException() {
		$template = new mfw\system\Template('non-existant-file.php');
	}
	
	/** 
	 * 
	 * @expectedException ErrorException
	 */
	public function testTemplateExceptionTwo() {
		$template = new mfw\system\Template('/non-existant-file.php');
	}
	
	public function testGetOutputBuffer() {
		$template = new mfw\system\Template('test.php');
		$this->assertEquals('This is for Unit Testing Templates ', $template->getOutputBuffer());
		$template->extra_value = "Dynamic Template Content";
		$this->assertEquals('This is for Unit Testing Templates Dynamic Template Content', $template->getOutputBuffer());
	}
	
	public function testRender() {
		$template = new mfw\system\Template('test.php');
		ob_start(); 
		$template->render();
		$value = ob_get_clean();
		$this->assertEquals('This is for Unit Testing Templates ', $value);
		$template->extra_value = "Dynamic Template Content";
		ob_start(); 
		$template->render();
		$value = ob_get_clean();
		$this->assertEquals('This is for Unit Testing Templates Dynamic Template Content', $value);
	}
	
}
?>