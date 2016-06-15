<?php
require("../CONFIGURATION/Config.php");//this file contains configurations files
require("database.php");
require("../MODEL/User.php");//user object will be created so it should be included in here
require("User_Controller.php");//admin controller is going to extend this class so it should be included
require("Admin_Controller.php");
require("Controller_Secure_Access.php");//this will prevent this file from being accessed easily
require("../MODEL/User_Type.php");
require("../MODEL/Error_Type.php");
require("../MODEL/Sector.php");//this is used to make the sector object
$errors = array();


function admin_redirect_success(){

	$dir = "VIEW/html/Admin/User_Lists.php?success_delete=1";
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

	$User_ID = $_POST['User_ID'];

	$error_type = "";
	if($type_of_error == Error_Type::FORM){
		$error_type = "Fill out the form  correctly.";
	}
	else if($type_of_error == Error_Type::DATA_BASE){
		$error_type = "The Sector is referenced by another Product Type.
		Delete the Product Type Before deleting the Sector!";
	}
	else if($type_of_error == Error_Type::SAME_SECTOR_NAME){
		$error_type = "Error! You can Not add same sector name!";
	}
	$dir = "VIEW/html/Admin/Delete_User.php?error=$error_type&User_ID=$User_ID";
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

			if(empty($_POST['User_ID'])){
				$errors[] = "Sector is not Known Please refresh the site!";
			}
			else{
				$User_ID = $_POST['User_ID'];
			}

			if(empty($errors)){

				$deleted = $admin_con->Delete_User($User_ID);
				if($deleted){
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