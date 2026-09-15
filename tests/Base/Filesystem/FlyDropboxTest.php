<?php

namespace Aimeos\Base\Filesystem;


class FlyDropboxTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
	{
		if( !class_exists( '\\League\\Flysystem\\Filesystem' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}

		if( !class_exists( '\\Spatie\\FlysystemDropbox\\DropboxAdapter' ) ) {
			$this->markTestSkipped( 'Install DropboxAdapter first' );
		}
	}


	public function testGetProvider()
	{
		$object = new FlyDropbox( [] );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$this->expectException( 'Aimeos\Base\Filesystem\Exception' );
		$object->has( 'test' );
	}


	public function testGetProviderToken()
	{
		$object = new FlyDropbox( ['accesstoken' => 'test'] );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );
	}
}
