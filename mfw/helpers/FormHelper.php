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

namespace mfw\helpers
{
	
/**
 * This is a WIP utility class for quickly duplicating common
 * PHP to HTML activities.
 * 
 * Currently it creates selection lists from various collection types.
 */
class FormHelper {
	
	/**
	 * Output the select box with the given Iterator a a value
	 *
	 * @param Iterator $list
	 * @param mixed $value The Selected Value
	 */
	public static function listToOptions(Iterator $list,
										 $value = null) {
		foreach($list as $key => $display) {
			echo "<option value='$key'";
			if($value != null)
				if($key == $value)
					echo " selected";
			echo ">$display</option>";
		}
	}
	
	/**
	 * Output the select box with the given assoc array an value
	 *
	 * @param assoc Array $list
	 * @param mixed $value The Selected Value
	 */
	public static function arrayToOptions(Array $list,
										  $value = null) {
		foreach($list as $key => $display) {
			echo "<option value='$key'";
			if($value != null)
				if($key == $value)
					echo " selected";
			echo ">$display</option>";
		}
	}
	
	/**
	 * Output the select box with the given row columns as values
	 *
	 * @param assoc Array $rows
	 * @param string $col_value
	 * @param string $col_view
	 * @param mixed $value The Selected Value
	 */
	public static function rowsToOptions(Array $rows,
										 $col_value,
										 $col_view,
										 $value = null) {
		foreach($rows as $row) {
			$val = $row[$col_value];
			$view = $row[$col_view];
			echo "<option value='$val'";
			if($value != null)
				if($val == $value)
					echo " selected";
			echo ">$view</option>";
		}
	}
	
}

}
?>