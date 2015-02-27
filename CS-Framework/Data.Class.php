<?php
namespace CSF\Modules;

/**
 * Data Abstraction Layer - Club Systems Framework
 * Do NOT modify
 *
 * Usage: This class is specifically made to use chain methods.
 * 		  Example:
 * 		  	$obj->selectData(array("table"=>"table name", "columns"=>array("column1", "column2")))
 * 		  	    ->where(array("column", "value"))
 * 		  	    ->limit(array(5))
 * 		  	    ->execute();
 * 
 * Copyright Club Systems 2015
 * @author Joseph Kasavage
 */

class Data 
{
	/**
	 * Customer Identity
	 * 
	 * @var String
	 */
	private $data_ident = "";

	/**
	 * Customer Site
	 * 
	 * @var Integer
	 */
	private $data_site = 0;

	/**
	 * Global Variables
	 * 
	 * @var Object
	 */
	private $globals;

	/**
	 * Query Builder
	 * 
	 * @var String
	 */
	private $builder = "";

	/**
	 * Request Array
	 * 
	 * @var array
	 */
	private $request = array();

	/**
	 * SQL Type
	 * 
	 * @var String
	 */
	private $buildType = "";

	/**
	 * Counter
	 * 
	 * @var integer
	 */
	private $counter = 1;

	/**
	 * Database
	 * @var String
	 */
	private $database = "";

	/**
	 * Server
	 * 
	 * @var String
	 */
	private $server = "";

	/**
	 * Class Constructor - Set Identifier and Site from Config.Class.php
	 *
	 * Usage: $obj = new Data("tableName");
	 * 
	 * @param String $database
	 */
	public function __construct($database)
	{
		$this->globals = new Config();
		$this->database = $database;

		$this->data_ident =	$this->globals->getIdent();
		$this->data_site = $this->globals->getSite();
		$this->server = $this->globals->getServer();
	}

	/**
	 * Set the Server to specific Host
	 * 
	 * @param String $server
	 */
	public function setServer($server)
	{
		$this->server = $server;
	}

	/**
	 * Accept Raw SQL Requests without Parameters
	 *
	 * Usage: $obj->rawRequest("PUT QUERY HERE");
	 *        All words aside from table should be
	 *        in caps.
	 * 
	 * @param  String $sql  
	 * 
	 * @return Boolean OR Array
	 */
	public function rawRequest($sql)
	{
		try {
			$con = new \PDO("mysql:host=$this->server;dbname=$this->database", $this->globals->getUser(), $this->globals->getPwd());
            $prep = $con->prepare($sql);
            $prep->execute();

            $check = $prep->rowCount();

            $type = explode(" ", $sql);

            switch($type[0]) {
            	case 'UPDATE':
            	case 'DELETE':
            	case 'INSERT':
            		if($check) {
            			$this->builder = "";
						$this->buildType = "";
						$this->counter = 0;
            			return true;
            		} else {
            			$this->builder = "";
						$this->buildType = "";
						$this->counter = 0;
            			return false;
            		}

            		break;

            	case 'SELECT':
            		$data = $prep->fetchAll(\PDO::FETCH_ASSOC);
            		$this->builder = "";
					$this->buildType = "";
					$this->counter = 0;
            		return $data;
            		break;
            }
		} catch (PDOException $ex) {
			Exceptions::SQLError($ex);
		}
	}

	/**
	 * Accept Raw SQL with Parameters
	 *
	 * Usage: $obj->rawRequestWithParam("SELECT * FROM table WHERE param=? AND param2=?", array("param", "param2"));
	 * 
	 * @param  String $sql
	 * @param  Array  $param
	 * 
	 * @return Boolean OR Array
	 */
	public function rawRequestWithParam($sql, Array $param)
	{
		try {
			$con = new \PDO("mysql:host=$this->server;dbname=$this->database", $this->globals->getUser(), $this->globals->getPwd());
            $prep = $con->prepare($sql);
            $prep->execute($param);

            $type = split(" ", $sql);

            switch($type[0]) {
            	case 'UPDATE':
            	case 'DELETE':
            	case 'INSERT':
            		if($check) {
            			$this->builder = "";
						$this->buildType = "";
						$this->counter = 0;
            			return true;
            		} else {
            			$this->builder = "";
						$this->buildType = "";
						$this->counter = 0;
            			return false;
            		}

            		break;

            	case 'SELECT':
            		$data = $prep->fetchAll(\PDO::FETCH_ASSOC);
            		$this->builder = "";
					$this->buildType = "";
					$this->counter = 0;
            		return $data;
            		break;
            }
		} catch (PDOException $ex) {
			Exceptions::SQLError($ex);
		}
	}

	/**
	 * Check Builder - Debugging
	 * 
	 * @return String
	 */
	public function getBuilder()
	{
		return $this->builder;
	}

	/**
	 * Create a Select SQL Statement
	 *
	 * Usage: $obj->selectData(array("table"=>"table name", "columns"=>array("column1", "column2")))
	 * 		  If no columns are set the all (*) symbol will be used
	 * 
	 * @param  Array  $request
	 * 
	 * @return Void
	 */
	public function selectData(Array $request)
	{
		if(empty($request["table"])) {
			Exceptions::SQLnoTableError();
		}

		$this->buildType = "SELECT";

		$columnCount = 0;

		if(isset($request["columns"])) {
			$columnCount = count($request["columns"]);
		}

		$this->builder = "SELECT ";

		if($columnCount === 0) {
			$this->builder .= "* FROM " . $request["table"] . " ";
		} else {
			foreach($request["columns"] as $col) {
				if($this->counter === $columnCount) {
					$this->builder .= $col . " FROM " . $request["table"] . " ";
				} else {
					$this->builder .= $col . ", ";
				}

				$this->counter++;
			}
		}

		$this->counter = 1;
		return $this;
	}

	/**
	 * Create an Insert SQL Statement
	 *
	 * Usage: $obj->insertData(array("table"=>"table", "columns"=>array("column1", "column2"), "values"=>array("value1", "value2")));
	 * 
	 * @param  Array  $request
	 * 
	 * @return Void
	 */
	public function insertData(Array $request)
	{
		$this->request = $request;

		$this->counter = 1;

		if(empty($request["table"])) {
			Exceptions::SQLnoTableError();
		}

		if(count($request["columns"]) != count($request["values"])) {
			Exceptions::SQLvalueMismatch();
		}
		
		$this->buildType = "INSERT";

		$columnCount = count($request["columns"]);
		$valueCount = count($request["values"]);

		$this->builder .= "INSERT INTO " . $request["table"] . " (";

		foreach($request["columns"] as $col) {
			if($this->counter === $columnCount) {
				$this->builder .= $col;
			} else {
				$this->builder .= $col . ", ";
			}

			$this->counter++;
		}

		$this->counter = 1;

		$this->builder .= ") VALUES (";

		foreach($request["columns"] as $col) {
			if($this->counter === $valueCount) {
				$this->builder .= ":" . $col . ")";
			} else {
				$this->builder .= ":" . $col . ", ";
			}

			$this->counter++;
		}

		$this->counter = 1;
		return $this;
	}

	/**
	 * Create an Update SQL Statement
	 *
	 * Usuage: $obj->updateData(array("table"=>"table", "columns"=>array("column1", "column2"), "values"=>array("value1", "value2")));
	 * 
	 * @param  Array  $request
	 * 
	 * @return Void
	 */
	public function updateData(Array $request)
	{
		$this->request = $request;

		if(empty($request["table"])) {
			Exceptions::SQLnoTableError();
		}

		if(count($request["columns"]) != count($request["values"])) {
			Exceptions::SQLvalueMismatch();
		}

		$this->buildType = "UPDATE";

		$columnCount = count($request["columns"]);
		$valueCount = count($request["values"]);

		$this->builder = "UPDATE " . $request["table"] . " SET ";

		for($i=0; $i < $columnCount; $i++) {
			if($i === $columnCount - 1) {
				$this->builder .= $request["columns"][$i] . '=:' . $i . ' ';
			} else {
				$this->builder .= $request["columns"][$i] . '=:' . $i . ', ';
			}
		}

		return $this;
	}

	/**
	 * Create a Delete SQL Statement
	 *
	 * Usage: $obj->deleteData("table");
	 * 
	 * @param  String $table
	 * 
	 * @return Void
	 */
	public function deleteData($table) 
	{
		if(!$table) {
			Exceptions::SQLnoTableError();
		}

		$this->buildType = 'DELETE';
		
		$this->builder .= 'DELETE FROM ' . $table . ' ';

		return $this;
	}

	/**
	 * Append WHERE clause to SQL Statement
	 *
	 * Usage: $obj->where(array("column"=>"value", "column2"=>"value2"));
	 * 
	 * @param  Array  $param
	 * 
	 * @return Void
	 */
	public function where(Array $param)
	{
		if(empty($param)) {
			Exceptions::SQLmissingParams();
		}

		$requestCount = count($param);

		$this->builder .= 'WHERE ';

		$this->counter = 1;

		foreach($param as $key=>$value) {
			if($this->counter === $requestCount) {
				$this->builder .= $key . '="' . $value . '" ';
			} else {
				$this->builder .= $key . '="' . $value . '", ';
			}

			$this->counter++;
		}

		return $this;
	}

	/**
	 * Append LIMIT clause to SQL Statement
	 *
	 * Usage: $obj->limit(array(5)); OR $obj->limit(array(5,10));
	 * 
	 * @param  Array $values
	 * 
	 * @return Void
	 */
	public function limit(Array $values)
	{
		$valueCount = count($values);

		if($valueCount > 2) {
			Exceptions::SQLInvalidIntCount();
		}

		if(empty($values)) {
			Exceptions::SQLNoIntCount();
		}

		if($valueCount == 2) {
			$this->builder .= "LIMIT " . $values[0] . ', ' . $values[1];
		} else {
			$this->builder .= "LIMIT " . $values[0];
		}

		return $this;
	}

	/**
	 * Execute SQL Statement
	 * 
	 * @return Boolean OR Array
	 */
	public function execute()
	{
		try {
			$con = new \PDO("mysql:host=$this->server;dbname=$this->database", $this->globals->getUser(), $this->globals->getPwd());
			$prep = $con->prepare($this->builder);

			switch($this->buildType) {
				case "INSERT":
				case "UPDATE":
					for($i=0; $i <= count($this->request["values"]) - 1; $i++) {
						$prep->bindValue(":" . $this->request["columns"][$i], $this->request["values"][$i]);
					}
					$check = $prep->execute() or die(print_r($prep->errorInfo(), true));;
					$this->builder = "";
					$this->buildType = "";
					$this->counter = 0;
					if($check) {
						return true;
					} else {
						return false;
					}					
					break;
				case "DELETE":
					$prep->execute();
					$check = $prep->rowCount();
					$this->builder = "";
					$this->buildType = "";
					$this->counter = 0;
					if($check) {
						return true;
					} else {
						return false;
					}
					break;

				case "SELECT":
					$prep->execute();
					$data = $prep->fetchAll(\PDO::FETCH_ASSOC);
					$this->builder = "";
					$this->buildType = "";
					$this->counter = 0;
					return $data;
					break;
			}
		} catch (PDOException $ex) {
			Exceptions::SQLError($ex);
		}
	}
}