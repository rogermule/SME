<?php


/**
 * In the login
 */
session_start();



//this will redirect the user to the login page
function redirect_to_index(){
	$dir = "VIEW/html/Login/Login.php";//this is the login directory

	$url = BASE_URL.$dir;

	header("Location:$url");
	exit();
}


//if the url is not defined redirect the user to login page

if(!defined('BASE_URL')){
	require("../CONFIGURATION/Config.php");
	redirect_to_index();
}
function check_login_status(){
	if(isset($_SESSION['Logged_In_User'])){

		//if the user is logged in return true
		return true;

	}
	else{

		//if the user is not logged in return false
		return false;

	}
}

/**
 * returns the user type
 */
function get_user_type(){


	$user = $_SESSION['Logged_In_User'];
	$user_type = $user->getUserType();
	return $user_type;
}







