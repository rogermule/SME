<?php
class Bid{

	private $name;
	private $description;
	private $picture;

	function __construct($name,$description,$picture){
		$this->name = $name;
		$this->description = $description;
		$this->picture = $picture;
	}

	/**
	 * @return mixed
	 */
	public function getPicture()
	{
		return $this->picture;
	}

	/**
	 * @param mixed $picture
	 */
	public function setPicture($picture)
	{
		$this->picture = $picture;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param mixed $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}


}