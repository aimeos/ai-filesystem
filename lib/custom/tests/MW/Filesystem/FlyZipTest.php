<?php

namespace Aimeos\MW\Filesystem;


class FlyZipTest extends \PHPUnit_Framework_TestCase
{
	protected function setUp()
	{
		if( !interface_exists( '\\League\\Flysystem\\FilesystemInterface' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}
	}


	public function testGetProvider()
	{
		if( !class_exists( '\League\Flysystem\ZipArchive\ZipArchiveAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem ZipArchive adapter' );
		}

		$object = new FlyZip( array() );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$object->has( 'test' );
	}


	public function testGetProviderFilepath()
	{
		if( !class_exists( '\League\Flysystem\ZipArchive\ZipArchiveAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem ZipArchive adapter' );
		}

		$object = new FlyZip( array( 'filepath' => '/tmp/flytest.zip' ) );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$object->has( 'test' );
	}
}
