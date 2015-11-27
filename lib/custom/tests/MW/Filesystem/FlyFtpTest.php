<?php

namespace Aimeos\MW\Filesystem;


class FlyFtpTest extends \PHPUnit_Framework_TestCase
{
	public function testGetProvider()
	{
		$object = new FlyFtp( array( 'host' => 'ftp.kernel.org' ) );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$object->has( 'test' );
	}
}
