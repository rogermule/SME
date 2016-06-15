<?php
/**
 * Created by PhpStorm.
 * User: Natnael Zeleke
 * Date: 6/12/2016
 * Time: 6:44 AM
 */

class UserProfile{

	private $Address;
	private $Phone_Number;
	private $Email;
	private $Account_Type;

	function __construct($Address,$Phone_Number,$Email){
		$this->Address = $Address;
		$this->Phone_Number = $Phone_Number;
		$this->Email = $Email;

	}

	/**
	 * @return mixed
	 */
	public function getAddress()
	{
		return $this->Address;
	}

	/**
	 * @param mixed $Address
	 */
	public function setAddress($Address)
	{
		$this->Address = $Address;
	}

	/**
	 * @return mixed
	 */
	public function getPhoneNumber()
	{
		return $this->Phone_Number;
	}

	/**
	 * @param mixed $Phone_Number
	 */
	public function setPhoneNumber($Phone_Number)
	{
		$this->Phone_Number = $Phone_Number;
	}

	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->Email;
	}

	/**
	 * @param mixed $Email
	 */
	public function setEmail($Email)
	{
		$this->Email = $Email;
	}




}













