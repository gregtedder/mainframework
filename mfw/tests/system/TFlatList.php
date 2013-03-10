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

class TFlatList extends PHPUnit_Framework_TestCase {
	
	public function testSet() {
		$list = new mfw\system\FlatList();
		$this->assertFalse($list->has('name'));
		// first way to set
		$list->set('name', 'TEST');
		$this->assertTrue($list->has('name'));
		// second way to set
		$list->email = 'test@test.test';
		$this->assertTrue($list->has('email'));
	}
	
	public function testGet() {
		$list = new mfw\system\FlatList();
		// first way to set/get
		$list->set('name', 'TEST');
		$value = $list->get('name');
		$this->assertEquals('TEST', $value);
		// second way to set/get
		$list->email = 'test@test.test';
		$value = $list->email;
		$this->assertEquals('test@test.test', $value);
	}
	
	public function testIsset() {
		$list = new mfw\system\FlatList();
		$this->assertFalse( isset($list->name) );
		// first way to set
		$list->set('name', 'TEST');
		$this->assertTrue( isset($list->name));
		// second way to set
		$list->email = 'test@test.test';
		$this->assertTrue( isset($list->email));
	}
	
	public function testRemove() {
		$list = new mfw\system\FlatList();
		$list->set('name', 'TEST');
		$list->email = 'test@test.test';
		// first way to remove
		$this->assertTrue($list->has('name'));
		$list->remove('name');
		$this->assertFalse($list->has('name'));
		// second way to remove
		$this->assertTrue($list->has('email'));
		unset($list->email);
		$this->assertFalse($list->has('email'));
	}
	
	/** 
	 * 
	 * @expectedException Exception
	 */
	public function testGetExceptionOne() {
		$list = new mfw\system\FlatList();
		$list->get('name');
	}
	
	/** 
	 * 
	 * @expectedException Exception
	 */
	public function testGetExceptionTwo() {
		$list = new mfw\system\FlatList();
		$list->name;
	}
	
}
?>