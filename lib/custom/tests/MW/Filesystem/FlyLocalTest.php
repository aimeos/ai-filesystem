<?php

namespace Aimeos\MW\Filesystem;


class FlyLocalTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp()
	{
		if( !interface_exists( '\\League\\Flysystem\\FilesystemInterface' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}
	}


	public function testGetProvider()
	{
		$object = new FlyLocal( array( 'basedir' => dirname( dirname( __DIR__ ) ) ) );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$object->has( 'test' );
	}


	public function testGetProviderNoBasedir()
	{
		$object = new FlyLocal( [] );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$this->setExpectedException( 'Aimeos\MW\Filesystem\Exception' );
		$object->has( 'test' );
	}
}
