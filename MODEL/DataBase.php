<?php

class DataBase{
	private $last_id;
	private $db_host;
	private $db_user;
	private $db_password;
	private $db_name;
	private $dbc;

	/**
	 * constructor of the database class
	 * in the constructor the config ini will be parsed
	 */
	function __construct(){
		$config = parse_ini_file('config.ini',1);
		$this->db_host = $config['mysql_database']['db_server'];
		$this->db_user = $config['mysql_database']['db_user'];
		$this->db_password = $config['mysql_database']['db_password'];
		$this->db_name = $config['mysql_database']['db_name'];

	}


	/**
	 * @return mixed
	 * this will return the last inserted id
	 */
	function get_last_id(){
		$this->last_id = $this->dbc->insert_id;
		return $this->last_id;
	}


	/**
	 * @return mysqli connection to the caller
	 */
 	function connect(){
		$this->dbc = mysqli_connect($this->db_host,$this->db_user,$this->db_password,$this->db_name) or die("Could not connect to the database".mysql_error());
		return $this->dbc;
	}

	/**
	 * closes the connection
	 */
	function close(){
		mysqli_close($this->dbc);
	}



	/**
	 * @return mixed
	 */
	public function getDbName()
	{
		return $this->db_name;
	}



	/**
	 * @param mixed $db_name
	 */
	public function setDbName($db_name)
	{
		$this->db_name = $db_name;
	}



	/**
	 * @return mixed
	 */
	public function getDbHost()
	{
		return $this->db_host;
	}



	/**
	 * @param mixed $db_host
	 */
	public function setDbHost($db_host)
	{
		$this->db_host = $db_host;
	}



	/**
	 * @return mixed
	 */
	public function getDbPassword()
	{
		return $this->db_password;
	}



	/**
	 * @param mixed $db_password
	 */
	public function setDbPassword($db_password)
	{
		$this->db_password = $db_password;
	}



	/**
	 * @return mixed
	 */
	public function getDbUser()
	{
		return $this->db_user;
	}



	/**
	 * @param mixed $db_user
	 */
	public function setDbUser($db_user)
	{
		$this->db_user = $db_user;
	}



	/**
	 * @return mixed
	 */
	public function getDbc()
	{
		return $this->dbc;
	}



	/**
	 * @param mixed $dbc
	 */
	public function setDbc($dbc)
	{
		$this->dbc = $dbc;
	}


}