<?php

namespace Aimeos\MW\Filesystem;


class FlyAzureTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
	{
		if( !interface_exists( '\\League\\Flysystem\\FilesystemInterface' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}
	}


	public function testGetProvider()
	{
		if( !class_exists( '\League\Flysystem\Azure\AzureAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem Azure adapter' );
		}

		$object = new FlyAzure( [] );
		$this->assertInstanceof( \Aimeos\MW\Filesystem\Iface::class, $object );

		$object->has( 'test' );
	}
}
