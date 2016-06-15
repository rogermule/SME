<?php
	require('Require.php');
	$user = $_SESSION['Logged_In_User'];
	$User_Id  = $user->getUserID();
$SME_Name = $user->getUserName();
	$SME_Con = new SME_Controller($user);
	$user_name_for_header = $user->getUserName();
	require('SME_Header.php');
	require('SME_Menu.html');
	if($_SERVER['REQUEST_METHOD'] == "GET") {

		$User_Id = $_GET['User_Id'];
		$Order_Id = $_GET['Order_Id'];
		$Single_Order = $SME_Con->Get_Single_Order($User_Id,$Order_Id);
		$single_order = mysqli_fetch_array($Single_Order);
		$User_Name = $single_order['User_Name'];
		$Address = $single_order['Address'];
		$Email = $single_order['Email'];
		$Product_Name = $single_order['Product_Name'];
		$Phone_Number = $single_order['Phone_Number'];
		$Status = $single_order['Order_Status'];
		$Amount = $single_order['Amount'];
		$Orderer_Id = $single_order['Orderer_Id'];
	}
?>

<div class="col-sm-8 col-sm-offset-1 margin_top_51 list_container">

	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-body text-center">
				<h4>Manage Order (Profile Of the Order Maker!)</h4>
			</div>
		</div>

		<div class=" margin_top_20">
			 <div class="col-sm-4 col-sm-offset-4"  >
					<p>Order From      ---- <?php echo($User_Name);?></p>
					<P>Address         ---- <?php echo($Address);?></P>
					<p>Product Name    ---- <?php echo($Product_Name);?></p>
					<p>Email           ----- <?php echo($Email);?></p>
					<p>phone Number    ------<?php echo($Phone_Number);?></p>
					<P>Status --- <?php if($Status == 1){echo("Accepted");}
						else if($Status == 0){echo("Not Accepted");}?>
					</P>
					<?php
					if($Status == 1){
						?>
						<a href="../../../CONTROLLER/SME_Reject.php?Order_Id=<?php echo($Order_Id);?>" class="btn btn-info btn-block" type="submit">Reject</a>
				<?php
					}else if($Status == 0){
						?>
						<form action="../../../CONTROLLER/SME_Accept.php" method="POST">
							<input type="hidden" name="User_Name" value="<?php echo($SME_Name);?>">
							<input type="hidden" name="Amount" value="<?php echo($Amount);?>">
							<input type="hidden" name="Product_Name" value="<?php echo($Product_Name);?>">
							<input type="hidden" name="Orderer_Id" value="<?php echo($Orderer_Id);?>">
							<input type="hidden" name="Order_Id" value="<?php echo($Order_Id)?>">
							<button class="btn btn-info btn-block">Accept Order</button>
						</form>
					<?php } ?>
					<a href="Index.php" class="btn btn-success btn-block margin-t-b-20">Cancel</a>
				</div>




		</div>


	</div>



</div>

<?php
require('SME_Footer.php');
?>

