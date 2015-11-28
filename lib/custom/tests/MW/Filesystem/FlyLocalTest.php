<?php

namespace Aimeos\MW\Filesystem;


class FlyLocalTest extends \PHPUnit_Framework_TestCase
{
	public function testGetProvider()
	{
		$object = new FlyLocal( array( 'basedir' => dirname( dirname( __DIR__ ) ) ) );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$object->has( 'test' );
	}


	public function testGetProviderNoBasedir()
	{
		$object = new FlyLocal( array() );
		$this->assertInstanceof( '\Aimeos\MW\Filesystem\Iface', $object );

		$this->setExpectedException( 'Aimeos\MW\Filesystem\Exception' );
		$object->has( 'test' );
	}
}
