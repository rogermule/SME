<?php


class Bid_Offer{
	private $Bid_Id;
	private $User_Id;
	private $Bid_Amount;

	function __construct($Bid_Id,$User_Id,$Bid_Amount){
		$this->Bid_Id = $Bid_Id;
		$this->User_Id =$User_Id;
		$this->Bid_Amount = $Bid_Amount;
	}

	/**
	 * @return mixed
	 */
	public function getBidId()
	{
		return $this->Bid_Id;
	}

	/**
	 * @param mixed $Bid_Id
	 */
	public function setBidId($Bid_Id)
	{
		$this->Bid_Id = $Bid_Id;
	}

	/**
	 * @return mixed
	 */
	public function getUserId()
	{
		return $this->User_Id;
	}

	/**
	 * @param mixed $User_Id
	 */
	public function setUserId($User_Id)
	{
		$this->User_Id = $User_Id;
	}

	/**
	 * @return mixed
	 */
	public function getBidAmount()
	{
		return $this->Bid_Amount;
	}

	/**
	 * @param mixed $Bid_Amount
	 */
	public function setBidAmount($Bid_Amount)
	{
		$this->Bid_Amount = $Bid_Amount;
	}


}