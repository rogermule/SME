<?php
require("../CONFIGURATION/Config.php");//this file contains configurations files
require("database.php");
require("../MODEL/User.php");//user object will be created so it should be included in here
require("User_Controller.php");//admin controller is going to extend this class so it should be included
require("Admin_Controller.php");
require("Controller_Secure_Access.php");//this will prevent this file from being accessed easily
require("../MODEL/User_Type.php");
require("../MODEL/Error_Type.php");
require("../MODEL/Bid.php");
$errors = array();

/**
 * this will redirect the if the operation is successful
 */
function admin_redirect_success(){

	$dir = "VIEW/html/Admin/Bid_Manager.php?success=1";
	$url = BASE_URL.$dir;
	header("Location:$url");//redirect the admin to the Admin_Add_Users.php file
	exit();
}

/**
 * @param $type_of_error
 * this function takes an error type
 * and redirect the encoder to the add regions place
 */
function admin_place_redirect($type_of_error){

	$error_type = "";
	if($type_of_error == Error_Type::FORM){
		$error_type = "Fill out the form  correctly.";
	}
	else if($type_of_error == Error_Type::DATA_BASE){
		$error_type = "Error when adding new user.";
	}
	else if($type_of_error == Error_Type::SAME_BID_NAME){
		$error_type = "Error! You can Not add same sector name!";
	}
	$dir = "VIEW/html/Admin/Bid_Manager.php?error=$error_type";
	$url = BASE_URL.$dir;
	header("Location:$url");
	exit();
}


if($_SERVER['REQUEST_METHOD'] == "POST"){

	if(TRUE == check_login_status()){


		$user_type = get_user_type();

		if($user_type == User_Type::ADMIN){

			$admin = $_SESSION['Logged_In_User'];

			$admin_con = new Admin_Controller($admin);


			if(empty($_POST['Bid_Name'])){
				$errors[] = "Bid Name Should be filled";
			}
			else{
				$Bid_Name = $_POST['Bid_Name'];

			}

			/**
			 * get the description of the bid
			 */
			if(empty($_POST['Description'])){
				$errors[] = "Bid Description should be filled";
			}
			else{
				$Description = $_POST['Description'];
			}

			if(empty($errors)){
				$Bid = new Bid($Bid_Name,$Description);
				if($admin_con->Bid_Exists($Bid)){
					admin_place_redirect(Error_Type::SAME_BID_NAME);
				}
				$added = $admin_con->Add_Bid($Bid);
				if($added){
					admin_redirect_success();
				}
				else{
					admin_place_redirect(Error_Type::DATA_BASE);
				}

			}
			/**
			 * if there are errors when filling the form
			 */
			else{
				admin_place_redirect(Error_Type::FORM);
			}

		}
	}

}


