<?php


class User{

	private $User_ID;
	private $User_Name;
	private $User_Password;
	private $User_Type;
	private $user_profile;


	function __construct($user_name,$user_pass,$user_type = null,$user_id = null,UserProfile $user_profile=null){
		$this->User_Name = $user_name;
		$this->User_Password = $user_pass;

		//if the user id is not null set the user id to the user
		if(!$user_id == null){
			$this->User_ID = $user_id;
		}

 		//if the user type is not null set the user
		if(!$user_type == null){
			$this->User_Type = $user_type;
		}

		if(!$user_profile == null){
			$this->user_profile = $user_profile;
		}



	}

	/**
	 * @return mixed
	 */
	public function getUserID()
	{
		return $this->User_ID;
	}

	/**
	 * @param mixed $User_ID
	 */
	public function setUserID($User_ID)
	{
		$this->User_ID = $User_ID;
	}

	/**
	 * @return mixed
	 */
	public function getUserName()
	{
		return $this->User_Name;
	}

	/**
	 * @param mixed $User_Name
	 */
	public function setUserName($User_Name)
	{
		$this->User_Name = $User_Name;
	}

	/**
	 * @return mixed
	 */
	public function getUserPassword()
	{
		return $this->User_Password;
	}

	/**
	 * @param mixed $User_Password
	 */
	public function setUserPassword($User_Password)
	{
		$this->User_Password = $User_Password;
	}

	/**
	 * @return mixed
	 */
	public function getUserType()
	{
		return $this->User_Type;
	}

	/**
	 * @param mixed $User_Type
	 */
	public function setUserType($User_Type)
	{
		$this->User_Type = $User_Type;
	}

	/**
	 * @return UserProfile
	 */
	public function getUserProfile()
	{
		return $this->user_profile;
	}

	/**
	 * @param UserProfile $user_profile
	 */
	public function setUserProfile($user_profile)
	{
		$this->user_profile = $user_profile;
	}






} 