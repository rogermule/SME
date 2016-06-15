<?php
require("../CONFIGURATION/Config.php");//this file contains configurations files
require("database.php");
require("../MODEL/User.php");//user object will be created so it should be included in here
require("User_Controller.php");//admin controller is going to extend this class so it should be included
require("SME_Controller.php");
require("Controller_Secure_Access.php");//this will prevent this file from being accessed easily
require("../MODEL/User_Type.php");
require("../MODEL/Error_Type.php");
$errors = array();

function admin_redirect_success(){
	$dir = "VIEW/html/SME/Manage_Products.php?success_delete=1";
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

	$Bid_Id = $_POST['Bid_Id'];
	$User_Product_Id = $_POST['User_Product_Id'];
	$Product_Id = $_POST['Product_ID'];
	$error_type = "";
	if($type_of_error == Error_Type::FORM){
		$error_type = "Fill out the form  correctly.";
	}
	else if($type_of_error == Error_Type::DATA_BASE){
		$error_type = "You cant delete the bid! The Bid is referenced by your ";
	}
	else if($type_of_error == Error_Type::SAME_BID_NAME){
		$error_type = "Error! You can Not add same sector name!";
	}
	$dir = "VIEW/html/SME/Delete_Product.php?error=$error_type&User_Product_Id=$Bid_Id&Product_Id=$Product_Id";
	$url = BASE_URL.$dir;
	header("Location:$url");
	exit();
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
	if(TRUE == check_login_status()){
		$user_type = get_user_type();
		if($user_type == User_Type::SME){

			$user = $_SESSION['Logged_In_User'];
			$SME_Con = new SME_Controller($user);


			if(empty($_POST['User_Product_Id'])){
				$errors[] = "You have to refresh the website!";
			}
			else{
				$User_Product_Id = $_POST['User_Product_Id'];
			}

			if(empty($errors)){
				if($SME_Con->Delete_User_Product($User_Product_Id)){
					admin_redirect_success();
				}
				else{
					admin_place_redirect(Error_Type::DATA_BASE);
				}
			}
			else{
				admin_place_redirect(Error_Type::FORM);
			}
		}
	}
}
