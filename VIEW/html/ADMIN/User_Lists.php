<?php

require('Require.php');
require('Admin_Header.php');
require('Admin_Menu2.html');
$user = $_SESSION['Logged_In_User'];
$Admin = new Admin_Controller($user);//make an encoder object
$IU = $Admin->getAllUsers(User_Type::IU);
$SMS = $Admin->getAllUsers(User_Type::SME);

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


	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-body text-center">
				<h4>IU Lists</h4>
			</div>
		</div>

		<div class=" margin_top_30">
			<table class="table table-hover">
				<thead>
				<th>#</th>
				<th>Name</th>
				<th>Manage</th>

				</thead>
				<tbody>

				<?php
				//fetch the regions from the database and render them to the view
				$count = 0;
				$IU_Name = "";
				$IU_ID = "";


				if($IU){
					while($iu = mysqli_fetch_array($IU,MYSQLI_ASSOC)){
						$count++;
						$IU_Name = $iu['User_Name'];
						$IU_ID = $iu['Id'];
						?>
						<tr>
							<td><?php echo($count);?></td>
							<td><?php echo($IU_Name);?></td>

							<td>

								<a class="btn btn-danger btn-xs"
								   href="Delete_User.php?User_ID=<?php echo($IU_ID);?>">Delete</a>
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

	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-body text-center">
				<h4>SME Lists</h4>
			</div>
		</div>

		<div class=" margin_top_30">
			<table class="table table-hover">
				<thead>
				<th>#</th>
				<th>Name</th>
				<th>Manage</th>

				</thead>
				<tbody>

				<?php
				//fetch the regions from the database and render them to the view
				$count = 0;
				$SMS_Name = "";
				$SMS_Id = "";


				if($SMS){
					while($sms = mysqli_fetch_array($SMS,MYSQLI_ASSOC)){
						$count++;
						$SMS_Name = $sms['User_Name'];
						$SMS_ID = $sms['Id'];
						?>
						<tr>
							<td><?php echo($count);?></td>
							<td><?php echo($SMS_Name);?></td>

							<td>

								<a class="btn btn-danger btn-xs"
								   href="Delete_User.php?User_ID=<?php echo($SMS_ID);?>">Delete</a>
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
require('Admin_Footer.php');
?>



