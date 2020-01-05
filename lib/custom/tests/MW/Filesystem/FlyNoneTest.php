<?php

namespace Aimeos\MW\Filesystem;


class FlyNoneTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
	{
		if( !interface_exists( '\\League\\Flysystem\\FilesystemInterface' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}
	}


	public function testGetProvider()
	{
		$object = new FlyNone( [] );
		$this->assertInstanceof( \Aimeos\MW\Filesystem\Iface::class, $object );

		$object->has( 'test' );
	}
}
