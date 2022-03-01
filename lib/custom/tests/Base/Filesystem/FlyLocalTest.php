<?php

namespace Aimeos\Base\Filesystem;


class FlyLocalTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
	{
		if( !class_exists( '\\League\\Flysystem\\Filesystem' )
			|| !class_exists( '\\League\\Flysystem\\Local\\LocalFilesystemAdapter' )
		) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}
	}


	public function testGetProvider()
	{
		$object = new FlyLocal( array( 'basedir' => dirname( dirname( __DIR__ ) ) ) );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$object->has( 'test' );
	}


	public function testGetProviderNoBasedir()
	{
		$object = new FlyLocal( [] );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$this->expectException( 'Aimeos\Base\Filesystem\Exception' );
		$object->has( 'test' );
	}
}
