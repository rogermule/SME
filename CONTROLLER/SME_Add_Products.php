<?php
require("../CONFIGURATION/Config.php");//this file contains configurations files
require("database.php");
require('../MODEL/User_Profile.php');
require("../MODEL/User.php");//user object will be created so it should be included in here
require("User_Controller.php");//admin controller is going to extend this class so it should be included
require("SME_Controller.php");
require("Controller_Secure_Access.php");//this will prevent this file from being accessed easily
require("../MODEL/User_Type.php");
require("../MODEL/Error_Type.php");

$errors = array();

/**
 * this will redirect the if the operation is successful
 */
function admin_redirect_success(){

	$dir = "VIEW/html/SME/Manage_Products.php?success=1";
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
	else if($type_of_error == Error_Type::SAME_PRODUCT_TYPE_NAME){
		$error_type = "Error! You can Not add same product to your list name!";
	}
	$dir = "VIEW/html/SME/Manage_Products.php?error=$error_type";
	$url = BASE_URL.$dir;
	header("Location:$url");
	exit();

}


if($_SERVER['REQUEST_METHOD'] == "POST"){

	if(TRUE == check_login_status()){

		$user = $_SESSION['Logged_In_User'];
		$User_Id = $user->getUserID();

		$user_type = get_user_type();
		$SME_Con = new SME_Controller($user);

		if($user_type == User_Type::SME){

			$User = $_SESSION['Logged_In_User'];

			$admin_con = new SME_Controller($User);


			if(empty($_POST['Product_Id'])){
				$errors[] = "Product id should be filled";
			}
			else{
				$Product_Id = $_POST['Product_Id'];
			}


			if(empty($errors)){
				if(!$SME_Con->Check_Product_Exists($User_Id,$Product_Id)){
					if($SME_Con->Add_Product_Type_To_List($User_Id,$Product_Id)){
						admin_redirect_success();
					}
					else{
						admin_place_redirect(Error_Type::DATA_BASE);
					}
				}
				else{
					admin_place_redirect(Error_Type::SAME_PRODUCT_TYPE_NAME);
				}
			}
			else{
				admin_place_redirect(Error_Type::FORM);
			}

		}
	}

}