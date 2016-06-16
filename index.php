<?php
function login(){
	$dir = "VIEW/html/Login/Login.php";
	header("Location:$dir");
	exit();
}
login();