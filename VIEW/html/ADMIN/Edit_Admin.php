<?php

require('Require.php');
require('Admin_Header.php');
require('Admin_Menu2.html');

$user = $_SESSION['Logged_In_User'];
$admin_con = new Admin_Controller($user);
$Admin_Name = $user->getUserName();
$Admin_ID = $user->getUserID();

?>


<div class="col-sm-8 col-sm-offset-1 margin_top_51 list_container">
	<div class=" row list_container margin_0">


		<div class="col-sm-12">

			<?php
			if($_SERVER['REQUEST_METHOD'] == "GET") {

				if(isset($_GET['error'])){
					$error_msg = $_GET['error'];
					?>

					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close"
						        data-dismiss="alert"
						        aria-hidden="true">&times;</button>
						<strong>Warning!</strong><?php echo($error_msg);?>
					</div>

					<?php
				}


			}
			?>


			<div class="panel panel-default">
				<div class="panel-body text-center">
					<h2 class="green">Admin Edit Profile</h2>
				</div>
			</div>


			<div class="col-sm-8 col-sm-offset-1 margin_top_30">
				<form class="form-horizontal" role="form" action="../../../CONTROLLER/Admin_Edit_Profile.php" method="POST">


					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label">User Name</label>
						<div class="col-sm-8">
							<input name="User_Name" type="text" class="form-control" id="inputEmail3" placeholder="Enter user name" value="<?php echo($Admin_Name);?>">
						</div>
					</div>


					<div class="form-group">
						<label for="inputPassword3" class="col-sm-4 control-label">Previous Password</label>
						<div class="col-sm-8">

							<input name="Previous_Password" type="password" class="form-control" id="inputPassword3" placeholder="Enter previous password" >
						</div>
					</div>


					<div class="form-group">
						<label for="phone" class="col-sm-4 control-label">New Password</label>
						<div class="col-sm-8">

							<input name="New_Password" class="form-control" id="phone" placeholder="New Password">

						</div>
					</div>


					<input type="hidden" name="Admin_ID" value="<?php echo($Admin_ID);?>">



					<div class="form-group margin_top_51">
						<div class="col-sm-offset-4 col-sm-4">
							<a href="IUAndSMSList.php" class="btn btn-default btn-block" role="button">cancel</a>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-success btn-block"><strong>Save</strong>
							</button>
						</div>
					</div>
				</form>

			</div>



		</div>



	</div>
</div>

<?php
require('Admin_Footer.php');
?>
