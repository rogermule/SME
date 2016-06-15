<?php

class IU_Controller extends User_Controller{


	/**
	 * @param Order $order
	 * @return bool
	 * this will add an order to the database
	 */
	function MakeOrder(Order $order){

		$Product_ID = $order->getProductID();
		$Amount = $order->getAmount();
		$Orderer_Id = $order->getOrdererID();
		$Ordered_For_ID = $order->getOrderedForID();


		//start the transaction
		$query0 = "START TRANSACTION";
		$result0 = mysqli_query($this->getDbc(),$query0);

		$query1 = "INSERT INTO orders (Product_Id,Amount) VALUE ('$Product_ID','$Amount')";
		$result1 = mysqli_query($this->getDbc(),$query1);

		//get the ID of the registered order
		$Order_ID = $this->getDb()->get_last_id();
		$query2 = "INSERT INTO user_order (Order_Id,Orderer_Id,Ordered_For_Id) VALUE ('$Order_ID','$Orderer_Id','$Ordered_For_ID')";
		$result2 = mysqli_query($this->getDbc(),$query2);

		/**
		 * add to the order status a zero which is not accepted
		 */
		$query3 = "INSERT INTO order_status (Order_Id,Order_Status) values ('$Order_ID','0')";
		$result3 = mysqli_query($this->getDbc(),$query3);

		if($result0 AND $result1 AND $result2 AND $result3){
			$query4 = "COMMIT";
			mysqli_query($this->getDbc(),$query4);
			return TRUE;
		}
		else{
			$query_roll = "ROLLBACK";
			mysqli_query($this->getDbc(),$query_roll);
			echo("Rolled back");
			return FALSE;
		}


	}



	/**
	 * @param $query_text
	 * @return bool|mysqli_result
	 * this function will search SME companies
	 */
	function SearchSME($query_text){
		$query = "select * from user where User_Type='SME' and User_Name LIKE '%$query_text%'";
		$result = mysqli_query($this->getDbc(),$query);

		if($result){
			return $result;
		}
		return false;
	}


	/**
	 * @param $Current_User_Id
	 * @return bool|mysqli_result
	 * returns the orders the IU made
	 */
	function Get_All_Orders($Current_User_Id){

		$query = "select
				    O.Id as Order_Id,
				    O.Product_Id as Product_Id,
				    O.Amount as Amount,
				    UO.Orderer_Id as Orderer_Id,
				    UO.Ordered_For_Id as Ordered_For_Id,
				    PT.Name as Product_Name,
				    U.User_Name as User_Name,
					U.Id as Id,
					OS.Order_Status as Order_Status
				from
				    orders as O
				        inner join
				    user_order UO ON O.Id = UO.Order_Id
				        inner join
				    product_type as PT ON O.Product_Id = PT.Id
				        inner join
				    user as U ON U.Id = UO.Ordered_For_Id
						inner join
					order_status as OS on OS.Order_Id = O.Id
					where UO.Orderer_Id  = '$Current_User_Id'";

		$result = mysqli_query($this->getDbc(),$query);

		if($result){
			return $result;
		}
		return false;


	}



}