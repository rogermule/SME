<?php

require("../CONFIGURATION/Config.php");//this file contains configurations files
require("database.php");
require("../MODEL/User_Profile.php");
require("../MODEL/User.php");//user object will be created so it should be included in here
require("User_Controller.php");//admin controller is going to extend this class so it should be included
require("IU_Controller.php");
require("SME_Controller.php");
require("Controller_Secure_Access.php");//this will prevent this file from being accessed easily
require("../MODEL/User_Type.php");
require("../MODEL/Error_Type.php");
$errors = array();

/**
 * @param $user_Type
 *
 */
function admin_redirect_success($user_Type){
	$dir="";
	if($user_Type == User_Type::SME){
		$dir = "VIEW/html/SME/index.php?success_edit=1";
	}
	else if($user_Type == User_Type::IU){
		$dir = "VIEW/html/IU/index.php?success_edit=1";
	}
	$url = BASE_URL.$dir;
	header("Location:$url");//redirect the admin to the Admin_Add_Users.php file
	exit();
}

function admin_redirect_error($type_of_error,$user_type){


	$error_type = "";

	if($type_of_error == Error_Type::FORM){
		$error_type = "Fill out the form  correctly.";
	}
	if($type_of_error == Error_Type::PASSWORD_DONT_MATCH){
		$error_type = "Password Doesn't match.";
	}


	else if($type_of_error == Error_Type::DATA_BASE){
		$error_type = "Error when adding new user.";
	}
	else if($type_of_error == Error_Type::SAME_USER_NAME){
		$error_type = "Error, Use a different name. User name exists before.";
	}


	$dir = "";

	if($user_type == User_Type::SME){
		$dir = "VIEW/html/SME/SME_Edit_Profile.php?error=$error_type";
	}
	else if($user_type == User_Type::IU){
		$dir = "VIEW/html/IU/IU_Edit_Profile.php?error=$error_type";
	}
	$url = BASE_URL.$dir;
	header("Location:$url");//redirect the admin to the Edit_Admin.php
	exit();



}




if($_SERVER['REQUEST_METHOD'] == "POST"){


	if(TRUE == check_login_status()){



		$user = $_SESSION['Logged_In_User'];

		//user type
		if(empty($_POST['User_Type'])){
			$errors[] = "user types should be filled please refresh the site";
		}
		else{
			$User_Type = $_POST['User_Type'];

		}


		//instantiate the controller for the website
		if($User_Type == User_Type::SME){
			$controller = new SME_Controller($user);
		}
		else if($User_Type == User_Type::IU){
			$controller = new IU_Controller($user);
		}
		else{
			admin_redirect_error(Error_Type::FORM,User_Type::IU);
		}




		//user name
		if(empty($_POST['User_Name'])){
			$errors[] = "User Name Should be filled";
		}
		else{
			$User_Name = $_POST['User_Name'];
		}
		//user password
		if(empty($_POST['User_Password'])){
			$errors[] = "Password should be filled";
		}
		else{
			$User_Password = $_POST['User_Password'];
		}

		//Confirm_Password
		if(empty($_POST['Confirm_Password'])){
			$errors[] = "NConfirm Password should be filled!";
		}
		else{
			$Confirm_Password = $_POST['Confirm_Password'];
		}

		//user ID
		if(!isset($_POST['User_Id'])){
			$errors[] = "Your Id is not Known Please refresh the site!";
		}
		else{
			$User_Id = $_POST['User_Id'];
		}
		//Address
		if(empty($_POST['Address'])){
			$errors[] = "address should be filled";
		}
		else {
			$Address = $_POST['Address'];
		}

		//phone number
		if(empty($_POST['Phone_Number'])){
			$errors[] = "Address should be filled";
		}
		else {
			$Phone_Number = $_POST['Phone_Number'];
		}

		//email
		if(empty($_POST['Email'])){
			$errors[] = "Emails should be filled";
		}
		else{
			$Email = $_POST['Email'];
		}

		if(empty($errors)){
			if($User_Password == $Confirm_Password){
				if(!$controller->User_Name_Exists_For_Edit($User_Name,$User_Id)){
					//make the user object profile first
					$User_Profile = new UserProfile($Address,$Phone_Number,$Email);
					$User = new User($User_Name,$User_Password,$User_Type,$User_Id,$User_Profile);
					if( $controller->User_Edit_Profile($User)){
						session_start();
						$_SESSION["Logged_In_User"] = $User;
						admin_redirect_success($User_Type);
					}
				}
				else{
					admin_redirect_error(Error_Type::SAME_USER_NAME,$User_Type);
				}
			}
			else{
				admin_redirect_error(Error_Type::PASSWORD_DONT_MATCH,$User_Type);
			}
		}
		else{
			admin_redirect_error(Error_Type::FORM,$User_Type);
		}




	}

}