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

/*
 *
 * MFW.php
 *
 * This file sets up the basic functionality.
 *
 */

set_include_path(get_include_path() . PATH_SEPARATOR . MFW_PATH);

include 'mfw/config/database.php';

/**
 *
 * All errors as Exceptions
 */
function createException( $errno, $errstr, $errfile, $errline ) {
	switch ($errno) {
		case E_USER_ERROR:
			throw new ErrorException($errstr, $errno, $errno, $errfile, $errline );
			break;
		default:
			throw new Exception($errstr, $errno);
			break;
	 }
}
//set_error_handler('createException');

/**
 *
 * Autoload the framework files
 */
function __autoload ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
	include ($class . '.php');
}

?>