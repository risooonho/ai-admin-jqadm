<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018
 */


namespace Aimeos\Admin\JQAdm\Subscription;


class StandardTest extends \PHPUnit\Framework\TestCase
{
	private $context;
	private $object;
	private $view;


	protected function setUp()
	{
		$this->view = \TestHelperJqadm::getView();
		$this->context = \TestHelperJqadm::getContext();

		$this->object = new \Aimeos\Admin\JQAdm\Subscription\Standard( $this->context );
		$this->object = new \Aimeos\Admin\JQAdm\Common\Decorator\Page( $this->object, $this->context );
		$this->object->setAimeos( \TestHelperJqadm::getAimeos() );
		$this->object->setView( $this->view );
	}


	protected function tearDown()
	{
		unset( $this->object, $this->view, $this->context );
	}


	public function testCreate()
	{
		$this->object->create();
	}


	public function testCreateException()
	{
		$object = $this->getClientMock( 'getSubClients' );

		$object->expects( $this->once() )->method( 'getSubClients' )
			->will( $this->throwException( new \RuntimeException() ) );

		$object->create();
	}


	public function testCreateMShopException()
	{
		$object = $this->getClientMock( 'getSubClients' );

		$object->expects( $this->once() )->method( 'getSubClients' )
			->will( $this->throwException( new \Aimeos\MShop\Exception() ) );

		$object->create();
	}


	public function testCopy()
	{
		$manager = \Aimeos\MShop\Factory::createManager( $this->context, 'subscription' );

		$param = ['site' => 'unittest', 'id' => $this->getSubscriptionId()];
		$helper = new \Aimeos\MW\View\Helper\Param\Standard( $this->view, $param );
		$this->view->addHelper( 'param', $helper );

		$result = $this->object->copy();

		$this->assertContains( '2010-01-01 00:00:00', $result );
	}


	public function testCopyException()
	{
		$object = $this->getClientMock( 'getSubClients' );

		$object->expects( $this->once() )->method( 'getSubClients' )
			->will( $this->throwException( new \RuntimeException() ) );

		$object->copy();
	}


	public function testCopyMShopException()
	{
		$object = $this->getClientMock( 'getSubClients' );

		$object->expects( $this->once() )->method( 'getSubClients' )
			->will( $this->throwException( new \Aimeos\MShop\Exception() ) );

		$object->copy();
	}


	public function testDelete()
	{
		$this->assertNotNull( $this->object->delete() );
	}


	public function testDeleteException()
	{
		$object = $this->getClientMock( 'getSubClients' );

		$object->expects( $this->exactly( 2 ) )->method( 'getSubClients' )
			->will( $this->throwException( new \RuntimeException() ) );

		$object->delete();
	}


	public function testDeleteMShopException()
	{
		$object = $this->getClientMock( 'getSubClients' );

		$object->expects( $this->exactly( 2 ) )->method( 'getSubClients' )
			->will( $this->throwException( new \Aimeos\MShop\Exception() ) );

		$object->delete();
	}


	public function testGet()
	{
		$manager = \Aimeos\MShop\Factory::createManager( $this->context, 'subscription' );

		$param = ['site' => 'unittest', 'id' => $this->getSubscriptionId()];
		$helper = new \Aimeos\MW\View\Helper\Param\Standard( $this->view, $param );
		$this->view->addHelper( 'param', $helper );

		$result = $this->object->get();

		$this->assertContains( '2010-01-01 00:00:00', $result );
	}


	public function testGetException()
	{
		$object = $this->getClientMock( 'getSubClients' );

		$object->expects( $this->once() )->method( 'getSubClients' )
			->will( $this->throwException( new \RuntimeException() ) );

		$object->get();
	}


	public function testGetMShopException()
	{
		$object = $this->getClientMock( 'getSubClients' );

		$object->expects( $this->once() )->method( 'getSubClients' )
			->will( $this->throwException( new \Aimeos\MShop\Exception() ) );

		$object->get();
	}


	public function testGetViewException()
	{
		$object = new \Aimeos\Admin\JQAdm\Subscription\Standard( $this->context, [] );

		$this->setExpectedException( '\Aimeos\Admin\JQAdm\Exception' );
		$object->getView();
	}


	public function testSave()
	{
		$manager = \Aimeos\MShop\Factory::createManager( $this->context, 'subscription' );

		$param = array(
			'site' => 'unittest',
			'item' => array(
				'subscription.id' => '',
				'subscription.ordbaseid' => '12',
				'subscription.ordprodid' => '123',
				'subscription.interval' => 'P100Y100M100W100D',
				'subscription.datenext' => '2005-05-05 05:05:05',
				'subscription.dateend' => '2006-06-06 06:06:06',
				'subscription.status' => '1',
			),
		);

		$helper = new \Aimeos\MW\View\Helper\Param\Standard( $this->view, $param );
		$this->view->addHelper( 'param', $helper );

		$this->object->save();

		$manager->deleteItem( $this->getSubscriptionId( '2006-06-06 06:06:06' ) );
	}


	public function testSaveException()
	{
		$object = $this->getClientMock( 'fromArray' );

		$object->expects( $this->once() )->method( 'fromArray' )
			->will( $this->throwException( new \RuntimeException() ) );

		$object->save();
	}


	public function testSaveMShopException()
	{
		$object = $this->getClientMock( 'fromArray' );

		$object->expects( $this->once() )->method( 'fromArray' )
			->will( $this->throwException( new \RuntimeException() ) );

		$object->save();
	}


	public function testSaveJQAdmException()
	{
		$object = $this->getClientMock( 'fromArray' );

		$object->expects( $this->once() )->method( 'fromArray' )
			->will( $this->throwException( new \RuntimeException() ) );

		$object->save();
	}


	public function testSearch()
	{
		$param = array(
			'site' => 'unittest', 'lang' => 'de',
			'filter' => array(
				'key' => array( 0 => 'subscription.dateend' ),
				'op' => array( 0 => '>=' ),
				'val' => array( 0 => '2010-01-01 00:00:00' ),
			),
			'sort' => array( 'subscription.datenext', '-subscription.id' ),
		);
		$helper = new \Aimeos\MW\View\Helper\Param\Standard( $this->view, $param );
		$this->view->addHelper( 'param', $helper );

		$result = $this->object->search();

		$this->assertContains( '2010-01-01 00:00:00', $result );
	}


	public function testSearchException()
	{
		$object = $this->getClientMock( 'initCriteria' );

		$object->expects( $this->once() )->method( 'initCriteria' )
			->will( $this->throwException( new \RuntimeException() ) );

		$object->search();
	}


	public function testSearchMShopException()
	{
		$object = $this->getClientMock( 'initCriteria' );

		$object->expects( $this->once() )->method( 'initCriteria' )
			->will( $this->throwException( new \Aimeos\MShop\Exception() ) );

		$object->search();
	}


	public function testGetSubClientInvalid()
	{
		$this->setExpectedException( '\Aimeos\Admin\JQAdm\Exception' );
		$this->object->getSubClient( '$unknown$' );
	}


	public function testGetSubClientUnknown()
	{
		$this->setExpectedException( '\Aimeos\Admin\JQAdm\Exception' );
		$this->object->getSubClient( 'unknown' );
	}


	public function getClientMock( $method )
	{
		$object = $this->getMockBuilder( '\Aimeos\Admin\JQAdm\Subscription\Standard' )
			->setConstructorArgs( array( $this->context, \TestHelperJqadm::getTemplatePaths() ) )
			->setMethods( [$method] )
			->getMock();

		$object->setAimeos( \TestHelperJqadm::getAimeos() );
		$object->setView( $this->getViewNoRender() );

		return $object;
	}


	protected function getViewNoRender()
	{
		$view = $this->getMockBuilder( '\Aimeos\MW\View\Standard' )
			->setConstructorArgs( array( [] ) )
			->setMethods( array( 'render', 'config' ) )
			->getMock();

		$manager = \Aimeos\MShop\Factory::createManager( $this->context, 'subscription' );

		$param = ['site' => 'unittest', 'id' => $this->getSubscriptionId()];
		$helper = new \Aimeos\MW\View\Helper\Param\Standard( $view, $param );
		$view->addHelper( 'param', $helper );

		$helper = new \Aimeos\MW\View\Helper\Access\Standard( $view, [] );
		$view->addHelper( 'access', $helper );

		return $view;
	}


	protected function getSubscriptionId( $end = '2010-01-01 00:00:00' )
	{
		$manager = \Aimeos\MShop\Factory::createManager( $this->context, 'subscription' );
		$search = $manager->createSearch()->setSlice( 0, 1 );
		$search->setConditions( $search->compare( '==', 'subscription.dateend', $end ) );
		$items = $manager->searchItems( $search );

		if( ( $item = reset( $items ) ) === false ) {
			throw new \Exception( sprintf( 'No subscription item found for end date "%1$s"', $end ) );
		}

		return $item->getId();
	}
}