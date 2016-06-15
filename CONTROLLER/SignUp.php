<?php

require("../CONFIGURATION/Config.php");//this file contains configurations files
require("database.php");
require("../MODEL/User_Profile.php");//this is the user profile
require("../MODEL/User.php");//user object will be created so it should be included in here
require("User_Controller.php");//admin controller is going to extend this class so it should be included
require("Controller_Secure_Access.php");//this will prevent this file from being accessed easily
require("../MODEL/User_Type.php");
require("../MODEL/Error_Type.php");
$errors = array();


/**
 * @param $user_type
 * redirects the user to its own place
 */
function redirect_user($user_type){

	$home_page = "";
	$dir = "";
	if($user_type == User_Type::ADMIN){
		$home_page = "IUAndSMSList.php";
		$dir = "VIEW/html/ADMIN/";
	}
	else if($user_type == User_Type::IU){
		$home_page = "index.php";
		$dir = "VIEW/html/IU/";
	}

	else if($user_type == User_Type::SME){
		$home_page = "index.php";
		$dir = "VIEW/html/SME/";
	}

	$url = BASE_URL.$dir.$home_page;
	header("Location:$url");
	exit();
}

/**
 * @param $type_of_error
 * this function redirects the new sinee if there is any kind of error
 */
function admin_place_redirect($type_of_error){

	$error_type = "";
	if($type_of_error == Error_Type::FORM){
		$error_type = "Fill out the form  correctly.";
	}
	else if($type_of_error == Error_Type::DATA_BASE){
		$error_type = "Error when adding new user.";
	}
	else if($type_of_error == Error_Type::SAME_USER_NAME){
		$error_type = "Error! Choose Another name. The name is in use!";
	}
	else if($type_of_error == Error_Type::PASSWORD_DONT_MATCH){
		$error_type = "Error! Password don't mach!";
	}
	$dir = "VIEW/html/Login/SignUp.php?error=$error_type";
	$url = BASE_URL.$dir;
	header("Location:$url");
	exit();
}

/**
 * this will collect the profile data for the signups of the users
 */
if($_SERVER['REQUEST_METHOD'] == "POST"){



	/**
	 * get the name of the user
	 */
	if(empty($_POST['Name'])){
		$errors[] = "Sector Name Should be filled";
	}
	else{
		$Name = $_POST['Name'];
	}

	/**
	 * get the password of the user
	 */
	if(empty($_POST['Password'])){
		$errors[] = "Password should be filled";
	}
	else {
		$Password = $_POST['Password'];
	}


	/**
	 * Confirm password should be filled
	 */
	if(empty($_POST['Confirm_Password'])){
		$errors[] = "Confirm Password should be filled";
	}
	else {
		$Confirm_Password = $_POST['Confirm_Password'];
	}

	/**
	 * get the address of the user
	 */
	if(empty($_POST['Address'])){
		$errors[] = "Address should be filled";
	}
	else {
		$Address = $_POST['Address'];
	}


	/**
	 * get the phone number of the user
	 */
	if(empty($_POST['Phone_Number'])){
		$errors[] = "Phone number should be filled";
	}
	else{
		$Phone_Number = $_POST['Phone_Number'];
	}

	/**
	 * get the email of the user
	 */

	if(empty($_POST['Email'])){
		$errors[] = "Email should be filled";
	}
	else{
		$Email = $_POST['Email'];
	}

	/**
	 * get the user type
	 */
	if(isset($_POST['User_Type'])){
		$User_Type = $_POST['User_Type'];
	}
	else{
		$errors[] = "User type should be filled";
	}



	if(empty($errors)){

		if($Password == $Confirm_Password){

			$user_profile = new UserProfile($Address,$Phone_Number,$Email);
			$user = new User($Name,$Password,$User_Type,null,$user_profile);
			$user_controller = new User_Controller($user);
			if($user_controller->checkUserNameForSignUp($user->getUserName())){
				admin_place_redirect(Error_Type::SAME_USER_NAME);
			}
			else{

				if($user_controller->registerUser($user)){
					 $Logged_In = $user_controller->login();
					if($Logged_In){
						$user_type = $user->getUserType();
						if($user_type == User_Type::IU){
							redirect_user(User_Type::IU);
						}
						else if($user_type == User_Type::SME){
							redirect_user(User_Type::SME);
						}
					}
				}
				else{
					admin_place_redirect(Error_Type::DATA_BASE);
				}

			}



			echo("data");
			echo($user->getUserName());
			echo($user->getUserPassword());
			echo($user->getUserProfile()->getAddress());
			echo($user->getUserProfile()->getEmail());
			echo($user->getUserProfile()->getPhoneNumber());



		}

		else{
			admin_place_redirect(Error_Type::PASSWORD_DONT_MATCH);
		}
	}
	else{
		admin_place_redirect(Error_Type::FORM);
	}

}
