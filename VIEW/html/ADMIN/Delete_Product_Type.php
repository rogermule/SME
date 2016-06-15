<?php

require('Require.php');
require('Admin_Header.php');
require('Admin_Menu2.html');
$user = $_SESSION['Logged_In_User'];
$admin_con = new Admin_Controller($user);
$Admin_Name = $user->getUserName();
$Admin_ID = $user->getUserID();

if($_SERVER['REQUEST_METHOD'] == "GET") {
	if(isset($_GET['Product_Type_Id'])){
		$Product_Type_Id = $_GET['Product_Type_Id'];
		$single_product_type = $admin_con->getSingleProductType($Product_Type_Id);
		$single_product_type = mysqli_fetch_array($single_product_type);
		$product_type_name = $single_product_type['Name'];
		$product_type_Id = $single_product_type['Id'];
	}
}


?>

<div class="col-sm-8 col-sm-offset-1 margin_top_51 list_container">

	<div class="col-sm-12">

		<div class="panel panel-default">
			<div class="panel-body text-center">
				<h4>Delete Product Type</h4>
			</div>
		</div>

		<?php

		if($_SERVER['REQUEST_METHOD'] == "GET") {

			if(isset($_GET['error'])){
				$error_msg = $_GET['error'];
				?>
				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong>Warning!</strong><?php echo($error_msg);?>
				</div>
				<?php
			}
		}

		?>
		<div class=" margin_top_20">
			<form class="form-horizontal" role="form"
			      action="../../../CONTROLLER/Admin_Delete_Product_Type.php"
			      method="POST">


				<div class="form-group">
					<label for="Name" class="col-sm-6 control-label">Sector</label>
					<label for="Name" class="col-sm-6 control-label left"><?php echo($product_type_name);?></label>
				</div>
				<input type="hidden" value="<?php echo($product_type_Id);?>" name="Product_Type_Id">

				<div class="alert alert-danger text-center margin_top_70">
					<strong>Are You sure you want to delete <?php echo($product_type_name);?></strong>
				</div>

				<div class="form-group margin_top_20">

					<div class="col-sm-3 col-lg-offset-3">
						<a href="Product_Type_Manager.php" class="btn btn-info btn-block">Cancel</a>
					</div>

					<div class="col-sm-3 ">
						<button type="submit" class="btn btn-danger btn-block"><strong>Delete</strong>
						</button>
					</div>

				</div>
			</form>

		</div>


	</div>



</div>


<?php

include "Admin_Footer.php";

?>


