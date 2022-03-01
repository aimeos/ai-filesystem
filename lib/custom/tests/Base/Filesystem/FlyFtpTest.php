<?php

namespace Aimeos\Base\Filesystem;


class FlyFtpTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
	{
		if( !class_exists( '\\League\\Flysystem\\Filesystem' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}

		if( !class_exists( '\\League\\Flysystem\\Ftp\\FtpAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem FTP adapter first' );
		}
	}


	public function testGetProvider()
	{
		$object = new FlyFtp( ['host' => 'ftp.heise.de', 'username' => '', 'password' => '', 'root' => '/'] );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$object->has( 'test' );
	}
}
