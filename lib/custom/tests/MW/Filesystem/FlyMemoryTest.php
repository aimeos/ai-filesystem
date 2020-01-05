<?php

namespace Aimeos\MW\Filesystem;


class FlyMemoryTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
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

		$object = new FlyMemory( [] );
		$this->assertInstanceof( \Aimeos\MW\Filesystem\Iface::class, $object );

		$object->has( 'test' );
	}
}
