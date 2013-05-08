<?php 

interface SimplePDO
{
	
	/**
	 * Executes an SQL statement, returning a result set as an array of associative arrays.
	 * 
	 * @param string $query
	 * @return array|false array of associative arrays on success, false on failure.
	 */
	public function query($query);
	
	/**
	 * Execute an SQL statement and return the number of affected rows
	 * 
	 * @param string $query
	 * @return boolean true on success, false on failure
	 */
	public function execute($query);
	
	/**
	 * Get the last error
	 * 
	 * @return string
	 */
	public function lastError();
	
}