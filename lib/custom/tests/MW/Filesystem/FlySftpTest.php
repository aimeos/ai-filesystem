<?php

namespace Aimeos\MW\Filesystem;


class FlySftpTest extends \PHPUnit_Framework_TestCase
{
	public function testGetProvider()
	{
		if( !class_exists( '\League\Flysystem\Sftp\SftpAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem SFTP adapter' );
		}

		$object = new FlySftp( array( 'host' => 'test.rebex.net', 'username' => 'demo', 'password' => 'password' ) );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$object->has( 'test' );
	}
}
