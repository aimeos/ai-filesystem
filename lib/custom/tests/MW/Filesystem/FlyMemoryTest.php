<?php

namespace Aimeos\MW\Filesystem;


class FlyMemoryTest extends \PHPUnit_Framework_TestCase
{
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
