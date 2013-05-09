<?php 

class MysqlSimplePDO implements SimplePDO
{
	
	protected $mysqli;
	
	public function __construct($host, $user, $pass, $db)
	{
		$this->mysqli = new mysqli($host, $user, $pass, $db);
	}
	
	public function execute($query)
	{
		return $this->getMysqli()->query($query);
	}
	
	public function query($query)
	{
		$r = $this->getMysqli()->query($query);
		if (!$r) {
			return false;
		}
		$arrayResults = array();
		while ($row = $r->fetch_assoc()) {
			$arrayResults[] = $row;
		}
		return $arrayResults;
	}
	
	public function lastError()
	{
		return $this->getMysqli()->error;
	}
	
	protected function getMysqli()
	{
		return $this->mysqli;
	}
	
}