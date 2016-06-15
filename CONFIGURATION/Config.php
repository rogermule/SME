<?php




$contact_email  = "TheEmailOfTheApplicationOwner@gmail.com";

	//determine if we are working on a local server or on a real server
$var = $_SERVER['HTTP_HOST'];

	//if(stristr){}
	//in here the stristr returns the string that starts from the second argument from the first argument and if there is
	// a third argument that is true it will return the string that is before the first
	//appearance of the second argument string

if( stristr($_SERVER['HTTP_HOST'],"local")|| (substr($_SERVER['HTTP_HOST'],0,7) =='192.168')){
	$local = True;
}else {
	$local = False;
}

	// BASE URI is the absolute path to the fo
if($local){
	$debug  = True;
	define('BASE_URI','C:/xampp/htdocs/SME/');
	define('BASE_URL','http://localhost/SME/');
	define('DB','C:/xampp/htdocs/SME/MODEL/DataBase.php');

}
else{

	//update this if you are going global
	define ('BASE_URI', '/path/to/live/html/folder/');
	define ('BASE_URL', 'http://www.example.com/');
	define ('DB', '/path/to/live/mysql.inc.php');
}



function my_error_handler($e_number,$e_message,$e_file,$e_line,$e_vars){
	global $debug,$contact_email;
	$message = "An error occured in $e_file on $e_line: \n<br/> $e_message\n<br/>";


	//add the date and time
	$message .= "Date/Time: ".date('n-j-Y H:i:s') . "\n<br />";

	//append vars to the message


	if($debug){// show the error if debug mode is on
		echo('<p class="error">'.$message.'</p>');

	}
	else {
		//log the error
		error_log($message,1,$contact_email);
		//only print an error message if the error is a notice or strict

		if(($e_number != E_NOTICE) || ($e_number <2048)){
			echo('<p class="error"> A system error occurred we apologize for the inconvenience.</p>');
		}

	}
}

	set_error_handler('my_error_handler');


?>



















