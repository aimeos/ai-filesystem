<?php

namespace Aimeos\Base\Filesystem;


class FlyDropboxTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
	{
		if( !interface_exists( '\\League\\Flysystem\\FilesystemInterface' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}
	}


	public function testGetProvider()
	{
		$object = new FlyDropbox( [] );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$this->expectException( 'Aimeos\Base\Filesystem\Exception' );
		$object->has( 'test' );
	}


	public function testGetProviderToken()
	{
		$config = array(
			'accesstoken' => 'test',
		);
		$object = new FlyDropbox( $config );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$this->expectException( 'Aimeos\Base\Filesystem\Exception' );
		$object->has( 'test' );
	}


	public function testGetProviderAccess()
	{
		if( !class_exists( '\League\Flysystem\Dropbox\DropboxAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem Dropbox adapter' );
		}

		$config = array(
			'accesstoken' => 'test',
			'appsecret' => 'test',
		);
		$object = new FlyDropbox( $config );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$this->expectException( 'Exception' );
		$object->has( 'test' );
	}
}
