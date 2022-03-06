<?php

namespace Aimeos\Base\Filesystem;


class FlySftpTest extends \PHPUnit\Framework\TestCase
{
	protected function setUp() : void
	{
		if( !class_exists( '\\League\\Flysystem\\Filesystem' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}

		if( !class_exists( 'League\Flysystem\PhpseclibV2\SftpAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem SFTP adapter' );
		}
	}


	public function testGetProvider()
	{
		$object = new FlySftp( ['host' => 'test.rebex.net', 'username' => 'demo', 'password' => 'password', 'root' => ''] );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$object->has( 'test' );
	}


	public function testGetProviderNoHost()
	{
		$object = new FlySftp( [] );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$object->has( 'test' );
	}


	public function testGetProviderNoUser()
	{
		$object = new FlySftp( ['host' => 'test.rebex.net'] );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$object->has( 'test' );
	}


	public function testGetProviderNoRoot()
	{
		$object = new FlySftp( ['host' => 'test.rebex.net', 'username' => 'demo', 'password' => 'password'] );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Iface::class, $object );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$object->has( 'test' );
	}
}
