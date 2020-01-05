<?php

namespace Aimeos\MW\Filesystem;


class FlyRackspaceTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
	{
		if( !interface_exists( '\\League\\Flysystem\\FilesystemInterface' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}
	}


	public function testGetProvider()
	{
		$object = new FlyRackspace( [] );
		$this->assertInstanceof( \Aimeos\MW\Filesystem\Iface::class, $object );

		$this->expectException( \Aimeos\MW\Filesystem\Exception::class );
		$object->has( 'test' );
	}


	public function testGetProviderContainer()
	{
		if( !class_exists( '\League\Flysystem\Rackspace\RackspaceAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem Rackspace adapter' );
		}

		$object = new FlyRackspace( array( 'container' => 'test' ) );
		$this->assertInstanceof( \Aimeos\MW\Filesystem\Iface::class, $object );

		$this->expectException( \OpenCloud\Common\Exceptions\CredentialError::class );
		$object->has( 'test' );
	}
}
