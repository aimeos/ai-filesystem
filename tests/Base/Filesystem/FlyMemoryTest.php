<?php

namespace Aimeos\Base\Filesystem;


class FlyMemoryTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
	{
		if( !class_exists( '\\League\\Flysystem\\Filesystem' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}

		if( !class_exists( '\League\Flysystem\InMemory\InMemoryFilesystemAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem memory adapter' );
		}
	}


	public function testGetProvider()
	{
		$object = new FlyMemory( [] );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$object->has( 'test' );
	}
}
