<?php

require("../CONFIGURATION/Config.php");
require("database.php");
require("../MODEL/User.php");
require("User_Controller.php");
require("Controller_Secure_Access.php");


session_start();

//if the user accessed the page with out permission it will be redirected to the home page
if(!isset($_SESSION['Logged_In_User'])){
	redirect_to_index();

}
else{
	$user = $_SESSION["Logged_In_User"];
	$user_controller = new User_Controller($user);
	$user_controller->logout();
	redirect_to_index();

}



