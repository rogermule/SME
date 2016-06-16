<?php

	require('Require.php');
	$user = $_SESSION['Logged_In_User'];
	$User_Id  = $user->getUserID();
	$SME_Con = new SME_Controller($user);
	$user_name_for_header = $user->getUserName();
	require('SME_Header.php');
	require('SME_Menu.html');
	$Products = $SME_Con->Get_SME_Products($User_Id);
	$Products_Select = $SME_Con->Get_All_Products();

?>


<div class="col-sm-8 col-sm-offset-1 margin_top_51 list_container">

	<div class="col-sm-12">

		<div class="panel panel-default">
			<div class="panel-body text-center">
				<h4>Add Your Products</h4>
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
			if(isset($_GET['success'])){
				?>
				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong>You have added a new Product Type successfully.</strong>

				</div>

				<?php

			}
			else if(isset($_GET['success_delete'])){
				?>
				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong>You have deleted Product Type successfully!</strong>
				</div>
				<?php
			}
		}
		?>

		<div class=" margin_top_20">
			<form class="form-horizontal"
			      role="form"
			      action="../../../CONTROLLER/SME_Add_Products.php"
			      method="POST">


				<div class="form-group">
					<label for="Building" class="col-sm-4 control-label">Select A product</label>
					<div class="col-sm-5">
						<select class="form-control " id="Product_ID" name="Product_Id">
							<?php
								$Products_Sel_ID ="";
								$Products_Sel_Name = "";
								if($Products_Select){
									while($PS = mysqli_fetch_array($Products_Select,MYSQLI_ASSOC)){
										$Products_Sel_ID = $PS['Id'];
										$Products_Sel_Name = $PS['Name'];
										?>
										<option value="<?php echo($Products_Sel_ID);?>">
											<?php echo($Products_Sel_Name);?></option>
										<?php
									}
								}
							?>
						</select>
					</div>

				</div>
				<div class="form-group">
					<label for="Building" class="col-sm-4 control-label">Product Name</label>
					<div class="col-sm-5">
						 <input class="form-control" type="text" name="Name" placeholder="Enter product name">

					</div>

				</div>
				<div class="form-group">
					<label for="Building" class="col-sm-4 control-label">Price </label>
					<div class="col-sm-5">
						<input class="form-control" type="text" name="Price" placeholder="Enter product name">

					</div>

				</div>


				<div class="form-group margin_top_30">

					<div class="col-sm-5 col-lg-offset-4">
						<button type="submit" class="btn btn-success btn-block"><strong>Add Product Type</strong>
						</button>
					</div>
				</div>
			</form>

		</div>

	</div>

	<div class="col-sm-12 margin_top_51 ">
		<hr>
		<div class="panel panel-primary list_header">
			<div class="panel-body text-center">
				<h4>List Of Your Products</h4>

			</div>
		</div>

		<div class=" margin_top_30">
			<table class="table table-hover">
				<thead>
				<th>#</th>
				<th>Product Type</th>
				<th>Sector Name</th>
				<th>Name</th>
				<th>Price</th>
				<th>Manage</th>


				</thead>
				<tbody>

				<?php
				//fetch the regions from the database and render them to the view
				$count = 0;
				$Product_Id = "";
				$Product_Name = "";
				$User_Product_Id = "";
				$Name = "";
				$Price = "";
				$Sector_Name = "";

				if($Products){
					while($pro = mysqli_fetch_array($Products,MYSQLI_ASSOC)){
						$count++;
						$Product_Name = $pro['Product_Name'];
						$Sector_Name = $pro['Sector_Name'];
						$Product_Id = $pro['Product_Id'];
						$User_Product_Id = $pro['User_Product_Id'];
						$Name = $pro['Name'];
						$Price = $pro['Price'];

						?>
						<tr>
							<td><?php echo($count);?></td>
							<td><?php echo($Product_Name);?></td>
							<td><?php echo($Sector_Name);?></td>
							<td><?php echo($Name);?></td>
							<td><?php echo($Price);?></td>

							<td>

								<a class="btn btn-danger btn-xs"
								   href="Delete_Product.php?User_Product_Id=<?php echo($User_Product_Id);?>&Product_Id=<?php echo($Product_Id);?>">Delete</a>
							</td>
						</tr>
						<?php
					}
				}
				?>

				</tbody>
			</table>
		</div>



	</div>

</div>


<?php
require('SME_Footer.php');
?>
