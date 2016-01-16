<?php

namespace Aimeos\MW\Filesystem;


class FlyMemoryTest extends \PHPUnit_Framework_TestCase
{
	protected function setUp()
	{
		if( !interface_exists( '\\League\\Flysystem\\FilesystemInterface' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}
	}


	public function testGetProvider()
	{
		if( !class_exists( '\League\Flysystem\Memory\MemoryAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem memory adapter' );
		}

		$object = new FlyMemory( array() );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$object->has( 'test' );
	}
}
