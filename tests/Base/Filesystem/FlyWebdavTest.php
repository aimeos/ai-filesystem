<?php

namespace Aimeos\Base\Filesystem;


class FlyWebdavTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
	{
		if( !class_exists( '\\League\\Flysystem\\Filesystem' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}

		if( !class_exists( '\League\Flysystem\WebDAV\WebDAVAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem WebDAV adapter' );
		}
	}


	public function testGetProvider()
	{
		$object = new FlyWebdav( array( 'baseUri' => 'http://test.webdav.org/dav/' ) );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$object->has( 'test' );
	}


	public function testGetProviderNoBaseuri()
	{
		$object = new FlyWebdav( [] );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$object->has( 'test' );
	}
}
