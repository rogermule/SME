<?php

	require('Require.php');
	$user = $_SESSION['Logged_In_User'];
	$IU_Con = new IU_Controller($user);

	$user_name_for_header = $user->getUserName();
	require('IU_Header.php');
	require('IU_Menu.html');

	if($_SERVER['REQUEST_METHOD'] == "GET") {
		if(isset($_GET['SME_ID'])){

			$SME_ID = $_GET['SME_ID'];
			$User = $IU_Con->getUserProfile($SME_ID);
			$User = mysqli_fetch_array($User,MYSQLI_ASSOC);
			$User_Name = $User['User_Name'];
			$User_Id = $User['Id'];
			$Address = $User['Address'];
			$Phone_Number = $User['Phone_Number'];
			$Email = $User['Email'];
			$Products = $IU_Con->Get_SME_Products($SME_ID);

		}
	}


?>

<div class="col-sm-8 col-sm-offset-1 margin_top_51 list_container">

	<div class="col-sm-12">

		<div class="panel panel-default">
			<div class="panel-body text-center">
				<h4>Order a product to SME</h4>
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
			<form class="form-horizontal"
			      role="form"
			      action="../../../CONTROLLER/IU_Order_Products.php"
			      method="POST">

				<div class="form-group">

					<div class="col-sm-4 col-sm-offset-1">
						<p>Name     - <i><?php echo($User_Name);?></i></p>
						<p>Address  - <i><?php echo($Address);?></i></p>
						<p>Phone    - <i><?php echo($Phone_Number);?></i></p>
						<p>Email    - <i><?php echo($Email);?></i></p>
					</div>

					<div class="col-sm-4 col-sm-offset-1">
						<select class="form-control" id="Product_Type" name="Product_Type_Id">
							<option value="NOT_FILLED">Select Sector</option>
							<?php

							$Product_Id = "";
							$Product_Name = "";
							if($Products){
								while($pro = mysqli_fetch_array($Products,MYSQLI_ASSOC)){
									$Product_Id = $pro['Product_Id'];
									$Product_Name = $pro['Product_Name'];
									?>
									<option  value="<?php echo($Product_Id);?>">
										<?php echo($Product_Name);?></option>
									<?php
								}
							}
							?>
						</select>

						<input name="Amount" type="text" class="form-control margin_top_30"
						       placeholder="Enter the Amount of the products." >

						<input name="SME_ID" type="hidden" value="<?php echo($SME_ID);?>">
						<button type="submit" class="btn btn-success btn-block margin_top_30"><strong>Order</strong>
						</button>
					</div>
				</div>

			</form>

		</div>

	</div>





</div>

<?php
require('IU_Footer.php');
?>

