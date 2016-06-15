<?php


//this php file will handle login of the use and the redirection of the user


require("../CONFIGURATION/Config.php");//this file contains configurations files
require("database.php");
require("../MODEL/User.php");//user object will be created so it should be included in here
require("User_Controller.php");//admin controller is going to extend this class so it should be included
require("../MODEL/User_Type.php");
$errors = array();


function send_error($error_type){
	$login_page = "Login.php";
	$directory  = "VIEW/html/Login/";
	if($error_type == "fill_error"){
		$error = "fill_error";
	}
	else if($error_type == "credential_error"){
		$error = "credential_error";
	}

 	$url = BASE_URL.$directory.$login_page;
 	header("Location:$url?error=$error");
	exit();
}

function redirect_user($user_type){

	$home_page = "";
	$dir = "";
	if($user_type == User_Type::ADMIN){
		$home_page = "User_Lists.php";
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



if($_SERVER['REQUEST_METHOD'] == 'POST'){

 	if(empty($_POST['User_Name'])){
 		$errors[] = "You forgot to enter your name";
 	}
	else{
		$user_name = $_POST['User_Name'];
	}

 	if(empty($_POST['User_Password'])){
		$errors[] = "You forgot to enter Your password";
	}
	else{
		$user_password  = $_POST['User_Password'];
	}



	if(empty($errors)){


		$user = new User($user_name,$user_password);
  		$user_controller = new User_Controller($user);
  		$Logged_In = $user_controller->login();

		if($Logged_In){
			//get the new user
			//and from the new user find the type of the user
			$Logged_In_User = $user_controller->getUser();
			$user_type = $Logged_In_User->getUserType();
 			if($user_type == User_Type::ADMIN){

 				 redirect_user(User_Type::ADMIN);

			}
	 		else if($user_type == User_Type::IU){

 			    redirect_user(User_Type::IU);

			}
		    else if($user_type == User_Type::SME){
 			    redirect_user(User_Type::SME);
		    }
			else {
				send_error("credential_error");
			}
		}//if the user credentials are not correct
		else{
			//this function will send errors that the credential the users has entered is not correct
			send_error("credential_error");
		}
	}
	else{
		//send error to the login page that the forms are not filled
		send_error("fill_error");
	}
}
