<?php

namespace Aimeos\MW\Filesystem;


class FlyAwsS3Test extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
	{
		if( !interface_exists( '\\League\\Flysystem\\FilesystemInterface' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}
	}


	public function testGetProvider()
	{
		if( !class_exists( '\League\Flysystem\AwsS3v3\AwsS3Adapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem AwsS3v3 adapter' );
		}

		$object = new FlyAwsS3( array( 'bucket' => 'test' ) );
		$this->assertInstanceof( \Aimeos\MW\Filesystem\Iface::class, $object );

		$this->expectException( 'InvalidArgumentException' );
		$object->has( 'test' );
	}


	public function testGetProviderNoBucket()
	{
		$object = new FlyAwsS3( [] );
		$this->assertInstanceof( \Aimeos\MW\Filesystem\Iface::class, $object );

		$this->expectException( \Aimeos\MW\Filesystem\Exception::class );
		$object->has( 'test' );
	}
}
