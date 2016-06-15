<?php


class Order{
	private $product_ID;
	private $amount;
	private $orderer_ID;
	private $ordered_for_ID;

	function __construct($product_ID,$amount,$orderer_ID,$ordered_for_ID){

		$this->product_ID = $product_ID;
		$this->amount = $amount;
		$this->orderer_ID = $orderer_ID;
		$this->ordered_for_ID = $ordered_for_ID;

	}

	/**
	 * @return mixed
	 */
	public function getProductID()
	{
		return $this->product_ID;
	}

	/**
	 * @param mixed $product_ID
	 */
	public function setProductID($product_ID)
	{
		$this->product_ID = $product_ID;
	}

	/**
	 * @return mixed
	 */
	public function getAmount()
	{
		return $this->amount;
	}

	/**
	 * @param mixed $amount
	 */
	public function setAmount($amount)
	{
		$this->amount = $amount;
	}

	/**
	 * @return mixed
	 */
	public function getOrdererID()
	{
		return $this->orderer_ID;
	}

	/**
	 * @param mixed $orderer_ID
	 */
	public function setOrdererID($orderer_ID)
	{
		$this->orderer_ID = $orderer_ID;
	}

	/**
	 * @return mixed
	 */
	public function getOrderedForID()
	{
		return $this->ordered_for_ID;
	}

	/**
	 * @param mixed $ordered_for_ID
	 */
	public function setOrderedForID($ordered_for_ID)
	{
		$this->ordered_for_ID = $ordered_for_ID;
	}


}