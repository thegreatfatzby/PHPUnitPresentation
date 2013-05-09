<?php 

class WithDoublesTinytagTest extends PHPUnit_Framework_TestCase {
	
	protected static $db;
	
	protected $tinyTagModel;
	
	public static function setUpBeforeClass() {
		global $config;
		$db = new MysqlSimplePDO($config['hostname'], $config['username'], $config['password'], $config['database']);
		self::$db = $db;
	}
	
	public function setUp() {
		$this->tinyTagModel = new Model_Tinytag(
			self::$db, $this->getMock('Event_DispatcherInterface'),
			$this->getMock('Security_AclInterface'), $this->getMock('Security_AuthInterface')
		);
	}
	
	public function assertTinytagWithIdHasExpectedUrl($expectedUrl, $id)
	{
		$tinytag = $this->tinyTagModel->read($id);
		$this->assertInternalType('array', $tinytag);
		$this->assertArrayHasKey('url', $tinytag);
		$this->assertEquals($expectedUrl, $tinytag['url']);
	}
	
	public function testInsertSucceedsWithValidParameters() {
		$expectedUrl = 'http://www.appnexus.com';
		
		$newId = $this->tinyTagModel->create(array('url' => $expectedUrl));
		
		$this->assertInternalType('numeric', $newId);
		$this->assertTinytagWithIdHasExpectedUrl($expectedUrl, $newId);
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