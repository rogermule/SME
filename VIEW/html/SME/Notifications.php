<?php

require('Require.php');
$user = $_SESSION['Logged_In_User'];
$User_Id  = $user->getUserID();
$SME_Con = new SME_Controller($user);
$user_name_for_header = $user->getUserName();
require('SME_Header.php');
require('SME_Menu.html');

$orders = $SME_Con->Get_All_Orders($User_Id);

$notifications = $SME_Con->GetNotifications($User_Id);

?>


<div class="col-sm-8 col-sm-offset-1 margin_top_51 list_container">




	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-body text-center">
				<h4>Notifications</h4>
			</div>
		</div>

		<div class=" margin_top_30">
			<table class="table table-hover">
				<thead>
				<th>#</th>

				<th>Notification Action</th>
				<th>Time</th>
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

				$Notification_Action = "";
				$Time = "";



				if($notifications){
					while($noti = mysqli_fetch_array($notifications,MYSQLI_ASSOC)){
						$count++;
						$Notification_Action = $noti['Action'];
						$Time = $noti['Time'];
						$Status = $noti['Status'];

						?>
						<tr>
							<td><?php echo($count);?></td>
							<td><?php echo($Notification_Action);?></td>
							<td><?php echo($Time);?></td>
							<td><?php

								if($Status == 1){
									?>
									<div class="btn btn-default btn-sm">Read</div>
									<?php
								}
								else if($Status == 0){
									?>
									<div class="btn btn-success btn-sm">new</div>
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

