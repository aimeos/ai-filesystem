<?php

namespace Aimeos\MW\Filesystem;


class FlyRackspaceTest extends \PHPUnit_Framework_TestCase
{
	public function testGetProvider()
	{
		$object = new FlyRackspace( array() );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$object->has( 'test' );
	}


	public function testGetProviderContainer()
	{
		if( !class_exists( '\League\Flysystem\Rackspace\RackspaceAdapter' ) ) {
			$this->markTestSkipped( 'Install Flysystem Rackspace adapter' );
		}

		$object = new FlyRackspace( array( 'container' => 'test' ) );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$this->setExpectedException( '\OpenCloud\Common\Exceptions\CredentialError' );
		$object->has( 'test' );
	}
}
