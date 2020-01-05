<?php

namespace Aimeos\MW\Filesystem;


class FlyWebdavTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
	{
		if( !interface_exists( '\\League\\Flysystem\\FilesystemInterface' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}
	}


	public function testGetProvider()
	{
		if( !class_exists( '\League\Flysystem\WebDAV\WebDAVAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem WebDAV adapter' );
		}

		try
		{
			$object = new FlyWebdav( array( 'baseUri' => 'http://test.webdav.org/dav/' ) );
			$this->assertInstanceof( \Aimeos\MW\Filesystem\Iface::class, $object );

			$object->has( 'test' );
		}
		catch( \Exception $e )
		{
			$this->markTestSkipped( $e->getMessage() );
		}
	}


	public function testGetProviderNoBaseuri()
	{
		if( !class_exists( '\League\Flysystem\WebDAV\WebDAVAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem WebDAV adapter' );
		}

		$object = new FlyWebdav( [] );
		$this->assertInstanceof( \Aimeos\MW\Filesystem\Iface::class, $object );

		$this->expectException( \InvalidArgumentException::class );
		$object->has( 'test' );
	}
}
