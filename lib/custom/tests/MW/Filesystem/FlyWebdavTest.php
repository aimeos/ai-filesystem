<?php

namespace Aimeos\MW\Filesystem;


class FlyWebdavTest extends \PHPUnit_Framework_TestCase
{
	public function testGetProvider()
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
