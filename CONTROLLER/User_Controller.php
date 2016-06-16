<?php

//the user is a class that other classes are goign to extend
//because the user contains common actions that admin, encoder and also phone receptionist have
//which is login and logout
//variable that will hold the user on the session is $_SESSION[Logged_In_User]



class User_Controller{

	protected $user;
	protected $db;
	protected $dbc;
	function __construct(User $user){
		$this->user = $user;
		$this->db = new DataBase();
		$this->dbc = $this->db->connect();
	}


	function login(){

		$user_name = $this->user->getUserName();
		$user_password = $this->user->getUserPassword();
		$query = "SELECT * from user where User_Name= '$user_name' AND User_Password = sha1('$user_password')";
		$result = mysqli_query($this->dbc,$query);

		if(mysqli_num_rows($result) == 1){
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$this->user->setUserID($row['Id']);

			$this->user->setUserType($row['User_Type']);

			//start session and put the user on the session
			session_start();
			$_SESSION["Logged_In_User"] = $this->user;
			return true;
		}
		else{
			//if the user cant login with his credentials
			return false;
		}


	}//end of login function

	function logout(){
		$_SESSION = array();//clear the session array

		if(session_destroy()){
			//this will close th connection of the database
			//and also returns true after closing the database connection
			//which is good programming, even if the database is going to close after the script ends
			setcookie ('PHPSESSID', '', time( )-3600, '/', '', 0, 0); // Destroy the cookie.
			$this->dbc->close();
			return true;

		}else{
			return false;
		}
	}

	/**
	 * @return DataBase
	 */
	public function getDb()
	{
		return $this->db;
	}

	/**
	 * @param DataBase $db
	 */
	public function setDb($db)
	{
		$this->db = $db;
	}

	/**
	 * @return mysqli
	 */
	public function getDbc()
	{
		return $this->dbc;
	}

	/**
	 * @param mysqli $dbc
	 */
	public function setDbc($dbc)
	{
		$this->dbc = $dbc;
	}

	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * @param User $user
	 */
	public function setUser($user)
	{
		$this->user = $user;
	}

	/**
	 * @return bool|mysqli_result
	 * common function used to get the sectors from the database
	 */
	public function getAllSectors(){

		$query = "select * from sector";
		$result = mysqli_query($this->getDbc(),$query);
		if($result){
			return $result;
		}
		else {
			return false;
		}
	}

	/**
	 * @return bool|mysqli_result
	 * this will fetch the products merged with the
	 */
	public function getAllProductAndSectors(){
		$query = "select
				    PR.Id as Id,
				    PR.Name as Name,
				    PR.Sector as Sector_Id,
				    S.name as Sector_Name
				from
				    product_type as PR
				        inner join
				    sector as S ON PR.sector = S.ID";

		$result = mysqli_query($this->getDbc(),$query);

		if($result){
			return $result;
		}
		else {
			return false;
		}
	}

	/**
	 * @param $Sector_ID
	 * @return bool|mysqli_result
	 * get a single sector from the data base
	 */
	function getSingleSector($Sector_ID){
		$query = "SELECT * from sector where Id='$Sector_ID'";
		$result = mysqli_query($this->getDbc(),$query);

		if($result){
			return $result;
		}
		else return false;
	}

	/**
	 * @param $Product_Type_Id
	 * @return bool|mysqli_result
	 * returns a single product type from the database
	 */
	function getSingleProductType($Product_Type_Id){
		$query = "SELECT * FROM product_type where Id = '$Product_Type_Id'";
		$result = mysqli_query($this->getDbc(),$query);

		if($result){
			return $result;
		}
		else return false;
	}

	/**
	 * @param $Bid_Id
	 * @return bool|mysqli_result
	 * gets a single bid data from the database
	 */
	function getSingleBid($Bid_Id){
		$query  = "SELECT * from bid where Id='$Bid_Id'";
		$result = mysqli_query($this->getDbc(),$query);
		if($result){
			return $result;
		}
		else return false;
	}

	/**
	 * @return bool|mysqli_result
	 * this function gets all bids from the result
	 */
	function getAllBids(){

		$query = "SELECT * FROM bid";
		$result = mysqli_query($this->getDbc(),$query);

		if($result){
			return $result;
		}
		else {
			return false;
		}

	}

	/**
	 * @param $UserName
	 * @return bool
	 * check if the username exists for a signup
	 */
	function checkUserNameForSignUp($UserName){
		$query = "SELECT * FROM user where User_Name='$UserName'";
		$result = mysqli_query($this->getDbc(),$query);
		if(mysqli_num_rows($result)){
			return true;
		}
		else return false;
	}

	/**
	 * @param User $newUser
	 * @return bool
	 * this function will accept a new user object with the out the ID set
	 * if the user is added to the database with out a problem the new ID of the user is going to be set for the
	 * user object
	 */
	function registerUser(User $newUser){

		$UserName = $newUser->getUserName();
		$UserPassword = $newUser->getUserPassword();
		$UserType =$newUser->getUserType();
		$Address = $newUser->getUserProfile()->getAddress();
		$PhoneNumber = $newUser->getUserProfile()->getPhoneNumber();
		$Email = $newUser->getUserProfile()->getEmail();


		//start the transaction
		$query0 = "START TRANSACTION";
		$result0 = mysqli_query($this->getDbc(),$query0);

		$query1 = "INSERT INTO user (User_Name,User_Password,User_Type) VALUES('$UserName',sha1('$UserPassword'),'$UserType')";
		$result1 = mysqli_query($this->getDbc(),$query1);

		$Registered_User_ID = $this->getDb()->get_last_id();

		$query2 = "INSERT INTO user_profile (ID,Address,Phone_Number,Email) VALUES('$Registered_User_ID','$Address','$PhoneNumber','$Email')";
		$result2 = mysqli_query($this->getDbc(),$query2);


		if($result0 AND $result1 AND $result2){
			$query3 = "COMMIT";
			mysqli_query($this->getDbc(),$query3);
			//set the ID for the user
			$newUser->setUserID($Registered_User_ID);
			return TRUE;
		}

		else{
			$query_roll = "ROLLBACK";
			mysqli_query($this->getDbc(),$query_roll);
			return FALSE;
		}






	}

	/**
	 * @param User_Type $user_Type
	 * @return bool|mysqli_result
	 * get the users that are registered in the database
	 */
	function getAllUsers($user_Type){

		$query = "";
		if($user_Type == User_Type::SME){
			$query = "SELECT * from user where User_Type = 'SME'";
		}
		else if($user_Type == User_Type::IU){
			$query = "SELECT * FROM user where User_Type = 'IU'";
		}
		$result = mysqli_query($this->getDbc(),$query);

		if($result){
			return $result;
		}
		else return false;

	}

	/**
	 * @param $User_ID
	 * @return bool|mysqli_result
	 * this function will
	 */
	function getUserProfile($User_ID){
		$query = "select
				    U.ID as Id,
				    U.User_Type as User_Type,
					U.User_Name as User_Name,
					U.User_Password as User_Password,
					UP.Address as Address,
					UP.Phone_Number as Phone_Number,
					UP.Email as Email
				from
				    user as U
				        inner join
				    user_profile as UP ON U.ID = UP.ID
				where
				    U.ID = '$User_ID'";

		$result = mysqli_query($this->getDbc(),$query);

		if($result){
			return $result;
		}
		else return false;
	}

	/**
	 * @param User $user
	 * @return bool
	 * this function if for the IU and SME
	 * It will update the profile of the users
	 */
	function User_Edit_Profile(User $user){

		$User_Id = $user->getUserID();
		$User_Name = $user->getUserName();
		$User_Password = $user->getUserPassword();
		$Address =  $user->getUserProfile()->getAddress();
		$Phone_Number = $user->getUserProfile()->getPhoneNumber();
		$Email = $user->getUserProfile()->getEmail();
		//start the transaction
		$query0 = "START TRANSACTION";
		$result0 = mysqli_query($this->getDbc(),$query0);


		//Edit the profile table
		$query1 = "UPDATE user_profile set Address='$Address',Phone_Number='$Phone_Number',Email='$Email' where Id='$User_Id'";
		$result1 = mysqli_query($this->getDbc(),$query1);


		//Edit the user table
		$query2 = "UPDATE user set User_Name='$User_Name',User_Password=sha1('$User_Password') WHERE Id='$User_Id'";
		$result2 = mysqli_query($this->getDbc(),$query2);


		if($result0 AND $result1 AND $result2){
			$query3 = "COMMIT";
			mysqli_query($this->getDbc(),$query3);
			return TRUE;
		}
		else{
			$query_roll = "ROLLBACK";
			mysqli_query($this->getDbc(),$query_roll);
			echo("Rolled back");
			return FALSE;
		}


	}


	/**
	 * @param $user_name
	 * @param $user_Id
	 * @return bool
	 * checks if the user can use this name for edit
	 */
	function User_Name_Exists_For_Edit($user_name,$user_Id){

		$query = "SELECT * from user where User_Name = '$user_name' and Id !='$user_Id'";
		$result = mysqli_query($this->getDbc(),$query);
		if(mysqli_fetch_array($result) >= 1){
			return true;
		}
		else if(mysqli_fetch_array($result) == 0){
			return false;
		}
		return true;
	}


	/**
	 * @param $SME_ID
	 * @return bool|mysqli_result
	 * this will get the products of the user
	 */
	function Get_SME_Products($SME_ID){
		$query = "select
				    U.Id as User_Id,
					U.User_Name as User_Name,
					P.Id as Product_Id,
					P.Name as Product_Name,
					S.Name as Sector_Name,
					UP.Id as User_Product_Id,
					UP.Name as Name,
					UP.Price as Price
				from
				    user as U
				        inner join
				    user_product as UP ON U.Id = UP.User_Id
						inner join
					product_type as P on UP.Product_Id = P.Id
						inner join
					sector as S on S.Id = P.Sector
					where User_Id = '$SME_ID'";
		$result = mysqli_query($this->getDbc(),$query);
		if($result ){
			return $result;
		}
		return false;
	}


	/**
	 * @return bool|mysqli_result
	 * this function will get the all the products
	 */
	function Get_All_Products(){
		$query = "SELECT * FROM product_type";
		$result = mysqli_query($this->getDbc(),$query);
		if($result){
			return $result;
		}
		return false;
	}


	/**
	 * @param Notification $notification
	 * @return bool
	 * this function is will add notification
	 */
	function Add_Notification(Notification $notification){
	 $Action = $notification->getAction();
	 $Belongs_To = $notification->getBelongsTo();
	 //start the transaction
	 $query0 = "START TRANSACTION";
	 $result0 = mysqli_query($this->getDbc(),$query0);

	 //insert into the database
	 $query1 = "INSERT INTO notification (Action,Time) values ('$Action',now());";
	 $result1 = mysqli_query($this->getDbc(),$query1);
	 $Notification_ID = $this->getDb()->get_last_id();
	 $query2 = "INSERT INTO user_notification (User_Id,Notification_Id,Status) VALUES ('$Belongs_To','$Notification_ID','0')";
	 $result2 = mysqli_query($this->getDbc(),$query2);

	 if($result0 AND $result1 AND $result2){
		 $query3 = "COMMIT";
		 mysqli_query($this->getDbc(),$query3);
		 return TRUE;
	 }
	 else{
		 $query_roll = "ROLLBACK";
		 mysqli_query($this->getDbc(),$query_roll);
		 return FALSE;
	 }


	}

	/**
	 * @param $user_Id
	 * @return bool|mysqli_result
	 * this will fetch the notifications from the database
	 */
	function GetNotifications($user_Id){
		$query = "select
				    N.Action as Action,
					N.Time as Time,
					UN.Status as Status
				from
				    notification as N
				        inner join
				    user_notification as UN ON N.Id = UN.Notification_Id
				where
				    UN.User_Id = '$user_Id' order by N.Time DESC";

		$result = mysqli_query($this->getDbc(),$query);

		if($result){
			return $result;
		}
		return false;

	}

	/**
	 * @param $User_Id
	 * @return bool
	 * set the notification of the specific user as read
	 */
	function Set_Notification_Read($User_Id){

		$query = "update user_notification set Status = 1 where User_Id = '$User_Id'";
		$result = mysqli_query($this->getDbc(),$query);

		if($result){
			return TRUE;
		}
		return FALSE;
	}


	/**
	 * @return bool|mysqli_result
	 * this function returns all bids that are closed
	 */
	function GetAllClosedBids(){
		$query = "SELECT * FROM bid where Status = 1";
		$result = mysqli_query($this->getDbc(),$query);

		if($result){
			return $result;
		}
		return false;
	}

	/**
	 * @return bool|mysqli_result
	 * this function will selected bids that are open
	 */
	function GetAllOpenedBids(){
		$query = "SELECT * FROM bid where Status = 0 order by Opened_On DESC";
		$result = mysqli_query($this->getDbc(),$query);

		if($result){
			return $result;
		}
		return false;
	}


	function GetUserName($Winner){
		$query = "SELECT User_Name FROM user WHERE Id='$Winner'";
		$result = mysqli_query($this->getDbc(),$query);

		if($result){
			$results = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$name = $results['User_Name'];

			return $name;
		}
		return false;
	}

}
















