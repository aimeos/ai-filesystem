<?php

namespace Aimeos\MW\Filesystem;


class FlyGridfsTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
	{
		if( !interface_exists( '\\League\\Flysystem\\FilesystemInterface' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}
	}


	public function testGetProvider()
	{
		$object = new FlyGridfs( [] );
		$this->assertInstanceof( \Aimeos\MW\Filesystem\Iface::class, $object );

		$this->expectException( 'Aimeos\MW\Filesystem\Exception' );
		$object->has( 'test' );
	}


	public function testGetProviderToken()
	{
		if( !class_exists( '\League\Flysystem\GridFS\GridFSAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem GridFS adapter' );
		}

		if( !class_exists( '\MongoClient' ) ) {
			$this->markTestSkipped( 'Install Mongo client extension' );
		}

		$config = array(
			'dbname' => 'test',
		);
		$object = new FlyGridfs( $config );
		$this->assertInstanceof( \Aimeos\MW\Filesystem\Iface::class, $object );

		$this->expectException( 'Aimeos\MW\Filesystem\Exception' );
		$object->has( 'test' );
	}
}
