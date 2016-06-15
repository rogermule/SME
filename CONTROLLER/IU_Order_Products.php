<?php
require("../CONFIGURATION/Config.php");//this file contains configurations files
require("database.php");
require("../MODEL/User_Profile.php");
require("../MODEL/User.php");//user object will be created so it should be included in here
require("User_Controller.php");//admin controller is going to extend this class so it should be included
require("IU_Controller.php");
require("Controller_Secure_Access.php");//this will prevent this file from being accessed easily
require("../MODEL/User_Type.php");
require("../MODEL/Error_Type.php");
require("../MODEL/Order.php");
require("../MODEL/Notification.php");
$errors = array();
/**
 * this will redirect the if the operation is successful
 */
function admin_redirect_success(){
	$dir = "VIEW/html/IU/Index.php?success=1";
	$url = BASE_URL.$dir;
	header("Location:$url");//redirect the admin to the Admin_Add_Users.php file
	exit();
}
/**
 * @param $type_of_error
 * this function takes an error type
 * and redirect the encoder to the add regions place
 */
function admin_place_redirect($type_of_error,$SME_ID){
	$error_type = "";
	if($type_of_error == Error_Type::FORM){
		$error_type = "Fill out the form  correctly.";
	}
	else if($type_of_error == Error_Type::DATA_BASE){
		$error_type = "Error when adding new user.";
	}
	else if($type_of_error == Error_Type::SAME_BID_NAME){
		$error_type = "Error! You can Not add same sector name!";
	}
	$dir = "VIEW/html/IU/Order_Product.php?error=$error_type&SME_ID=$SME_ID";
	$url = BASE_URL.$dir;
	header("Location:$url");
	exit();
}
if($_SERVER['REQUEST_METHOD'] == "POST"){

	if(TRUE == check_login_status()){
		$user_type = get_user_type();
		if($user_type == User_Type::IU){
			$IU = $_SESSION['Logged_In_User'];
			$User_ID = $IU->getUserID();
			$User_Name = $IU->getUserName();
			$IU_Con = new IU_Controller($IU);
			/**
			 * get the product ID
			 */
			if(empty($_POST['Product_Type_Id'])){
				$errors[] = "Product Type Id should be filled.";
			}
			else{
				$Product_Type_Id = $_POST['Product_Type_Id'];
				$product  =  $IU_Con->getSingleProductType($Product_Type_Id);
				$product = mysqli_fetch_array($product,MYSQLI_ASSOC);
				$product_Name = $product['Name'];

			}
			/**
			 * get the amount
			 */
			if(empty($_POST['Amount'])){
				$errors[] = "Amount should be filled";
			}
			else{
				$Amount = $_POST['Amount'];
			}
			/**
			 * get the SME ID
			 */
			if(empty($_POST['SME_ID'])){
				$errors[] = "SME ID should be filled";
			}
			else{
				$SME_ID = $_POST['SME_ID'];
			}
			/**
			 * if no errors make the order object and add it to the database
			 */
			if(empty($errors)){
				$Order = new Order($Product_Type_Id, $Amount, $User_ID, $SME_ID);
				if($IU_Con->MakeOrder($Order)){

					$Action = $User_Name." Ordered ".$Amount." ".$product_Name;
					$notification = new Notification($Action,$SME_ID);
					if($IU_Con->Add_Notification($notification)){
						admin_redirect_success();
					}
					else{
						admin_place_redirect(Error_Type::DATA_BASE);
					}
				}
			}
			else{
				admin_place_redirect(Error_Type::FORM,$SME_ID);
			}

		}
	}

}