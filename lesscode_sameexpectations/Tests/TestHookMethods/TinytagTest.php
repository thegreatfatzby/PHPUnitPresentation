<?php 

class TinytagTest extends PHPUnit_Framework_TestCase {
	
	public function testCreateThrowsInvalidArgumentExceptionIfUrlIsBad() {
		global $config;
		$db = new MysqlSimplePDO($config['hostname'], $config['username'], $config['password'], $config['database']);
		$tinyTagModel = new Model_Tinytag($db);
		
		try {
			$tinyTagModel->create(array('url' => ''));
		} catch (InvalidArgumentException $e) {
			return;
		}
		$this->fail("Excpected exception not thrown");
	}
	
	public function testUpdateThrowsInvalidArgumentExceptionIfUrlIsBlank() {
		global $config;
		$db = new MysqlSimplePDO($config['hostname'], $config['username'], $config['password'], $config['database']);
		$tinyTagModel = new Model_Tinytag($db);
		
		try {
			$tinyTagModel->update(12, array('url' => ''));
		} catch (InvalidArgumentException $e) {
			return;
		}
		$this->fail("Excpected exception not thrown");
	}
	
	public function testUpdateThrowsInvalidArgumentExceptionIfUrlIsInvalidString() {
		global $config;
		$db = new MysqlSimplePDO($config['hostname'], $config['username'], $config['password'], $config['database']);
		$tinyTagModel = new Model_Tinytag($db);
		
		try {
			$tinyTagModel->update(12, array('url' => 'not a url'));
		} catch (InvalidArgumentException $e) {
			return;
		}
		$this->fail("Excpected exception not thrown");
	}
	
	public function testUpdateThrowsInvalidArgumentExceptionIfUrlIsMissingProtocol() {
		global $config;
		$db = new MysqlSimplePDO($config['hostname'], $config['username'], $config['password'], $config['database']);
		$tinyTagModel = new Model_Tinytag($db);
		
		try {
			$tinyTagModel->update(12, array('url' => 'www.appnexus.com'));
		} catch (InvalidArgumentException $e) {
			return;
		}
		$this->fail("Excpected exception not thrown");
	}
	
	public function testUpdateThrowsInvalidArgumentExceptionIfIdIsNonNumeric() {
		global $config;
		$db = new MysqlSimplePDO($config['hostname'], $config['username'], $config['password'], $config['database']);
		$tinyTagModel = new Model_Tinytag($db);
		
		try {
			$tinyTagModel->update('nan', array('url' => 'http://www.appnexus.com'));
		} catch (InvalidArgumentException $e) {
			return;
		}
		$this->fail("Excpected exception not thrown");
	}
	
	public function testDeleteThrowsInvalidArgumentExceptionIfIdIsNonNumeric() {
		global $config;
		$db = new MysqlSimplePDO($config['hostname'], $config['username'], $config['password'], $config['database']);
		$tinyTagModel = new Model_Tinytag($db);
		
		try {
			$tinyTagModel->delete('nan');
		} catch (InvalidArgumentException $e) {
			return;
		}
		$this->fail("Excpected exception not thrown");
	}
	
	public function testReadThrowsInvalidArgumentExceptionIfIdIsNonNumeric() {
		global $config;
		$db = new MysqlSimplePDO($config['hostname'], $config['username'], $config['password'], $config['database']);
		$tinyTagModel = new Model_Tinytag($db);
		
		try {
			$tinyTagModel->read('nan');
		} catch (InvalidArgumentException $e) {
			return;
		}
		$this->fail("Excpected exception not thrown");
	}
	
	public function testInsertSucceedsWithValidParameters() {
		global $config;
		$db = new MysqlSimplePDO($config['hostname'], $config['username'], $config['password'], $config['database']);
		$tinyTagModel = new Model_Tinytag($db);
		$expectedUrl = 'http://www.appnexus.com';
		
		$newId = $tinyTagModel->create(array('url' => $expectedUrl));
		
		$this->assertInternalType('numeric', $newId);
		$tinytag = $tinyTagModel->read($newId);
		$this->assertInternalType('array', $tinytag);
		$this->assertArrayHasKey('url', $tinytag);
		$this->assertEquals($expectedUrl, $tinytag['url']);
	}
	
	public function testUpdateSucceedsWithValidParameters() {
		global $config;
		$db = new MysqlSimplePDO($config['hostname'], $config['username'], $config['password'], $config['database']);
		$tinyTagModel = new Model_Tinytag($db);
		$expectedUrl = 'http://www.appnexus.com';
		$newId = $tinyTagModel->create(array('url' => 'http://www.google.com'));
		$this->assertInternalType('numeric', $newId);
		
		$tinyTagModel->update($newId, array('url' => $expectedUrl));
		
		$tinytag = $tinyTagModel->read($newId);
		$this->assertInternalType('array', $tinytag);
		$this->assertArrayHasKey('url', $tinytag);
		$this->assertEquals($expectedUrl, $tinytag['url']);
	}
	
	public function testDeleteSucceeds() {
		global $config;
		$db = new MysqlSimplePDO($config['hostname'], $config['username'], $config['password'], $config['database']);
		$tinyTagModel = new Model_Tinytag($db);
		$newId = $tinyTagModel->create(array('url' => 'http://www.google.com'));
		$this->assertInternalType('numeric', $newId);
		
		$this->assertTrue($tinyTagModel->delete($newId));
		
		$this->assertFalse($tinyTagModel->read($newId));
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