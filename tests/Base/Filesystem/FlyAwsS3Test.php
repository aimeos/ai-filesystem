<?php

namespace Aimeos\Base\Filesystem;


class FlyAwsS3Test extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
	{
		if( !class_exists( '\\League\\Flysystem\\Filesystem' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}
	}


	public function testGetProvider()
	{
		if( !class_exists( '\League\Flysystem\AwsS3V3\AwsS3V3Adapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem AwsS3V3Adapter adapter' );
		}

		$object = new FlyAwsS3( array( 'bucket' => 'test' ) );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$object->has( 'test' );
	}


	public function testGetProviderNoBucket()
	{
		$object = new FlyAwsS3( [] );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$object->has( 'test' );
	}
}
