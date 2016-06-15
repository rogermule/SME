<?php
/**
 * Created by PhpStorm.
 * User: Natnael Zeleke
 * Date: 6/13/2016
 * Time: 7:15 PM
 */

class Notification{

	private $Action;
	private $Belongs_To;//This is the Id of the user which the notification belongs to

	function __construct($Action,$Belongs_To = null){
		$this->Action = $Action;
		if($Belongs_To != null){
			$this->Belongs_To = $Belongs_To;
		}
	}

	/**
	 * @return mixed
	 */
	public function getAction()
	{
		return $this->Action;
	}

	/**
	 * @param mixed $Action
	 */
	public function setAction($Action)
	{
		$this->Action = $Action;
	}

	/**
	 * @return mixed
	 */
	public function getBelongsTo()
	{
		return $this->Belongs_To;
	}

	/**
	 * @param mixed $Belongs_To
	 */
	public function setBelongsTo($Belongs_To)
	{
		$this->Belongs_To = $Belongs_To;
	}




}