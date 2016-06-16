<?php


class SME_Controller extends User_Controller{


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
				    user as U ON U.Id = UO.Orderer_Id
						inner join
					order_status as OS on OS.Order_Id = O.Id
					where UO.Ordered_For_Id  = '$Current_User_Id'";

		$result = mysqli_query($this->getDbc(),$query);

		if($result){
			return $result;
		}
		return false;


	}

	/**
	 * @param $User_Id
	 * @param $Product_Id
	 * @return bool|mysqli_result
	 * adds the product type for an SME user
	 */
	function Add_Product_Type_To_List($User_Id,$Product_Id,$Product_Name,$Price){
		$query = "INSERT INTO user_product (User_Id,Product_Id,Name,Price) values('$User_Id','$Product_Id','$Product_Name','$Price')";
		$result = mysqli_query($this->getDbc(),$query);
		if($result){
			return TRUE;
		}
		return false;
	}

	/**
	 * @param $User_Id
	 * @param $Product_Id
	 * @return bool
	 * This will check if the user has already added the product
	 */
	function Check_Product_Exists($User_Id,$Product_Id){

		$query = "SELECT * FROM user_product where User_Id='$User_Id' AND Product_Id ='$Product_Id'";
		$result = mysqli_query($this->getDbc(),$query);
		if(mysqli_num_rows($result) >= 1){
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * @param $User_Product_Id
	 * @return bool
	 * delete the user_product relationship
	 */
	function Delete_User_Product($User_Product_Id){
		$query = "DELETE FROM user_product where Id = $User_Product_Id";
		$result = mysqli_query($this->getDbc(),$query);

		if($result){
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * @param $User_Id
	 * @param $Order_Id
	 * @return bool|mysqli_result
	 * this will fetch all data of a single order
	 */
	function Get_Single_Order($User_Id,$Order_Id){
		$query = "select
				O.Id as Order_Id,
				O.Product_Id as Product_Id,
				O.Amount as Amount,
				UO.Orderer_Id as Orderer_Id,
				UO.Ordered_For_Id as Ordered_For_Id,
				PT.Name as Product_Name,
				U.User_Name as User_Name,
				U.Id as Id,
				OS.Order_Status as Order_Status,
				UP.Address as Address,
				UP.Email as Email,
				UP.Phone_Number as Phone_Number
			from
				orders as O
					inner join
				user_order UO ON O.Id = UO.Order_Id
					inner join
				product_type as PT ON O.Product_Id = PT.Id
					inner join
				user as U ON U.Id = UO.Orderer_Id
					inner join
				user_profile as UP on U.Id = UP.Id
					inner join
				order_status as OS on OS.Order_Id = O.Id
				where UO.Ordered_For_Id  = '$User_Id' and O.Id = '$Order_Id'";

		$result = mysqli_query($this->getDbc(),$query);

		if($result){
			return $result;
		}
		return false;
	}

	/**
	 * @param $Order_Id
	 * @return bool
	 * this function will change the order from rejected to accepted
	 */
	function Accept_Order($Order_Id){
		$query = "update order_status set Order_Status = 1  where Order_Id  ='$Order_Id'";
		$result = mysqli_query($this->getDbc(),$query);
		if($result){
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * @param $Order_Id
	 * @return bool
	 * this function
	 */
	function Reject_Order($Order_Id){
		$query = "update order_status set Order_Status = 0  where Order_Id  ='$Order_Id'";
		$result = mysqli_query($this->getDbc(),$query);
		if($result){
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * @param Bid_Offer $bid_Offer
	 * @return bool|mysqli_result
	 * This function will add an SME to participate on a bid
	 */
	function Participate_On_Bid(Bid_Offer $bid_Offer){
		$User_Id = $bid_Offer->getUserId();
		$Bid_Id = $bid_Offer->getBidId();
		$Bid_Amount = $bid_Offer->getBidAmount();
		$query = "INSERT INTO user_bid (User_Id,Bid_Id,Bid_Amount) VALUES ('$User_Id','$Bid_Id','$Bid_Amount')";
		$result = mysqli_query($this->getDbc(),$query);
		if($result){
			return $result;
		}
		return false;
	}

	/**
	 * @param $User_Id
	 * @param $Bid_Id
	 * @return bool
	 * Checks if the user is participating on the bid
	 */
	function Check_Participating($User_Id,$Bid_Id){
		$query = "select * from user_bid where User_Id = '$User_Id' and Bid_Id = '$Bid_Id'";

		$result = mysqli_query($this->getDbc(),$query);

		 if(mysqli_num_rows($result) >= 1){
			 return TRUE;
		 }return FALSE;
	}

	/**
	 * @param $User_Id
	 * @return bool|mysqli_result
	 * this function will return the bids the user is participating
	 */
	function Get_Participating_bids($User_Id){
		$query = "select
				    B.Name as Bid_Name,
					B.Description as Bid_Description,
					B.Status as Status,
					B.Opened_On as Opened_On,
					B.Closed_On as Closed_On,
					UB.Bid_Amount as Amount,
					UB.User_Id as User_Id,
					UB.Bid_Amount as Amount
				from
				    bid as B
				        inner join
				    user_bid as UB ON B.Id = UB.Bid_Id
					where UB.User_Id = '$User_Id'";

		$result = mysqli_query($this->getDbc(),$query);

		if($result){
			return $result;
		}
		return false;
	}


}



