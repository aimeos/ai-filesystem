<?php

namespace Aimeos\MW\Filesystem;


class FlySftpTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
	{
		if( !interface_exists( '\\League\\Flysystem\\FilesystemInterface' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}
	}


	public function testGetProvider()
	{
		if( !class_exists( '\League\Flysystem\Sftp\SftpAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem SFTP adapter' );
		}

		$object = new FlySftp( array( 'host' => 'test.rebex.net', 'username' => 'demo', 'password' => 'password' ) );
		$this->assertInstanceof( \Aimeos\MW\Filesystem\Iface::class, $object );

		$object->has( 'test' );
	}
}
