<?php 

class WithExpectedExceptionTinytagTest extends PHPUnit_Framework_TestCase {
	
	protected static $db;
	
	protected $tinyTagModel;
	
	public static function setUpBeforeClass()
	{
		global $config;
		$db = new MysqlSimplePDO($config['hostname'], $config['username'], $config['password'], $config['database']);
		self::$db = $db;
	}
	
	public function setUp()
	{
		$this->tinyTagModel = new Model_Tinytag(self::$db);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCreateThrowsInvalidArgumentExceptionIfUrlIsBad() {
		$this->tinyTagModel->create(array('url' => ''));
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testUpdateThrowsInvalidArgumentExceptionIfUrlIsBlank() {
		$this->tinyTagModel->update(12, array('url' => ''));
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testUpdateThrowsInvalidArgumentExceptionIfUrlIsInvalidString() {
		$this->tinyTagModel->update(12, array('url' => 'not a url'));
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testUpdateThrowsInvalidArgumentExceptionIfUrlIsMissingProtocol() {
		$this->tinyTagModel->update(12, array('url' => 'www.appnexus.com'));
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testUpdateThrowsInvalidArgumentExceptionIfIdIsNonNumeric() {
		$this->tinyTagModel->update('nan', array('url' => 'http://www.appnexus.com'));
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testDeleteThrowsInvalidArgumentExceptionIfIdIsNonNumeric() {
		$this->tinyTagModel->delete('nan');
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testReadThrowsInvalidArgumentExceptionIfIdIsNonNumeric() {
		$this->tinyTagModel->read('nan');
	}
	
	public function testInsertSucceedsWithValidParameters() {
		$expectedUrl = 'http://www.appnexus.com';
		
		$newId = $this->tinyTagModel->create(array('url' => $expectedUrl));
		
		$this->assertInternalType('numeric', $newId);
		$tinytag = $this->tinyTagModel->read($newId);
		$this->assertInternalType('array', $tinytag);
		$this->assertArrayHasKey('url', $tinytag);
		$this->assertEquals($expectedUrl, $tinytag['url']);
	}
	
	public function testUpdateSucceedsWithValidParameters() {
		$expectedUrl = 'http://www.appnexus.com';
		$newId = $this->tinyTagModel->create(array('url' => 'http://www.google.com'));
		$this->assertInternalType('numeric', $newId);
		
		$this->tinyTagModel->update($newId, array('url' => $expectedUrl));
		
		$tinytag = $this->tinyTagModel->read($newId);
		$this->assertInternalType('array', $tinytag);
		$this->assertArrayHasKey('url', $tinytag);
		$this->assertEquals($expectedUrl, $tinytag['url']);
	}
	
	public function testDeleteSucceeds() {
		$newId = $this->tinyTagModel->create(array('url' => 'http://www.google.com'));
		$this->assertInternalType('numeric', $newId);
		
		$this->assertTrue($this->tinyTagModel->delete($newId));
		
		$this->assertFalse($this->tinyTagModel->read($newId));
	}
	
	public function testUpdateThrowsRuntimeExceptionIfQueryFails() {
		$this->markTestIncomplete("How can we test this?");
	}
	
	public function testCreateThrowsRuntimeExceptionIfQueryFails() {
		$this->markTestIncomplete("How can we test this?");
	}
	
	public function testDeleteThrowsRuntimeExceptionIfQueryFails() {
		$this->markTestIncomplete("How can we test this?");
	}
	
	public function testReadThrowsRuntimeExceptionIfQueryFails() {
		$this->markTestIncomplete("How can we test this?");
	}
	
}