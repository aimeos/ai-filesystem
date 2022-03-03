<?php

namespace Aimeos\Base\Filesystem;


class FlyZipTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
	{
		if( !class_exists( '\\League\\Flysystem\\Filesystem' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}
	}


	public function testGetProvider()
	{
		if( !class_exists( '\League\Flysystem\ZipArchive\ZipArchiveAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem ZipArchive adapter' );
		}

		$object = new FlyZip( [] );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$object->has( 'test' );
	}


	public function testGetProviderFilepath()
	{
		if( !class_exists( '\League\Flysystem\ZipArchive\ZipArchiveAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem ZipArchive adapter' );
		}

		$object = new FlyZip( array( 'filepath' => '/tmp/flytest.zip' ) );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$object->has( 'test' );
	}
}
