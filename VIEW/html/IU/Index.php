<?php

require('Require.php');
$user = $_SESSION['Logged_In_User'];
$IU_Con = new IU_Controller($user);

$Show_Search_Result = false;
$user_name_for_header = $user->getUserName();
require('IU_Header.php');
require('IU_Menu.html');
?>

<div class="col-sm-8 col-sm-offset-1 margin_top_51 list_container">

	<div class="col-sm-12">

		<div class="panel panel-default">
			<div class="panel-body text-center">
				<h4>Search SME And Order</h4>
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

			if(isset($_GET['Search_Text'])){

				$Search_Text = $_GET['Search_Text'];
				$Search_Results = $IU_Con->SearchSME($Search_Text);
				$Show_Search_Result  = true;

			}



		}

		?>

		<div class=" margin_top_20">
			<form class="form-horizontal"
			      role="form"
			      action="Index.php"
			      method="GET">

				<div class="form-group">

					<div class="col-sm-6 col-sm-offset-3">
						<input name="Search_Text" type="text" class="form-control"  placeholder="Search SME to make Order" >
					</div>
				</div>



				<div class="form-group margin_top_30">

					<div class="col-sm-2 col-lg-offset-5">
						<button type="submit" class="btn btn-success btn-block"><strong>Search</strong>
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
				<h4>SME Results</h4>

			</div>
		</div>

		<div class=" margin_top_30">
			<table class="table table-hover">
				<thead>
				<th>#</th>
				<th>Name</th>

				<th>Order</th>
				</thead>
				<tbody>

				<?php
				//fetch the regions from the database and render them to the view
				$count = 0;

				$bid_name = "";
				$bid_description = "";
				$bid_Id = "";

				if($Show_Search_Result){
					if($Search_Results){
						while($SR = mysqli_fetch_array($Search_Results,MYSQLI_ASSOC)){
							$count++;
							$SME_Name = $SR['User_Name'];
							$SME_Id = $SR['Id'];
							?>
							<tr>
								<td><?php echo($count);?></td>
								<td><?php echo($SME_Name);?></td>

								<td>
									<a class="btn btn-info btn-xs"
									   href="Order_Product.php?SME_ID=<?php echo($SME_Id);?>">Order</a>
								</td>
							</tr>
							<?php
						}
					}
				}


				?>

				</tbody>
			</table>
		</div>
	</div>
</div>

<?php
require('IU_Footer.php');
?>
