<?php

require('Require.php');
require('Admin_Header.php');
require('Admin_Menu2.html');
//show the form
$user = $_SESSION['Logged_In_User'];
$Admin = new Admin_Controller($user);//make an encoder object
$Bids = $Admin->GetAllOpenedBids();

?>

<div class="col-sm-8 col-sm-offset-1 margin_top_51 list_container">

	<div class="col-sm-12">

		<div class="panel panel-default">
			<div class="panel-body text-center">
				<h4>Add Bid</h4>
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
					<strong>You have added a new Bid successfully.</strong>

				</div>

				<?php

			}

			else if(isset($_GET['success_delete'])){
				?>
				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong>You have successfully deleted a Bid</strong>
				</div>
				<?php
			}
		}
		?>
		<div class=" margin_top_20">
			<form class="form-horizontal"
			      role="form"
			      action="../../../CONTROLLER/Admin_Add_Bid.php"
			      method="POST"
				  enctype = "multipart/form-data"
			>

				<div class="form-group">
					<label for="SubCity_Name" class="col-sm-4 control-label">Bid Name</label>
					<div class="col-sm-7">
						<input name="Bid_Name" type="text" class="form-control"  placeholder="Enter Bid Name" >
					</div>
				</div>

				<div class="form-group">
					<label for="SubCity_Name" class="col-sm-4 control-label">Bid Description</label>
					<div class="col-sm-7">

						<textarea name="Description" class="form-control"
						          placeholder="enter the description of the bid!">
						</textarea>
					</div>
				</div>


				<div class="form-group">
					<label for="profile_pic" class="col-sm-4 control-label">Upload Picture</label>
					<div class="col-sm-7">
						<input class="input-sm" type = "file" name = "profilepic"><br/>
					</div>
				</div>


				<div class="form-group margin_top_30">

					<div class="col-sm-2 col-lg-offset-4">
						<button type="submit" class="btn btn-success btn-block" name="uploadpic"><strong>Add Bid</strong>
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
				<h4>List of Opened Bids</h4>

			</div>
		</div>

		<div class=" margin_top_30">
			<table class="table table-hover">
				<thead>
				<th>#</th>
				<th>Bid Name</th>
				<th>Description</th>
				<th>Image</th>
				<th>Manage</th>
				</thead>
				<tbody>

				<?php
				//fetch the regions from the database and render them to the view
				$count = 0;

				$bid_name = "";
				$bid_description = "";
				$bid_Id = "";
				$bid_image_path = "";

				if($Bids){
					while($bids = mysqli_fetch_array($Bids,MYSQLI_ASSOC)){
						$count++;
						$bid_name = $bids['Name'];
						$bid_description = $bids['Description'];
						$bid_image_path = $bids['Picture'];
						$bid_Id = $bids['Id'];
						?>
						<tr>
							<td><?php echo($count);?></td>
							<td><?php echo($bid_name);?></td>
							<td><?php echo($bid_description);?></td>
							<td><?php if(!is_null($bid_image_path)){ ?>
									<a href="../../user_photos/<?php echo($bid_image_path);?>"><img src="../../user_photos/<?php echo($bid_image_path);?>" class="img-circle" width="100" height="100" /></a>
								<?php } ?>
							</td>
							<td>
								<a class="btn btn-danger btn-xs"
								   href="Delete_Bid.php?Bid_Id=<?php echo($bid_Id);?>">Delete</a>
								<a class="btn btn-info btn-xs"
								   href="Single_Bid_Manager.php?Bid_Id=<?php echo($bid_Id);?>">Manage</a>
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
