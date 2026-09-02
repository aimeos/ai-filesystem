<?php

namespace Aimeos\Base\Filesystem;


class FlyLocalTest extends \PHPUnit\Framework\TestCase
{
	public function testConstruct()
	{
		$object = new FlyLocal( array( 'basedir' => dirname( dirname( __DIR__ ) ) ) );
		$this->assertInstanceof( \Aimeos\Base\Filesystem\Standard::class, $object );
	}
}
