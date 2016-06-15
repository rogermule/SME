<?php
/**
 * Created by PhpStorm.
 * User: Natnael Zeleke
 * Date: 6/12/2016
 * Time: 6:33 AM
 */

?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<title></title>
	<link href="../../css/bootstrap.min.css" rel="stylesheet">
	<link href="../../css/custome_common.css" rel="stylesheet">
	<link href="../../css/Admin.css" rel="stylesheet">
</head>
<body class="back_ground_addis">

<div class="container  margin_top_70">

	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<a class="navbar-brand white active">Micro Enterprise System</a>
		<p class="navbar-text white">We serve any thing related to micro enterprise.</p>
		<ul class="nav navbar-nav navbar-right">
			<li class="nav active"><a href="about.html">About</a></li>
		</ul>
	</div>


	<div class="margin_top_20">

		<div class="col-lg-6 col-sm-offset-3">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h2 class="text-center">Micro-Enterprise System</h2>
					<h4 class="text-center">Sign up</h4>
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
					<div class="col-lg-10 col-lg-offset-1">
						<form action="../../../CONTROLLER/SignUp.php" method="POST">

							<div class="form-group">
								<label for="user_name">Name</label>
								<input type="text"
								       id="Name"
								       name="Name"
								       class="form-control"
								       placeholder="enter user name "/>
							</div>

							<div class="form-group">
								<label for="password">Password</label>
								<input type="password"
								       id="Password"
								       name="Password"
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
								       placeholder="Enter Address">
							</div>

							<div class="form-group">
								<label for="phone_number">Phone Number</label>
								<input type="text"
								       id="Phone_Number"
								       name="Phone_Number"
								       class="form-control"
								       placeholder="enter phone Number">
							</div>

							<div class="form-group">
								<label for="email">Email</label>
								<input type="email"
								       id="Email"
								       name="Email"
								       class="form-control"
								       placeholder="enter email">
							</div>


							<div class="form-group">
								<div>
									<label >Account Type</label>
								</div>
								<div class="col-sm-11">

									<div class="col-sm-6">
										<input name="User_Type"
										       class="col-sm-1" type="radio" id="IU" value="IU" >
										<label for="IU" class="user_types">Individual User</label>
									</div>
									<div class="col-sm-6">

										<input name="User_Type" class="col-sm-1" type="radio" id="SME" value="SME" >
										<label for="SME" class="user_types">SME</label>
									</div>

								</div>
							</div>

							<div class="col-lg-12" style="margin-top: 30px;">
								<input type="submit" value="SignUp"
								       class="btn btn-success btn-lg center_aligned" />
							</div>

						</form>
					</div>
				</div>
				<div class="col-lg-12">
					<br>
					<p class="text-center"> If you already have an account, you can <a
							href="Login.php" class="btn btn-info btn-sm">Login</a>
					</p><br>
				</div>
			</div>
		</div>

	</div>
</div>

<script src="../../js/jquery.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>

</body>
</html>
