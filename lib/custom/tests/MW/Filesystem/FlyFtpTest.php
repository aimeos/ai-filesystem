<?php

namespace Aimeos\MW\Filesystem;


class FlyFtpTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp()
	{
		if( !interface_exists( '\\League\\Flysystem\\FilesystemInterface' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}
	}


	public function testGetProvider()
	{
		$object = new FlyFtp( array( 'host' => 'ftp.heise.de' ) );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$object->has( 'test' );
	}
}
