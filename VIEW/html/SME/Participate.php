<?php

		require('Require.php');
		$user = $_SESSION['Logged_In_User'];
		$User_Id  = $user->getUserID();
		$SME_Con = new SME_Controller($user);
		$user_name_for_header = $user->getUserName();
		require('SME_Header.php');
		require('SME_Menu.html');
		if($_SERVER['REQUEST_METHOD'] == "GET") {


			$Bid_Id = $_GET['Bid_Id'];
			$Single_Bid = $SME_Con->getSingleBid($Bid_Id);
			$Single_Bid = mysqli_fetch_array($Single_Bid,MYSQLI_ASSOC);
			$Bid_Name = $Single_Bid['Name'];
			$Bid_Description = $Single_Bid['Description'];
			$Opened_On = $Single_Bid['Opened_On'];
			$Closed_On = $Single_Bid['Closed_On'];
			$Status = $Single_Bid['Status'];
		}
else{
	echo("Please Refresh The Site!");
}


?>


<div class="col-sm-8 col-sm-offset-1 margin_top_51 list_container">




	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-body text-center">
				<h4>Bids</h4>
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

		<div class="col-sm-4 col-sm-offset-4" style="text-align: center">
			<h4 class="margin_top_20">Name</h4>
			<p><?php echo($Bid_Name);?></p>
			<h4 class="margin_top_20">Description</h4>
			<p><?php echo($Bid_Description);?></p>
			<h4 class="margin_top_20">Opened On</h4>
			<p><?php echo($Opened_On);?></p>
			<h4 class="margin_top_20">Closed On</h4>
			<p><?php echo($Closed_On);?></p>

			<?php if($Status == 0){
				?>
				<p>You Can Participate on this Bid.</p>
				<form method="post" action="../../../CONTROLLER/Participate.php">
					<div class="form-group">
						<input class="form-control" type="text" placeholder="Enter The Bid Amount" name="Amount">
						<input type="hidden" name="User_Id" value="<?php echo($User_Id);?>">
						<input type="hidden" name="Bid_Id" value="<?php echo($Bid_Id);?>">
					</div>
					<button class="btn btn-success btn-block">Participate</button>
				</form>
				<?php
				}else {
				?>
				<h4>This Bid is Closed!</h4>
				<?php
			}?>
		</div>
	</div>



</div>

<?php

$SME_Con->Set_Notification_Read($User_Id);
require('SME_Footer.php');
?>

