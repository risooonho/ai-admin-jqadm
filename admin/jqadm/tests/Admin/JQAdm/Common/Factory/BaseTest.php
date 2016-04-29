<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016
 */


namespace Aimeos\Admin\JQAdm\Common\Factory;


class BaseTest extends \PHPUnit_Framework_TestCase
{
	private $context;


	protected function setUp()
	{
		$this->context = \TestHelperJqadm::getContext();
		$this->context->setView( \TestHelperJqadm::getView() );

		$config = $this->context->getConfig();
		$config->set( 'admin/jqadm/common/decorators/default', array() );
		$config->set( 'admin/jqadm/decorators/global', array() );
		$config->set( 'admin/jqadm/decorators/local', array() );

	}


	public function testInjectClient()
	{
		$client = \Aimeos\Admin\JQAdm\Product\Factory::createClient( $this->context, array(), 'Standard' );
		\Aimeos\Admin\JQAdm\Product\Factory::injectClient( '\\Aimeos\\Admin\\JQAdm\\Product\\Standard', $client );

		$iClient = \Aimeos\Admin\JQAdm\Product\Factory::createClient( $this->context, array(), 'Standard' );

		$this->assertSame( $client, $iClient );
	}


	public function testInjectClientReset()
	{
		$client = \Aimeos\Admin\JQAdm\Product\Factory::createClient( $this->context, array(), 'Standard' );
		\Aimeos\Admin\JQAdm\Product\Factory::injectClient( '\\Aimeos\\Admin\\JQAdm\\Product\\Standard', $client );
		\Aimeos\Admin\JQAdm\Product\Factory::injectClient( '\\Aimeos\\Admin\\JQAdm\\Product\\Standard', null );

		$new = \Aimeos\Admin\JQAdm\Product\Factory::createClient( $this->context, array(), 'Standard' );

		$this->assertNotSame( $client, $new );
	}


	public function testAddDecoratorsInvalidName()
	{
		$client = \Aimeos\Admin\JQAdm\Product\Factory::createClient( $this->context, array(), 'Standard' );

		$this->setExpectedException( '\\Aimeos\\Admin\\JQAdm\\Exception' );
		\Aimeos\Admin\JQAdm\Common\Factory\TestAbstract::addDecoratorsPublic( $this->context, $client, array(),
			array( '$' ), 'Test' );
	}


	public function testAddDecoratorsInvalidClass()
	{
		$client = \Aimeos\Admin\JQAdm\Product\Factory::createClient( $this->context, array(), 'Standard' );

		$this->setExpectedException( '\\Aimeos\\Admin\\JQAdm\\Exception' );
		\Aimeos\Admin\JQAdm\Common\Factory\TestAbstract::addDecoratorsPublic( $this->context, $client, array(),
			array( 'Test' ), 'TestDecorator' );
	}


	public function testAddDecoratorsInvalidInterface()
	{
		$client = \Aimeos\Admin\JQAdm\Product\Factory::createClient( $this->context, array(), 'Standard' );

		$this->setExpectedException( '\\Aimeos\\Admin\\JQAdm\\Exception' );
		\Aimeos\Admin\JQAdm\Common\Factory\TestAbstract::addDecoratorsPublic( $this->context, $client, array(),
			array( 'Test' ), '\\Aimeos\\Admin\\JQAdm\\Common\\Decorator\\' );
	}


	public function testAddClientDecoratorsExcludes()
	{
		$this->context->getConfig()->set( 'admin/jqadm/decorators/excludes', array( 'TestDecorator' ) );
		$this->context->getConfig()->set( 'admin/jqadm/common/decorators/default', array( 'TestDecorator' ) );

		$this->setExpectedException( '\\Aimeos\\Admin\\JQAdm\\Exception' );
		\Aimeos\Admin\JQAdm\Product\Factory::createClient( $this->context, array(), 'Standard' );
	}
}


class TestAbstract
	extends \Aimeos\Admin\JQAdm\Common\Factory\Base
{
	/**
	 * @param string $classprefix
	 * @param string $path
	 */
	public static function addDecoratorsPublic( \Aimeos\MShop\Context\Item\Iface $context,
		\Aimeos\Admin\JQAdm\Iface $client, $templatePaths, array $decorators, $classprefix )
	{
		self::addDecorators( $context, $client, $templatePaths, $decorators, $classprefix );
	}

	public static function addClientDecoratorsPublic( \Aimeos\MShop\Context\Item\Iface $context,
		\Aimeos\Admin\JQAdm\Iface $client, $templatePaths, $path )
	{
		self::addClientDecorators( $context, $client, $templatePaths, $path );
	}
}


class TestDecorator
{
}