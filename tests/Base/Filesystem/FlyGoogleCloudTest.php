<?php

namespace Aimeos\Base\Filesystem;


class FlyGoogleCloudTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
	{
		if( !class_exists( '\\League\\Flysystem\\Filesystem' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}

		if( !class_exists( '\League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem GoogleCloudStorageAdapter adapter' );
		}
	}


	public function testGetProvider()
	{
		$object = new FlyGoogleCloud( ['bucket' => 'test'] );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$object->has( 'test' );
	}


	public function testGetProviderNoBucket()
	{
		$object = new FlyGoogleCloud( [] );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$object->has( 'test' );
	}
}
