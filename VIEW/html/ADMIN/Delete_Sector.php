<?php

	require('Require.php');
	require('Admin_Header.php');
	require('Admin_Menu2.html');

	$user = $_SESSION['Logged_In_User'];
	$admin_con = new Admin_Controller($user);
	$Admin_Name = $user->getUserName();
	$Admin_ID = $user->getUserID();

	if($_SERVER['REQUEST_METHOD'] == "GET") {
		if(isset($_GET['Sector_Id'])){
			$Sector_Id = $_GET['Sector_Id'];
			$single_sector  = $admin_con->getSingleSector($Sector_Id);
			$single_sector = mysqli_fetch_array($single_sector);
			$sector_name = $single_sector['Name'];
			$sector_Id = $single_sector['Id'];
		}
	}




?>

<div class="col-sm-8 col-sm-offset-1 margin_top_51 list_container">

	<div class="col-sm-12">

		<div class="panel panel-default">
			<div class="panel-body text-center">
				<h4>Delete Sector</h4>

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
			      action="../../../CONTROLLER/Admin_Delete_Sector.php"
			      method="POST">


				<div class="form-group">
					<label for="Name" class="col-sm-6 control-label">Sector</label>
					<label for="Name" class="col-sm-6 control-label left"><?php echo($sector_name);?></label>
				</div>
				<input type="hidden" value="<?php echo($sector_Id);?>" name="Sector_Id">

				<div class="alert alert-danger text-center margin_top_70">
					<strong>Are You sure you want to delete <?php echo($sector_name);?></strong>
				</div>

				<div class="form-group margin_top_20">

					<div class="col-sm-3 col-lg-offset-3">
						<a href="SectorManager.php" class="btn btn-info btn-block">Cancel</a>
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


