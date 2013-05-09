<?php 

class Security_Auth implements Security_AuthInterface
{
	
	protected $userId;
	
	protected $roles;
	
	public function __construct($userId, array $roles)
	{
		$this->userId = $userId;
		$this->roles = $roles;
	}
	
	public function getUserId()
	{
		return $this->userId;
	}
	
	public function getRoles()
	{
		return $this->roles;
	}
	
}