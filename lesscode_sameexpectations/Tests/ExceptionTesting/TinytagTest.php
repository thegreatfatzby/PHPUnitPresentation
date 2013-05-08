<?php 

class TinytagTest extends PHPUnit_Framework_TestCase {
	
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
	
	public function testCreateThrowsInvalidArgumentExceptionIfUrlIsBad() {
		try {
			$this->tinyTagModel->create(array('url' => ''));
		} catch (InvalidArgumentException $e) {
			return;
		}
		$this->fail("Excpected exception not thrown");
	}
	
	public function testUpdateThrowsInvalidArgumentExceptionIfUrlIsBlank() {
		try {
			$this->tinyTagModel->update(12, array('url' => ''));
		} catch (InvalidArgumentException $e) {
			return;
		}
		$this->fail("Excpected exception not thrown");
	}
	
	public function testUpdateThrowsInvalidArgumentExceptionIfUrlIsInvalidString() {
		try {
			$this->tinyTagModel->update(12, array('url' => 'not a url'));
		} catch (InvalidArgumentException $e) {
			return;
		}
		$this->fail("Excpected exception not thrown");
	}
	
	public function testUpdateThrowsInvalidArgumentExceptionIfUrlIsMissingProtocol() {
		try {
			$this->tinyTagModel->update(12, array('url' => 'www.appnexus.com'));
		} catch (InvalidArgumentException $e) {
			return;
		}
		$this->fail("Excpected exception not thrown");
	}
	
	public function testUpdateThrowsInvalidArgumentExceptionIfIdIsNonNumeric() {
		try {
			$this->tinyTagModel->update('nan', array('url' => 'http://www.appnexus.com'));
		} catch (InvalidArgumentException $e) {
			return;
		}
		$this->fail("Excpected exception not thrown");
	}
	
	public function testDeleteThrowsInvalidArgumentExceptionIfIdIsNonNumeric() {
		try {
			$this->tinyTagModel->delete('nan');
		} catch (InvalidArgumentException $e) {
			return;
		}
		$this->fail("Excpected exception not thrown");
	}
	
	public function testReadThrowsInvalidArgumentExceptionIfIdIsNonNumeric() {
		try {
			$this->tinyTagModel->read('nan');
		} catch (InvalidArgumentException $e) {
			return;
		}
		$this->fail("Excpected exception not thrown");
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