<?php


function check_admin_status(){
	if(isset($_SESSION['Logged_In_User'])){
 		//if the user is logged in return true
		return true;
 	}
	else{
 		//if the user is not logged in return false
		return false;
 	}
}

function get_admin_type(){

	$user = $_SESSION['Logged_In_User'];
	$user_type = $user->getUserType();
	return $user_type;
}


function admin_redirect_index(){
	$dir = "VIEW/html/Login/Login.php";//this is the login directory

	$url = BASE_URL.$dir;

	header("Location:$url");
	exit();
}


//this will check if the user is logged in or not and redirect the user to another page
if(check_admin_status()){
	 if(User_Type::ADMIN == get_admin_type()){
	  }
	 else{
		 admin_redirect_index();
	 }
 }
else{
	admin_redirect_index();
}
