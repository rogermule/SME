<?php

require('Require.php');
require('Admin_Header.php');
require('Admin_Menu2.html');

	$user = $_SESSION['Logged_In_User'];
	$admin_con = new Admin_Controller($user);

	if($_SERVER['REQUEST_METHOD'] == "GET") {
		if(isset($_GET['User_ID'])){
			$User_Id = $_GET['User_ID'];
			$User = $admin_con->getUserProfile($User_Id);
			$User = mysqli_fetch_array($User,MYSQLI_ASSOC);
			$User_Name = $User['User_Name'];
			$User_Id = $User['Id'];
		}
	}

?>

<div class="col-sm-8 col-sm-offset-1 margin_top_51 list_container">

	<div class="col-sm-12">

		<div class="panel panel-default">
			<div class="panel-body text-center">
				<h4>Delete User</h4>
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
			      action="../../../CONTROLLER/Admin_Delete_User.php"
			      method="POST">


				<div class="form-group">
					<label for="Name" class="col-sm-6 control-label">User Name</label>
					<label for="Name" class="col-sm-6 control-label left"><?php echo($User_Name);?></label>
				</div>
				<input type="hidden" value="<?php echo($User_Id);?>" name="User_ID">

				<div class="alert alert-danger text-center margin_top_70">
					<strong>Are You sure you want to delete <?php echo($User_Name);?></strong>
				</div>

				<div class="form-group margin_top_20">

					<div class="col-sm-3 col-lg-offset-3">
						<a href="User_Lists.php" class="btn btn-info btn-block">Cancel</a>
					</div>

					<div class="col-sm-3 ">
						<button type="submit" class="btn btn-danger btn-block"><strong>Delete</strong>
						</button>
					</div>

				</div>
			</form>

		</div>

	</div>

</div>

<?php

include "Admin_Footer.php";

?>


