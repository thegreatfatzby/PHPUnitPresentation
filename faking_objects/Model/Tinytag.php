<?php 

class Model_Tinytag
{
	
	protected $db;
	
	protected $acl;
	
	protected $eventDispatcher;
	
	protected $currentUserAuth;
	
	public function __construct(
		SimplePDO $dbHandle, Event_DispatcherInterface $eventDispatcher, 
		Security_AclInterface $acl, Security_AuthInterface $currentUserAuth
	)
	{
		$this->db = $dbHandle;
		$this->eventDispatcher = $eventDispatcher;
		$this->acl = $acl;
		$this->currentUserAuth = $currentUserAuth;
	}
	
	public function create(array $values)
	{
		$this->validateValues($values);
		if ($this->acl->isFieldGranted('Tinytag', 'url', 'write', $this->currentUserAuth) === false) {
			$this->eventDispatcher->dispatch('onAccessDenied', new Event_Event());
			throw new UnauthException("HALT!!!");
		}
		$columnsClause = '';
		$valuesClause = '';
		foreach ($values as $columnName => $value) {
			$columnsClause .= $columnName . ',';
			$valuesClause .= '"' . $value . '",';
		}
		$insertQuery = 'insert into phpunitdemo.tinytag (' . trim($columnsClause, ',') . ') values (' . trim($valuesClause, ',') . ') ';
		$this->executeQueryAndThrowOnFailure($insertQuery);
		$lastInsertIdResult = $this->getDb()->query('select last_insert_id() as DasId');
		if(!$lastInsertIdResult || count($lastInsertIdResult) != 1) {
			throw new RuntimeException("Failure getting id of newly inserted tinytag");
		}
		$this->eventDispatcher->dispatch('onNewTinytagCreated', new Event_Event());
		return $lastInsertIdResult[0]['DasId'];
	}
	
	public function update($id, array $values)
	{
		$this->validateNumericId($id);
		$this->validateValues($values);
		$setColumnValuesClause = '';
		foreach ($values as $columnName => $value) {
			$setColumnValuesClause .= $columnName . ' = "' . $value . '",';
		}
		$updateQuery = 'update phpunitdemo.tinytag set ' . trim($setColumnValuesClause, ',') . ' where id = ' . $id;
		$this->executeQueryAndThrowOnFailure($updateQuery);
		return true;
	}
	
	public function delete($id)
	{
		$this->validateNumericId($id);
		$deleteQuery = 'delete from phpunitdemo.tinytag where id = ' . $id;
		$this->executeQueryAndThrowOnFailure($deleteQuery);
		return true;
	}
	
	public function read($id)
	{
		$this->validateNumericId($id);
		$selectQuery = 'select * from phpunitdemo.tinytag where id = ' . $id;
		$result = $this->getDb()->query($selectQuery);
		return count($result) == 0 ? false : $result[0];
	}
	
	protected function executeQueryAndThrowOnFailure($query)
	{
		$db = $this->getDb();
		if (!$db->execute($query)) {
			throw new RuntimeException("Query failure, query was:\n$query\nError was: " . $db->lastError());
		}
	}
	
	protected function validateNumericId($id)
	{
		if (!is_numeric($id)) {
			throw new InvalidArgumentException("Bad id");
		}
	}
	
	protected function validateValues(array $values)
	{
		if (array_key_exists('url', $values)) {
			try {
				$urlObject = Zend_Uri_Http::fromString($values['url']);
			} catch (Exception $e) {
				throw new InvalidArgumentException("Bad url");
			}
		}
	}
	
	protected function getDb()
	{
		return $this->db;
	}
	
}