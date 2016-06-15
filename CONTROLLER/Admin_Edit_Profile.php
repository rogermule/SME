<?php


require("../CONFIGURATION/Config.php");//this file contains configurations files
require("database.php");
require("../MODEL/User.php");//user object will be created so it should be included in here
require("User_Controller.php");//admin controller is going to extend this class so it should be included
require("Admin_Controller.php");
require("Controller_Secure_Access.php");//this will prevent this file from being accessed easily
require("../MODEL/User_Type.php");
require("../MODEL/Error_Type.php");
$errors = array();


function admin_redirect_success(){

	$dir = "VIEW/html/Admin/SectorAndProductList.php?success_edit=1";
	$url = BASE_URL.$dir;
	header("Location:$url");//redirect the admin to the Admin_Add_Users.php file
	exit();

}


function admin_redirect_error($type_of_error){


	$error_type = "";

	if($type_of_error == Error_Type::FORM){
		$error_type = "Fill out the form  correctly.";
	}
	if($type_of_error == Error_Type::PRV_PASSWORD_DONT_MATCH){
		$error_type = "previous password don't match.";
	}

	else if($type_of_error == Error_Type::DATA_BASE){
		$error_type = "Error when adding new user.";
	}

	else if($type_of_error == Error_Type::SAME_USER_NAME){
		$error_type = "Error, Use a different name. User name exists before.";
	}

	$dir = "VIEW/html/Admin/Edit_Admin.php?error=$error_type";
	$url = BASE_URL.$dir;
	header("Location:$url");//redirect the admin to the Edit_Admin.php
	exit();
}




if($_SERVER['REQUEST_METHOD'] == "POST"){


 	if(TRUE == check_login_status()){

 		$user_type = get_user_type();

 		if($user_type == User_Type::ADMIN){
  			$user_admin = $_SESSION['Logged_In_User'];
  			$admin_password = $user_admin->getUserPassword();
 			$admin_controller = new Admin_Controller($user_admin);

 			if(empty($_POST['User_Name'])){
				$errors[] = "User Name Should be filled";
			}
			else{
				$User_Name = $_POST['User_Name'];
			}

 			if(empty($_POST['Previous_Password'])){
				$errors[] = "Previous password should be filled";
			}
			else{
				$Previous_Password = $_POST['Previous_Password'];
			}

 			if(empty($_POST['New_Password'])){
				$errors[] = "New Password should be filled";
			}
			else{
				$New_Password = $_POST['New_Password'];
			}



			if(!isset($_POST['Admin_ID'])){
				$errors[] = "Please go back and refresh the site!";
			}
			else{
				$User_ID = $_POST['Admin_ID'];
			}

			if($admin_password != $Previous_Password){
				$errors[] = "previous password don't match";
				admin_redirect_error(Error_Type::PRV_PASSWORD_DONT_MATCH);
			}

			if($admin_controller->Check_User_Name_For_Edit($User_Name,$User_ID)){
				admin_redirect_error(Error_Type::SAME_USER_NAME);
			}


			/**
			 * if there is no error
			 */
			if(empty($errors)){

				/**
				 * instantiate a new user
				 */
				$new_user= new User($User_Name,$New_Password);
				$new_user->setUserID($User_ID);

				/**
				 * Edit the user and a new user will be returned if the user is updated
				 */
				$edited= $admin_controller->Admin_Edit_Profile($new_user);

				/**
				 * inform the admin about the result
				 */
				if($edited){
					admin_redirect_success();
				}
				else{
					admin_redirect_error(Error_Type::DATA_BASE);
				}

			}
			/**
			 * if there are errors when filling the form
			 */
			else{

				admin_redirect_error(Error_Type::FORM);
			}

		}
	}

}







