<?php

require('Require.php');
require('Admin_Header.php');
require('Admin_Menu2.html');
//show the form
$user = $_SESSION['Logged_In_User'];
$Admin = new Admin_Controller($user);//make an encoder object
$Bids = $Admin->GetAllClosedBids();

?>

<div class="col-sm-8 col-sm-offset-1 margin_top_51 list_container">



	<div class="col-sm-12 margin_top_5">

		<div class="panel panel-primary list_header">
			<div class="panel-body text-center">
				<h4>List Of Closed Bids</h4>

			</div>
		</div>

		<div class=" margin_top_30">
			<table class="table table-hover">
				<thead>
				<th>#</th>
				<th>Bid Name</th>
				<th>Description</th>
				<th>Opened On</th>
				<th>Closed On</th>
				</thead>
				<tbody>

				<?php
				//fetch the regions from the database and render them to the view
				$count = 0;

				$bid_name = "";
				$bid_description = "";
				$bid_Id = "";
				$Opened_On = "";
				$Closed_On = "";


				if($Bids){
					while($bids = mysqli_fetch_array($Bids,MYSQLI_ASSOC)){
						$count++;
						$bid_name = $bids['Name'];
						$bid_description = $bids['Description'];
						$bid_Id = $bids['Id'];
						$Opened_On = $bids['Opened_On'];
						$Closed_On = $bids['Closed_On'];
						?>
						<tr>
							<td><?php echo($count);?></td>
							<td><?php echo($bid_name);?></td>
							<td><?php echo($bid_description);?></td>
							<td><?php echo($Opened_On);?></td>
							<td><?php echo($Closed_On);?></td>

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
require('Admin_Footer.php');
?>
