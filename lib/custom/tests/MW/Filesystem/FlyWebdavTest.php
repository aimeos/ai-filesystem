<?php

namespace Aimeos\MW\Filesystem;


class FlyWebdavTest extends \PHPUnit_Framework_TestCase
{
	public function testGetProvider()
	{
		if( !class_exists( '\League\Flysystem\WebDAV\WebDAVAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem WebDAV adapter' );
		}

		$object = new FlyWebdav( array( 'baseUri' => 'http://test.webdav.org/dav/' ) );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$object->has( 'test' );
	}


	public function testGetProviderNoBaseuri()
	{
		if( !class_exists( '\League\Flysystem\WebDAV\WebDAVAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem WebDAV adapter' );
		}

		$object = new FlyWebdav( array() );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$this->setExpectedException( '\InvalidArgumentException' );
		$object->has( 'test' );
	}
}
