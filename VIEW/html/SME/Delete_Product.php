<?php
	require('Require.php');
	$user = $_SESSION['Logged_In_User'];
	$User_Id  = $user->getUserID();
	$SME_Con = new SME_Controller($user);
	$user_name_for_header = $user->getUserName();
	require('SME_Header.php');
	require('SME_Menu.html');
	if($_SERVER['REQUEST_METHOD'] == "GET") {
			$User_Product_Id = $_GET['User_Product_Id'];
			$product_Id = $_GET['Product_Id'];
			$Product = $SME_Con->getSingleProductType($product_Id);
			$product = mysqli_fetch_array($Product);
			$product_name = $product['Name'];
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
			      action="../../../CONTROLLER/SME_Delete_Product.php"
			      method="POST">

				<div class="form-group">
					<label for="Name" class="col-sm-6 control-label">Product Name</label>
					<label for="Name" class="col-sm-6 control-label left"><?php echo($product_name);?></label>
				</div>
				<input type="hidden" value="<?php echo($User_Product_Id);?>" name="User_Product_Id">
				<input type="hidden" value="<?php echo($product_Id);?>" name="Product_Id">

				<div class="alert alert-danger text-center margin_top_70">
					<strong>Are You sure you want to remove <?php echo($product_name);?></strong> from Your list of Products.
				</div>

				<div class="form-group margin_top_20">
					<div class="col-sm-3 col-lg-offset-3">
						<a href="Manage_Products.php" class="btn btn-info btn-block">Cancel</a>
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
require('SME_Footer.php');
?>

