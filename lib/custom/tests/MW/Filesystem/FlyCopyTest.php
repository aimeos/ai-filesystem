<?php

namespace Aimeos\MW\Filesystem;


class FlyCopyTest extends \PHPUnit_Framework_TestCase
{
	protected function setUp()
	{
		if( !interface_exists( '\\League\\Flysystem\\FilesystemInterface' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}
	}


	public function testGetProvider()
	{
		$object = new FlyCopy( array() );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$this->setExpectedException( 'Aimeos\MW\Filesystem\Exception' );
		$object->has( 'test' );
	}


	public function testGetProviderKey()
	{
		$config = array(
			'consumerkey' => 'test'
		);
		$object = new FlyCopy( $config );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$this->setExpectedException( 'Aimeos\MW\Filesystem\Exception' );
		$object->has( 'test' );
	}


	public function testGetProviderSecret()
	{
		$config = array(
			'consumerkey' => 'test',
			'consumersecret' => 'test',
		);
		$object = new FlyCopy( $config );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$this->setExpectedException( 'Aimeos\MW\Filesystem\Exception' );
		$object->has( 'test' );
	}


	public function testGetProviderToken()
	{
		$config = array(
			'consumerkey' => 'test',
			'consumersecret' => 'test',
			'accesstoken' => 'test',
		);
		$object = new FlyCopy( $config );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$this->setExpectedException( 'Aimeos\MW\Filesystem\Exception' );
		$object->has( 'test' );
	}


	public function testGetProviderAccess()
	{
		if( !class_exists( '\League\Flysystem\Copy\CopyAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem Copy adapter' );
		}

		$config = array(
			'consumerkey' => 'test',
			'consumersecret' => 'test',
			'accesstoken' => 'test',
			'tokensecret' => 'test',
		);
		$object = new FlyCopy( $config );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$this->setExpectedException( 'Exception' );
		$object->has( 'test' );
	}
}
