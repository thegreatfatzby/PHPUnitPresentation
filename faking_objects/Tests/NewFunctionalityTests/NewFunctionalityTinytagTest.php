<?php 

class WithDoublesTinytagTest extends PHPUnit_Framework_TestCase {
	
	protected static $db;
	
	protected $tinyTagModel;
	
	protected $aclStub;
	
	protected $authStub;
	
	protected $dispatcherMock;
	
	public static function setUpBeforeClass() {
		global $config;
		$db = new MysqlSimplePDO($config['hostname'], $config['username'], $config['password'], $config['database']);
		self::$db = $db;
	}
	
	public function setUp() {
		$this->dispatcherMock = $this->getMock('Event_DispatcherInterface');
		$this->aclStub = $this->getMock('Security_AclInterface');
		$this->authStub = $this->getMock('Security_AuthInterface');
		$this->tinyTagModel = new Model_Tinytag(self::$db, $this->dispatcherMock, $this->aclStub, $this->authStub);
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
	
	/**
	 * @expectedException UnauthException
	 */
	public function testUnauthExceptionIsThrownIfUserIsntAllowedAccessToField()
	{
		$this->aclStub->expects($this->any())->method('isFieldGranted')->will($this->returnValue(false));
		
		$this->tinyTagModel->create(array('url' => 'http://www.appnexus.com'));
	}
	
	public function testEventDispatcherFiresOnSuccessMethodWhenNewTinytagCreated()
	{
		$this->dispatcherMock->expects($this->once())->method('dispatch')->with($this->equalTo('onNewTinytagCreated'));
		
		$this->tinyTagModel->create(array('url' => 'http://www.appnexus.com'));
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