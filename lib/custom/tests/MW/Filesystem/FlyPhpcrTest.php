<?php

namespace Aimeos\MW\Filesystem;


class FlyPhpcrTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
	{
		if( !interface_exists( '\\League\\Flysystem\\FilesystemInterface' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}
	}


	public function testGetProvider()
	{
		$object = new FlyPhpcr( [] );
		$this->assertInstanceof( \Aimeos\MW\Filesystem\Iface::class, $object );

		$this->expectException( \Aimeos\MW\Filesystem\Exception::class );
		$object->has( 'test' );
	}


	public function testGetProviderRoot()
	{
		if( !class_exists( '\League\Flysystem\Phpcr\PhpcrAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem PHPCR adapter' );
		}

		$config = array(
			'driver' => 'pdo_sqlite',
			'path' => '/tmp/fly_phpcr.db',
			'root' => '/',
		);
		$object = new FlyPhpcr( $config );
		$this->assertInstanceof( \Aimeos\MW\Filesystem\Iface::class, $object );

		$this->expectException( \PHPCR\RepositoryException::class );
		$object->has( 'test' );
	}
}
