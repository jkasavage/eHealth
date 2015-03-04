<?php

namespace CSF\Modules;

/**
 * Configuration File - Club Systems Framework
 * Ensure all variables are set to match session variables
 * (ie. private ident = $_SESSION["YOURVARIABLE"])
 *
 * Copyright Club Systems 2015
 * @author Joseph Kasavage
 */

class Config
{
	/**
	 * Customer Identity
	 * 
	 * @var String
	 */
	private $ident;

	/**
	 * Customer Site
	 * 
	 * @var Integer
	 */
	private $site;

	/**
	 * User
	 *
	 * @var String
	 */
	private $user = "";

	/**
	 * Password
	 *
	 * @var String
	 */
	private $pwd = "";

	########################################
	# DO NOT MODIFY BELOW
	########################################

	/**
	 * Construct
	 */
	public function __construct()
	{
		if(isset($_COOKIE["csysident"]) && isset($_COOKIE["csyssite"])) {
			$this->ident = $_COOKIE["csysident"];
			$this->site = $_COOKIE["csyssite"];
		}
	}

	/**
	 * Identity Getter
	 * 
	 * @return Strin
	 */
	public function getIdent() 
	{
		return $this->ident;
	}

	/**
	 * Site Getter
	 * 
	 * @return Integer
	 */
	public function getSite()
	{
		return $this->site;
	}

	/**
	 * User Getter
	 * 
	 * @return String
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * Pwd Getter
	 * 
	 * @return String
	 */
	public function getPwd()
	{
		return $this->pwd;
	}

	/**
	 * Get Server
	 * 
	 * @return String
	 */
	public function getServer()
	{
		if(isset($_SERVER["HTTP_HOST"])) {
			$host = explode(".", $_SERVER["HTTP_HOST"]);

			if($host[0] == "v2kpro") {
				return '172.16.238.23';
			} else if ($host[0] == "healthclubsystems") {
				$uri = explode("/", $_SERVER["REQUEST_URI"]);

				if($uri[0] == "member_new" && $uri[1] == "nutrition") {
					return "localhost";
				} else {
					return $_COOKIE["csysserver"];
				}
			} else {
				return 'localhost';
			}
		}
	}
}