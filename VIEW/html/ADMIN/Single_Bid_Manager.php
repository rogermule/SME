<?php

require('Require.php');
require('Admin_Header.php');
require('Admin_Menu2.html');
$user = $_SESSION['Logged_In_User'];
$admin_con = new Admin_Controller($user);
if($_SERVER['REQUEST_METHOD'] == "GET") {
	if(isset($_GET['Bid_Id'])){
		$Bid_Id = $_GET['Bid_Id'];
		$single_bid = $admin_con->getSingleBid($Bid_Id);
		$single_bid = mysqli_fetch_array($single_bid);
		$bid_name = $single_bid['Name'];
		$bid_description = $single_bid['Description'];

		$Participating_Users = $admin_con->Get_Bid_Participating_Users($Bid_Id);
	}
}
?>

<div class="col-sm-8 col-sm-offset-1 margin_top_51 list_container">

	<div class="col-sm-12">

		<div class="panel panel-default">
			<div class="panel-body text-center">
				<h4>Close Your Bid.</h4>
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
			      action="../../../CONTROLLER/Admin_Close_bid.php"
			      method="POST">


				<div class="form-group">
					<label for="Name" class="col-sm-5 control-label">Bid</label>
					<label for="Name" class="col-sm-7 control-label left"><?php echo($bid_name);?></label>
				</div>
				<div class="form-group">
					<label for="Name" class="col-sm-5 control-label">Description</label>
					<label for="Name" class="col-sm-7 control-label left"><?php echo($bid_description);?></label>
				</div>

				<input type="hidden" value="<?php echo($Bid_Id);?>" name="Bid_Id">

				<div class="alert alert-success text-center margin_top_70">
					<strong>Closing this bid will notify the winner Of this Bid</strong>
				</div>

				<div class="form-group margin_top_20">

					<div class="col-sm-2 col-lg-offset-3">
						<a href="Bid_Manager.php" class="btn btn-info btn-block">Cancel</a>
					</div>

					<div class="col-sm-4 ">
						<button type="submit" class="btn btn-success btn-block"><strong>Close The Bid</strong>
						</button>
					</div>

				</div>
			</form>

		</div>


		<div class="col-sm-12 margin_top_51 ">
			<hr>
			<div class="panel panel-primary list_header">
				<div class="panel-body text-center">
					<h4>List of Participating SME</h4>

				</div>
			</div>

			<div class=" margin_top_30">
				<table class="table table-hover">
					<thead>
					<th>#</th>
					<th>SME Name</th>
					<th>Bid Amount</th>


					</thead>
					<tbody>

					<?php
					//fetch the regions from the database and render them to the view
					$count = 0;



					if($Participating_Users){
						while($PU = mysqli_fetch_array($Participating_Users,MYSQLI_ASSOC)){
							$count++;
							$User_Name = $PU["User_Name"];
							$Amount = $PU["Amount"];
							?>
							<tr>
								<td><?php echo($count);?></td>
								<td><?php echo($User_Name);?></td>
								<td><?php echo($Amount);?></td>


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



</div>


<?php

include "Admin_Footer.php";

?>


