<?php

require('Require.php');
$user = $_SESSION['Logged_In_User'];
$User_Id  = $user->getUserID();
$SME_Con = new SME_Controller($user);
$user_name_for_header = $user->getUserName();
require('SME_Header.php');
require('SME_Menu.html');
$bids = $SME_Con->Get_Participating_bids($User_Id);


?>


<div class="col-sm-8 col-sm-offset-1 margin_top_51 list_container">




	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-body text-center">
				<h4>Bids</h4>
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
				<th>Bid Amount</th>
				</thead>
				<tbody>

				<?php

				$Time = "";
				$Bid_Id = "";
				$Bid_Name = "";
				$Bid_Description = "";
				$Opened_On = "";
				$Closed_On = "";
				$Status = "";
				$count = 0;

				if($bids){
					while($bid = mysqli_fetch_array($bids,MYSQLI_ASSOC)){
						$count++;


						$Bid_Name = $bid['Bid_Name'];
						$Bid_Description = $bid['Bid_Description'];
						$Opened_On = $bid['Opened_On'];
						$Closed_On = $bid['Closed_On'];
						$Amount = $bid['Amount'];
						?>
						<tr>
							<td><?php echo($count);?></td>
							<td><?php echo($Bid_Name);?></td>
							<td><?php echo($Bid_Description);?></td>
							<td><?php echo($Opened_On);?></td>
							<td><?php echo($Closed_On);?></td>
							<td><?php echo($Amount); ?></td>
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

	$SME_Con->Set_Notification_Read($User_Id);
	require('SME_Footer.php');

?>