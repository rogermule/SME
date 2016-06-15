<?php
/**
 * Created by PhpStorm.
 * User: Natnael Zeleke
 * Date: 6/11/2016
 * Time: 3:18 PM
 */

class Product_Type{

	private $Name;
	private $Sector_Id;

	function __construct($Name, $Sector_Id){

		$this->Name = $Name;
		$this->Sector_Id = $Sector_Id;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->Name;
	}

	/**
	 * @param mixed $Name
	 */
	public function setName($Name)
	{
		$this->Name = $Name;
	}

	/**
	 * @return mixed
	 */
	public function getSectorId()
	{
		return $this->Sector_Id;
	}

	/**
	 * @param mixed $Sector_Id
	 */
	public function setSectorId($Sector_Id)
	{
		$this->Sector_Id = $Sector_Id;
	}



}