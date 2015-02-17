<?php

namespace CSF\Modules;

/**
 * Validation - Club Systems Framework
 * Do NOT modify
 * 
 * Copyright Club Systems 2015
 * @author Joseph Kasavage
 */

class Validate
{
	/**
	 * Validate Email
	 * 
	 * @param String $input
	 *
	 * @return Boolean
	 */
	public static function FilterEmail($input)
	{
		$input = trim($input);

		$val = filter_var($input, FILTER_VALIDATE_EMAIL);

		if($val) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Validate Phone Number
	 * 
	 * @param String $input
	 *
	 * @return Boolean
	 */
	public static function FilterPhoneNumber($input)
	{
		$input = trim($input);

		if(preg_match("/^\D?(\d{3})\D?\D?(\d{3})\D?(\d{4})$/", $input)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Validate Numerical Input
	 * 
	 * @param String $input
	 *
	 * @return Boolean
	 */
	public static function FilterNumerical($input) 
	{
		$input = trim($input);

		if(is_numeric($input)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Validate a String (No Special Characters)
	 * 
	 * @param String $input
	 *
	 * @return Boolean
	 */
	public static function FilterString($input)
	{
		$input = trim($input);

		if(preg_match("/^[a-zA-z ]+$/i", $input) != 0) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Validate a String (With Special Characters)
	 * 
	 * @param String $input
	 *
	 * @return Boolean
	 */
	public static function FilterSpecialString($input)
	{
		$input = trim($input);

		if(preg_match("/^[a-zA-z !@#$%^&*()]+$/i", $input) != 0) {
			return true;
		} else {
			return false;
		}
	}
}