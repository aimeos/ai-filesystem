<?php

namespace Aimeos\MW\Filesystem;


class FlyAzureTest extends \PHPUnit_Framework_TestCase
{
	public function testGetProvider()
	{
		if( !class_exists( '\League\Flysystem\Azure\AzureAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem Azure adapter' );
		}

		$object = new FlyAzure( array() );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$object->has( 'test' );
	}
}
