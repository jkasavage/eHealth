<?php

namespace CSF\Modules;

/**
 * Exception Class
 * 
 * Do NOT modify
 * 
 * @author Joseph Kasavage
 */

class Exceptions
{
	/**
	 * Handle PDOExceptions
	 * 
	 * @param  PDOException $ex
	 * 
	 * @return Exception
	 */
	public static function SQLError(PDOException $ex)
	{
		throw new \Exception("SQL — Your request could not be completed due to the following error(s): <br />" . $ex->getMessage() . ' on  line ' . $ex->getLine() . '<br /><br />');
	}

	/**
	 * Table missing from Parameter Array
	 * 
	 * @return Exception
	 */
	public static function SQLnoTableError()
	{
		throw new \Exception("SQL — You must specify a table name in the given parameters!");
	}

	/**
	 * Column/Value Mismatch
	 * 
	 * @return Exception
	 */
	public static function SQLvalueMismatch()
	{
		throw new \Exception("SQL — The number of columns given do not match the number of values given!");
	}

	/**
	 * Missing Columns or Values
	 * 
	 * @return Exception
	 */
	public static function SQLmissingParams()
	{
		throw new \Exception("SQL — You must include columns and values!");
	}

	/**
	 * Limit method missing Integer Value
	 *
	 * @return Exception
	 */
	public static function SQLlimitMissingInt()
	{
		throw new \Exception("SQL — You must include an integer value when using the <b>limit</b> method!");
	}

	/**
	 * Alert dev that you can not use Data::executeAll() on any server except HCS
	 *
	 * @return Exception
	 */
	public static function SQLexecuteAllWrongSite()
	{
		throw new \Exception("SQL — You can not use this method on this server!");
	}
}