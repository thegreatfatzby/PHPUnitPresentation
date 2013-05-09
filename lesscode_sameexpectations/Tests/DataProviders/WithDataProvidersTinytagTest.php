<?php 

class WithDataProvidersTinytagTest extends PHPUnit_Framework_TestCase {
	
	protected static $db;
	
	protected $tinyTagModel;
	
	public static function setUpBeforeClass() {
		global $config;
		$db = new MysqlSimplePDO($config['hostname'], $config['username'], $config['password'], $config['database']);
		self::$db = $db;
	}
	
	public function setUp() {
		$this->tinyTagModel = new Model_Tinytag(self::$db);
	}
	
	public function BadUrl_DataProvider() {
		return array(
			array(''), array('not a url'), array('www.appnexus.com')	
		);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 * @dataProvider BadUrl_DataProvider
	 */
	public function testCreateThrowsInvalidArgumentExceptionIfUrlIsBad($badUrl) {
		$this->tinyTagModel->create(array('url' => $badUrl));
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 * @dataProvider BadUrl_DataProvider
	 */
	public function testUpdateThrowsInvalidArgumentExceptionIfUrlIsBad($badUrl) {
		$this->tinyTagModel->update(12, array('url' => $badUrl));
	}
	
	public function MethodsThatTakeId_DataProvider() {
		return array(
			array('read'), array('update'), array('delete')
		);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 * @dataProvider MethodsThatTakeId_DataProvider
	 */
	public function testMethodThatTakesIdThrowsInvalidArgumentExceptionIfIdIsNonNumeric($method)
	{
		$this->tinyTagModel->$method('nan', array('url' => 'http://www.appnexus.com'));
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