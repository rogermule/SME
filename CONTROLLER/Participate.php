<?php



require("../CONFIGURATION/Config.php");//this file contains configurations files
require("database.php");
require("../MODEL/User.php");//user object will be created so it should be included in here
require("User_Controller.php");//admin controller is going to extend this class so it should be included
require("SME_Controller.php");
require("Controller_Secure_Access.php");//this will prevent this file from being accessed easily
require("../MODEL/User_Type.php");
require("../MODEL/Error_Type.php");
require("../MODEL/Bid.php");
require("../MODEL/Bid_Offer.php");//this
$errors = array();

/**
 * this will redirect the if the operation is successful
 */
function admin_redirect_success(){
	$dir = "VIEW/html/SME/Participating_Bid.php";
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

	$error_type = "";
	$Bid_Id = $_POST['Bid_Id'];
	if($type_of_error == Error_Type::FORM){
		$error_type = "Fill out the form  correctly.";
	}
	else if($type_of_error == Error_Type::DATA_BASE){
		$error_type = "Error when adding new user.";
	}
	else if($type_of_error == Error_Type::SAME_BID_NAME){
		$error_type = "You Are Participating in this Bid Before";
	}
	$dir = "VIEW/html/SME/Participate.php?error=$error_type&Bid_Id=$Bid_Id";
	$url = BASE_URL.$dir;
	header("Location:$url");
	exit();
}

if($_SERVER['REQUEST_METHOD'] == "POST"){

	if(TRUE == check_login_status()){


		$user_type = get_user_type();

		if($user_type == User_Type::SME){

			$user = $_SESSION['Logged_In_User'];
			$SME_Con = new SME_Controller($user);

			/**
			 * this is the amount
			 */
			if(empty($_POST['Amount'])){
				$errors[] = "Amount should be filled";
			}
			else{
				$Amount = $_POST['Amount'];
			}

			/**
			 * get the user Id
			 */
			if(empty($_POST['User_Id'])){
				$errors[] = "User Id should be filled!";
			}
			else{
				$User_Id = $_POST['User_Id'];
			}

			/**
			 * get the User Id
			 */
			if(empty($_POST['Bid_Id'])){
				$errors[] = "Bid Id should be filled";
			}
			else {
				$Bid_Id = $_POST['Bid_Id'];
			}


			//check if the user is participating on the bid previously
			if($SME_Con->Check_Participating($User_Id,$Bid_Id)){
				admin_place_redirect(Error_Type::SAME_BID_NAME);
			}


			if(empty($errors)){

				$Bid_Offer = new Bid_Offer($Bid_Id,$User_Id,$Amount);

				if($SME_Con->Participate_On_Bid($Bid_Offer)){
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