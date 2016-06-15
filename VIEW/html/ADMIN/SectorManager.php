<?php

	require('Require.php');
	require('Admin_Header.php');
	require('Admin_Menu2.html');
	//show the form
	$user = $_SESSION['Logged_In_User'];
	$Admin = new Admin_Controller($user);//make an encoder object
	$Sectors =  $Admin->getAllSectors();
	$Sectors_Number = mysqli_num_rows($Sectors);


?>

<div class="col-sm-8 col-sm-offset-1 margin_top_51 list_container">

	<div class="col-sm-12">

		<div class="panel panel-default">
			<div class="panel-body text-center">
				<h4>Add Sector Name</h4>
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

			if(isset($_GET['success'])){




				?>
				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong>You have added a new Sector successfully.</strong>

				</div>

				<?php

			}

			else if(isset($_GET['success_delete'])){
				?>
				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong>You have deleted Sector successfully!</strong>
				</div>
				<?php
			}
		}

		?>

		<div class=" margin_top_20">
			<form class="form-horizontal"
			      role="form"
			      action="../../../CONTROLLER/Admin_Add_Sector.php"
			      method="POST">

				<div class="form-group">
					<label for="SubCity_Name" class="col-sm-4 control-label">Sector Name</label>
					<div class="col-sm-5">
						<input name="Sector_Name" type="text" class="form-control" id="Sector_Name" placeholder="Enter Sector Name" >
					</div>
				</div>

				<div class="form-group margin_top_30">

					<div class="col-sm-5 col-lg-offset-4">
						<button type="submit" class="btn btn-success btn-block"><strong>Add Sector Name</strong>
						</button>
					</div>
				</div>
			</form>

		</div>

	</div>

	<div class="col-sm-12 margin_top_51 ">
		<hr>
		<div class="panel panel-primary list_header">
			<div class="panel-body text-center">
				<h4>List of Sectors</h4>

			</div>
		</div>

		<div class=" margin_top_30">
			<table class="table table-hover">
				<thead>
				<th>#</th>
				<th>Sub City</th>
				<th>Manage</th>


				</thead>
				<tbody>

				<?php
				//fetch the regions from the database and render them to the view
				$count = 0;
				$subcity_name = "";
				$subcity_name_amharic = "";
				$Sector_Name = "";


				if($Sectors){
					while($sectors = mysqli_fetch_array($Sectors,MYSQLI_ASSOC)){
						$count++;
						$Sector_Name = $sectors["Name"];
						$Sector_ID = $sectors['Id'];
						?>
						<tr>
							<td><?php echo($count);?></td>
							<td><?php echo($Sector_Name);?></td>

							<td>

								<a class="btn btn-danger btn-xs"
								   href="Delete_Sector.php?Sector_Id=<?php echo($Sector_ID);?>">Delete</a>
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
