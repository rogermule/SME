<?php

	require('Require.php');
	$user = $_SESSION['Logged_In_User'];
	$User_Id  = $user->getUserID();
	$IU_Con = new IU_Controller($user);

	$user_name_for_header = $user->getUserName();
	require('IU_Header.php');
	require('IU_Menu.html');

	$orders = $IU_Con->Get_All_Orders($User_Id);

?>

<div class="col-sm-8 col-sm-offset-1 margin_top_51 list_container">

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


		else if(isset($_GET['success_delete'])){
			?>
			<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>You have successfully deleted a A user</strong>
			</div>
			<?php
		}
	}
	?>


	<div class="col-sm-10 col-sm-offset-1">
		<div class="panel panel-default">
			<div class="panel-body text-center">
				<h4>Order Lists</h4>
			</div>
		</div>

		<div class=" margin_top_30">
			<table class="table table-hover">
				<thead>
				<th>#</th>

				<th>Ordered To</th>
				<th>Product Type</th>
				<th>Amount</th>
				<th>Status</th>


				</thead>
				<tbody>

				<?php

				$count = 0;
				$Order_Id = "";
				$Product_Name = "";
				$Amount = "";
				$Ordered_To_Name = "";
				$Order_Status = "";



				if($orders){
					while($ord = mysqli_fetch_array($orders,MYSQLI_ASSOC)){
						$count++;
						$Order_Id = $ord['Order_Id'];
						$Ordered_To_Name = $ord['User_Name'];
						$Amount = $ord['Amount'];
						$Product_Name = $ord['Product_Name'];
						$Order_Status = $ord['Order_Status'];
						?>
						<tr>
							<td><?php echo($count);?></td>
							<td><?php echo($Ordered_To_Name);?></td>
							<td><?php echo($Amount);?></td>
							<td><?php echo($Product_Name);?></td>

							<td><div class="btn btn-info btn-sm">
									<?php
									if($Order_Status == 1){
										echo("Accepted");
									}
									else if($Order_Status == 0){
										echo("Not Accepted Yet!");
									}
									?>
								</div>

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
require('IU_Footer.php');
?>

