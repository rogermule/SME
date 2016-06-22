<?php


//TODO add product types
//todo edit product types
//todo add product2 types
//todo edit product2 types
//todo edit profile
//todo add bid
//todo delete bid



class Admin_Controller extends User_Controller{


	private $User_ID;
	private $User_Name;//will hold the name of the user
	private $User_Password;//will hold the password
	private $User_Phone;//will hold the user phone number
	private $User_Type;//will hold the use type


	/**
	 * @param $user_name
	 * @param $user_id
	 * @return bool
	 * checks the name of the admin for editing
	 */
	function Check_User_Name_For_Edit($user_name,$user_id){


		$query = "SELECT * FROM user where User_Name='$user_name' AND Id != '$user_id'";

		$result = mysqli_query($this->getDbc(),$query);

		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

		if(mysqli_num_rows($result) >= 1){

			return TRUE;
		}
		else if(mysqli_num_rows($result) < 1){
			return FALSE;
		}
	}

	/**
	 * @param User $admin
	 * @return bool
	 * edits the profile of the admin
	 */
	function Admin_Edit_Profile(User $admin){

		$this->User_Name = mysqli_real_escape_string($this->getDbc(),trim($admin->getUserName()));
		$this->User_Password = mysqli_real_escape_string($this->getDbc(),trim($admin->getUserPassword()));
		$this->User_ID = mysqli_real_escape_string($this->getDbc(),trim($admin->getUserID()));


		$query = "UPDATE user
			      SET User_Name='$this->User_Name',User_Password=sha1('$this->User_Password')
			      WHERE Id='$this->User_ID'";

		$result = mysqli_query($this->getDbc(),$query);



		$updated_admin = new User($this->User_Name,$this->User_Password);
		$updated_admin->setUserID($this->User_ID);
		$updated_admin->setUserType(User_Type::ADMIN);

		/**
		 * update the logged in user
		 * and return true
		 */


		session_start();
		$_SESSION["Logged_In_User"] = $updated_admin;
		return TRUE;


	}

	/**
	 * @param Sector $sector
	 * @return bool
	 * add sector to the database
	 */
	function Add_Sector(Sector $sector){
		$sector_name = $sector->getName();
		$query = "INSERT INTO sector (Name) VALUES ('$sector_name')";
		$result = mysqli_query($this->getDbc(),$query);
		if($result){
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	/**
	 * @param Sector $sector
	 * @return bool
	 * checks if the sector exists in the data base
	 */
	function Sector_Exists(Sector $sector){


		$sector_name = $sector->getName();
		$query = "SELECT * FROM sector where Name = '$sector_name'";
		$result = mysqli_query($this->getDbc(),$query);
		if(mysqli_num_rows($result) >= 1){
			return TRUE;
		}
		else if(mysqli_num_rows($result) == 0){
			return FALSE;
		}

	}

	/**
	 * @param Product_Type $product_Type
	 * @return bool
	 * adds a product type to the database
	 */
	function Add_Product_Type(Product_Type $product_Type){
		$product_name = $product_Type->getName();
		$sector_Id = $product_Type->getSectorId();
		$query = "INSERT INTO Product_Type (Name,Sector) VALUES ('$product_name','$sector_Id')";
		$result = mysqli_query($this->getDbc(),$query);
		if($result){
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	/**
	 * @param Product_Type $product_Type
	 * @return bool
	 * this functions returns if the product type exists
	 */
	function Product_Type_Exists(Product_Type $product_Type){

		$product_name =  $product_Type->getName();
		$query = "SELECT * FROM Product_Type WHERE Name='$product_name'";
		$result = mysqli_query($this->getDbc(),$query);
		if(mysqli_num_rows($result) >= 1){
			return TRUE;
		}
		else if(mysqli_num_rows($result) == 0){
			return FALSE;
		}


	}

	/**
	 * @param $Sector_ID
	 * @return bool
	 * this will delete the sector by starting a transaction
	 * if the transaction fails it will rollback
	 */
	function Delete_Sector($Sector_ID){

		//start the transaction
		$query0 = "START TRANSACTION";
		$result0 = mysqli_query($this->getDbc(),$query0);

		//delete the sector
		$query = "DELETE FROM sector WHERE Id = '$Sector_ID'";
		$result1 = mysqli_query($this->getDbc(),$query);
		if($result0 AND $result1){
			$query2 = "COMMIT";
			mysqli_query($this->getDbc(),$query2);
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
	 * @param $Product_Type_ID
	 * @return bool
	 * this will delete the product type from the database
	 */
	function Delete_Product_Type($Product_Type_ID){
		//start the transaction
		$query0 = "START TRANSACTION";
		$result0 = mysqli_query($this->getDbc(),$query0);

		//delete the sector
		$query = "DELETE FROM product_type WHERE Id = '$Product_Type_ID'";
		$result1 = mysqli_query($this->getDbc(),$query);
		if($result0 AND $result1){
			$query2 = "COMMIT";
			mysqli_query($this->getDbc(),$query2);
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
	 * @param Bid $bid
	 * @return bool
	 * adds bid to the database
	 */
	function Add_Bid(Bid $bid){
		$bid_name = $bid->getName();
		$bid_description = $bid->getDescription();
		$bid_picture = $bid->getPicture();

		$query = "INSERT INTO bid (Name,Description,Status,Opened_On,Picture) VALUES ('$bid_name','$bid_description','0',now(),'$bid_picture')";
		$result = mysqli_query($this->getDbc(),$query);
		if($result){
			return true;
		}
		else{
			return false;
		}
	}

	/**
	 * @param $bid_Id
	 * @return bool
	 * deletes the bid from the database
	 */
	function Delete_Bid($bid_Id){

		//start the transaction
		$query0 = "START TRANSACTION";
		$result0 = mysqli_query($this->getDbc(),$query0);

		//delete the sector
		$query = "DELETE FROM bid WHERE Id = '$bid_Id'";
		$result1 = mysqli_query($this->getDbc(),$query);
		if($result0 AND $result1){
			$query2 = "COMMIT";
			mysqli_query($this->getDbc(),$query2);
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
	 * @param Bid $bid
	 * @return bool
	 * checks if the bid exists in here
	 */
	function Bid_Exists(Bid $bid){

		$bid_Name = $bid->getName();
		$query = "SELECT * FROM bid where Name ='$bid_Name'";
		$result = mysqli_query($this->getDbc(),$query);
		if(mysqli_num_rows($result) >= 1){
			return true;
		}
		else if(mysqli_num_rows($result) == 1){
			return false;
		}

	}

	/**
	 * @param $User_ID
	 * @return bool
	 * This will delete the user profile first and after that it will delete the user from the user table
	 */
	function Delete_User($User_ID){

		//start the transaction
		$query0 = "START TRANSACTION";
		$result0 = mysqli_query($this->getDbc(),$query0);

		//delete the user profile
		$query1 = "DELETE FROM user_profile WHERE Id = '$User_ID'";
		$result1 = mysqli_query($this->getDbc(),$query1);

		//delete user bid
		$query2 =  "SELECT * FROM user_bid WHERE User_Id = '$User_ID'";
		$result2 = mysqli_query($this->getDbc(),$query2);
		if($result2){
			while($UB = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
				$User_Bid_Id = $UB['Id'];
				$IQuery = "Delete from user_bid where Id = '$User_Bid_Id'";
				$IResult = mysqli_query($this->getDbc(),$IQuery);
			}
		}

		//delete user notification
		$query3 = "SELECT * FROM user_notification WHERE User_Id = '$User_ID'";
		$result3 = mysqli_query($this->getDbc(),$query3);
		if($result3){
			while($UN = mysqli_fetch_array($result3,MYSQLI_ASSOC)){
				$User_Notification_Id = $UN['Id'];
				$IQuery = "Delete from user_notification where Id = '$User_Notification_Id'";
				$IResult = mysqli_query($this->getDbc(),$IQuery);
			}
		}

		//delete user order
		$query4 = "SELECT * FROM user_order WHERE Orderer_Id = '$User_ID'";
		$result4 = mysqli_query($this->getDbc(),$query4);
		if($result4){
			while($UO = mysqli_fetch_array($result4,MYSQLI_ASSOC)){
				$Order_Id = $UO['Order_Id'];
				$IQuery = "Delete from user_order where Order_Id = '$Order_Id'";
				$IResult = mysqli_query($this->getDbc(),$IQuery);
			}
		}

		//delete user product
		$query5 = "SELECT * FROM user_product WHERE User_Id = '$User_ID'";
		$result5 = mysqli_query($this->getDbc(),$query5);
		if($result5){
			while($UPR = mysqli_fetch_array($result5,MYSQLI_ASSOC)){
				$Id = $UPR['Id'];
				$IQuery = "Delete from user_product where Id = '$Id'";
				$IResult = mysqli_query($this->getDbc(),$IQuery);
			}
		}


		//delete the user
		$query6 = "DELETE FROM user where Id = '$User_ID'";
		$result6 = mysqli_query($this->getDbc(),$query6);


		if($result0 AND $result1 AND $result2 AND $result3 AND $result4 AND $result5 AND $result6){
			$query7 = "COMMIT";
			mysqli_query($this->getDbc(),$query7);
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
	 * @param $Bid_Id
	 * @return bool|mysqli_result
	 * get users participating on a bid
	 */
	function Get_Bid_Participating_Users($Bid_Id){
		$query = "select
			    UB.Id as User_Id,
				UB.Bid_Amount as Amount,
				U.User_Name as User_Name
			from
			    user_bid as UB
			        inner join
			    user as U ON UB.User_Id = U.Id
				where Bid_Id = '$Bid_Id'";

		$result = mysqli_query($this->getDbc(),$query);

		if($result){
			return $result;
		}return false;
	}


	/**
	 * @param $Bid_Id
	 * @return bool
	 * this function will close the deal and notify the appropritate use
	 */
	function Close_Bid($Bid_Id){


		//start the transaction
		$query0 = "START TRANSACTION";
		$result0 = mysqli_query($this->getDbc(),$query0);


		//set the bid status to 1 and update the closing day

		$query1 = "UPDATE bid set Status = 1,Closed_On = now() where Id =  '$Bid_Id'";
		$result1 = mysqli_query($this->getDbc(),$query1);

		//get the user with the lowest amount
		$query2 = "select
				    B.Id as Bid_Id,
					B.Name as Bid_Name,
					U.Id as User_Id
				from
				    bid as B
				        inner join
				    user_bid as UB ON B.Id = UB.Bid_Id
						inner join
					user as U on U.Id = UB.User_Id
					where B.Id = '$Bid_Id'
					order by UB.Bid_Amount ASC
					limit 1";

		$result2 = mysqli_query($this->getDbc(),$query2);

		$result2Arry = mysqli_fetch_array($result2,MYSQLI_ASSOC);
		$winner_Id = $result2Arry['User_Id'];
		$Bid_Name = $result2Arry['Bid_Name'];
		$Bid_Id = $result2Arry["Bid_Id"];
		$Action = "You Have Won the ".$Bid_Name." Bid";


		$updateQuery = "UPDATE bid SET Winner = '$winner_Id' WHERE Id='$Bid_Id'";
		mysqli_query($this->getDbc(),$updateQuery);

		$notification = new Notification($Action,$winner_Id);

		//insert into the database
		$query3 = "INSERT INTO notification (Action,Time) values ('$Action',now());";
		$result3 = mysqli_query($this->getDbc(),$query3);
		$Notification_ID = $this->getDb()->get_last_id();
		$query4 = "INSERT INTO user_notification (User_Id,Notification_Id,Status) VALUES ('$winner_Id','$Notification_ID','0')";
		$result4 = mysqli_query($this->getDbc(),$query4);


		if($result0 AND $result1 AND $result2 AND $result3 AND $result4){
			$query_last = "COMMIT";
			mysqli_query($this->getDbc(),$query_last);
			return TRUE;
		}

		else{
			$query_roll = "ROLLBACK";
			mysqli_query($this->getDbc(),$query_roll);
			echo("Rolled back");
			return FALSE;
		}


	}



}