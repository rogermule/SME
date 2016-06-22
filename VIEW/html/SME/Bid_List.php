<?php

require('Require.php');
$user = $_SESSION['Logged_In_User'];
$User_Id  = $user->getUserID();
$SME_Con = new SME_Controller($user);
$user_name_for_header = $user->getUserName();
require('SME_Header.php');
require('SME_Menu.html');
$bids = $SME_Con->GetAllOpenedBids();


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
				<th>Image</th>
				<th>Participate</th>
				</thead>
				<tbody>

				<?php

				$Time = "";
				$Bid_Id = "";
				$Bid_Name = "";
				$Bid_Description = "";
				$Opened_On = "";
				$Closed_On = "";
				$Bid_Image = "";
				$Status = "";
				$count = 0;

				if($bids){
					while($bid = mysqli_fetch_array($bids,MYSQLI_ASSOC)){
						$count++;

						$Bid_Id = $bid['Id'];
						$Bid_Name = $bid['Name'];
						$Bid_Description = $bid['Description'];
						$Opened_On = $bid['Opened_On'];
						$Bid_Image = $bid['Picture'];
						$Status = $bid['Description'];
						?>
						<tr>
							<td><?php echo($count);?></td>
							<td><?php echo($Bid_Name);?></td>
							<td><?php echo($Bid_Description);?></td>
							<td><?php echo($Opened_On);?></td>
							<td>
<!--								--><?php //echo($Bid_Image);?>
								<a href="../../user_photos/<?php echo($Bid_Image);?>"><img src="../../user_photos/<?php echo($Bid_Image);?>" width="100" height="100" class="img-circle"/></a>

							</td>
							<td><?php

								if($Status == 1){
									?>

									<a class="btn btn-default btn-sm"
									   href="Participate.php?Bid_Id=<?php echo($Bid_Id);?>">Closed</a>
									<?php
								}
								else if($Status == 0){
									?>
									<a class="btn btn-success btn-sm"
									   href="Participate.php?Bid_Id=<?php echo($Bid_Id);?>">Participate</a>

									<?php
								}
								?></td>

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

