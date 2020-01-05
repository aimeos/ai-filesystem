<?php

namespace Aimeos\MW\Filesystem;


class FlyReplicateTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
	{
		if( !interface_exists( '\\League\\Flysystem\\FilesystemInterface' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}
	}


	public function testGetProvider()
	{
		if( !class_exists( '\League\Flysystem\Replicate\ReplicateAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem Replicate adapter' );
		}

		$config = array(
			'adapter' => 'Replicate',
			'source' => array( 'adapter' => 'FlyMemory' ),
			'replica' => array( 'adapter' => 'FlyMemory' ),
		);
		$object = new FlyReplicate( $config );
		$this->assertInstanceof( \Aimeos\MW\Filesystem\Iface::class, $object );

		$object->has( 'test' );
	}


	public function testGetProviderNoSource()
	{
		$config = array(
			'adapter' => 'Replicate',
		);
		$object = new FlyReplicate( $config );
		$this->assertInstanceof( \Aimeos\MW\Filesystem\Iface::class, $object );

		$this->expectException( 'Aimeos\MW\Filesystem\Exception' );
		$object->has( 'test' );
	}


	public function testGetProviderNoReplica()
	{
		$config = array(
			'adapter' => 'Replicate',
			'source' => array( 'adapter' => 'FlyMemory' ),
		);
		$object = new FlyReplicate( $config );
		$this->assertInstanceof( \Aimeos\MW\Filesystem\Iface::class, $object );

		$this->expectException( 'Aimeos\MW\Filesystem\Exception' );
		$object->has( 'test' );
	}
}
