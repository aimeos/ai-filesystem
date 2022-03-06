<?php

namespace Aimeos\Base\Filesystem;


class FlyAzureTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
	{
		if( !class_exists( '\\League\\Flysystem\\Filesystem' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}
	}


	public function testGetProvider()
	{
		if( !class_exists( '\League\Flysystem\AzureBlobStorage\AzureBlobStorageAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem Azure adapter' );
		}

		$object = new FlyAzure( ['endpoint' => 'test', 'container' => 'test'] );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$object->has( 'test' );
	}


	public function testGetProviderNoEndpoint()
	{
		$object = new FlyAzure( [] );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$object->has( 'test' );
	}


	public function testGetProviderNoContainer()
	{
		$object = new FlyAzure( ['endpoint' => 'test'] );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$object->has( 'test' );
	}
}
