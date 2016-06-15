<?php

require('Require.php');
$user = $_SESSION['Logged_In_User'];
$IU_Con = new IU_Controller($user);
$user_name_for_header = $user->getUserName();
$User_Id = $user->getUserID();
$User_Profile = $IU_Con->getUserProfile($User_Id);
$User_Profile = mysqli_fetch_array($User_Profile);
$User_Name = $User_Profile['User_Name'];
$User_Address = $User_Profile['Address'];
$User_Phone_Number = $User_Profile['Phone_Number'];
$User_Email = $User_Profile['Email'];
$User_Type = $User_Profile['User_Type'];

require('IU_Header.php');
require('IU_Menu.html');

?>



	<div class="col-lg-8 col-sm-offset-1 margin_top_51">
		<div class="panel panel-primary">
			<div class="panel-heading">

				<h4 class="text-center">Edit Profile</h4>
			</div>
			<div class="panel-body">

				<?php
				if($_SERVER['REQUEST_METHOD'] == "GET"){
					if(isset($_GET['error'])){
						if($_GET['error']){
							?>
							<div class="alert alert-danger">
								<a href="#" class="alert-link"><?php echo($_GET['error']);?></a>
							</div>
							<?php
						}

					}
				}
				?>
				<div class="col-lg-6 col-lg-offset-3">
					<form action="../../../CONTROLLER/User_Edit_Profile.php" method="POST">

						<div class="form-group">
							<label for="user_name">Name</label>
							<input type="text"
							       id="User_Name"
							       name="User_Name"
							       class="form-control"
							       placeholder="enter user name"
									value="<?php echo($User_Name);?>"/>
						</div>

						<div class="form-group">
							<label for="password">Password</label>
							<input type="password"
							       id="User_Password"
							       name="User_Password"
							       class="form-control"
							       placeholder="enter password" >
						</div>


						<div class="form-group">
							<label for="password2">Retype Password</label>
							<input type="password"
							       id="Confirm_Password"
							       name="Confirm_Password"
							       class="form-control"
							       placeholder="retype password">
						</div>


						<div class="form-group">
							<label for="address">Address</label>
							<input type="text"
							       id="Address"
							       name="Address"
							       class="form-control"
							       placeholder="Enter Address"
								value="<?php echo($User_Address);?>">
						</div>

						<div class="form-group">
							<label for="phone_number">Phone Number</label>
							<input type="text"
							       id="Phone_Number"
							       name="Phone_Number"
							       class="form-control"
							       placeholder="enter phone Number"
									value="<?php echo($User_Phone_Number);?>">
						</div>

						<div class="form-group">
							<label for="email">Email</label>
							<input type="email"
							       id="Email"
							       name="Email"
							       class="form-control"
							       placeholder="enter email"
								value="<?php echo($User_Email);?>">
						</div>

						<input type="hidden" name="User_Id" value="<?php echo($User_Id);?>">
						<input type="hidden" name="User_Type" value="<?php echo($User_Type)?>">
						<div class="col-lg-12" style="margin-top: 30px;">
							<input type="submit" value="Save"
							       class="btn btn-success btn-lg center_aligned" />
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>




<?php
require('IU_Footer.php');
?>
