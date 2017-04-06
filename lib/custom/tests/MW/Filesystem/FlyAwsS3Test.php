<?php

namespace Aimeos\MW\Filesystem;


class FlyAwsS3Test extends \PHPUnit_Framework_TestCase
{
	protected function setUp()
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
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$this->setExpectedException( 'InvalidArgumentException' );
		$object->has( 'test' );
	}


	public function testGetProviderNoBucket()
	{
		$object = new FlyAwsS3( [] );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$object->has( 'test' );
	}
}
