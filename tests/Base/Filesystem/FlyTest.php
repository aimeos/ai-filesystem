<?php

namespace Aimeos\Base\Filesystem;


class FlyTest extends \PHPUnit\Framework\TestCase
{
	private $mock;
	private $object;


	protected function setUp() : void
	{
		if( !class_exists( '\\League\\Flysystem\\Filesystem' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}

		$this->object = $this->getMockBuilder( '\\Aimeos\\Base\\Filesystem\\FlyLocal' )
			->setConstructorArgs( array( array( 'adapter' => 'FlyLocal' ) ) )
			->onlyMethods( array( 'getProvider' ) )
			->getMock();

		$this->mock = $this->getMockBuilder( '\\League\\Flysystem\\Filesystem' )
			->disableOriginalConstructor()
			->getMock();

		$this->object->expects( $this->any() )->method( 'getProvider' )
			->will( $this->returnValue( $this->mock ) );
	}


	protected function tearDown() : void
	{
		unset( $this->object, $this->mock );
	}


	public function testConstructException()
	{
		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		new \Aimeos\Base\Filesystem\FlyLocal( ['tempdir' => '/test'] );
	}


	public function testIsdir()
	{
		$listStub = $this->getMockBuilder( '\\League\\Flysystem\\DirectoryListing' )
			->setConstructorArgs( [[new \League\Flysystem\DirectoryAttributes( 'test' )]] )
			->onlyMethods( ['filter'] )
			->getMock();

		$this->mock->expects( $this->once() )->method( 'listContents' )
			->will( $this->returnValue( $listStub ) );

		$this->assertTrue( $this->object->isdir( 'test' ) );
	}


	public function testIsdirFalse()
	{
		$listStub = $this->getMockBuilder( '\\League\\Flysystem\\DirectoryListing' )
			->setConstructorArgs( [[new \League\Flysystem\FileAttributes( 'test' )]] )
			->onlyMethods( ['filter'] )
			->getMock();

		$this->mock->expects( $this->once() )->method( 'listContents' )
			->will( $this->returnValue( $listStub ) );

		$this->assertFalse( $this->object->isdir( 'test' ) );
	}


	public function testIsdirException()
	{
		$this->object->expects( $this->any() )->method( 'getProvider' )
			->will( $this->throwException( new \RuntimeException() ) );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$this->assertTrue( $this->object->isdir( 'test' ) );
	}


	public function testMkdir()
	{
		$this->mock->expects( $this->once() )->method( 'createDirectory' );

		$object = $this->object->mkdir( 'test' );

		$this->assertInstanceOf( \Aimeos\Base\Filesystem\DirIface::class, $object );
	}


	public function testMkdirException()
	{
		$this->mock->expects( $this->once() )->method( 'createDirectory' )
			->will( $this->throwException( new \RuntimeException() ) );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$this->object->mkdir( 'test' );
	}


	public function testRmdir()
	{
		$this->mock->expects( $this->once() )->method( 'deleteDirectory' );

		$object = $this->object->rmdir( 'test' );

		$this->assertInstanceOf( \Aimeos\Base\Filesystem\DirIface::class, $object );
	}


	public function testRmdirException()
	{
		$this->mock->expects( $this->once() )->method( 'deleteDirectory' )
			->will( $this->throwException( new \RuntimeException() ) );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$this->object->rmdir( 'test' );
	}


	public function testScan()
	{
		$listStub = $this->getMockBuilder( '\\League\\Flysystem\\DirectoryListing' )
			->setConstructorArgs( [[new \League\Flysystem\FileAttributes( 'test' )]] )
			->onlyMethods( ['filter'] )
			->getMock();

		$this->mock->expects( $this->once() )->method( 'listContents' )
			->will( $this->returnValue( $listStub ) );

		$this->assertEquals( ['test'], $this->object->scan() );
	}


	public function testScanException()
	{
		$this->object->expects( $this->any() )->method( 'getProvider' )
			->will( $this->throwException( new \RuntimeException() ) );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$this->assertTrue( $this->object->scan( 'test' ) );
	}


	public function testSize()
	{
		$this->mock->expects( $this->once() )->method( 'fileSize' )
			->will( $this->returnValue( 4 ) );

		$this->assertEquals( 4, $this->object->size( 'test' ) );
	}


	public function testSizeException()
	{
		$this->mock->expects( $this->once() )->method( 'fileSize' )
		->will( $this->throwException( new \RuntimeException() ) );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$this->object->size( 'test' );
	}


	public function testTime()
	{
		$this->mock->expects( $this->once() )->method( 'lastModified' )
			->will( $this->returnValue( 4 ) );

		$this->assertEquals( 4, $this->object->time( 'test' ) );
	}


	public function testTimeException()
	{
		$this->mock->expects( $this->once() )->method( 'lastModified' )
			->will( $this->throwException( new \RuntimeException() ) );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$this->object->time( 'test' );
	}


	public function testRm()
	{
		$this->mock->expects( $this->once() )->method( 'delete' );

		$object = $this->object->rm( 'test' );

		$this->assertInstanceOf( \Aimeos\Base\Filesystem\Iface::class, $object );
	}


	public function testRmException()
	{
		$this->mock->expects( $this->once() )->method( 'delete' )
			->will( $this->throwException( new \RuntimeException() ) );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$this->object->rm( 'test' );
	}


	public function testHas()
	{
		$this->mock->expects( $this->once() )->method( 'fileExists' )
			->will( $this->returnValue( true ) );

		$result = $this->object->has( 'test' );

		$this->assertTrue( $result );
	}


	public function testHasFalse()
	{
		$this->mock->expects( $this->once() )->method( 'fileExists' )
			->will( $this->returnValue( false ) );

		if( method_exists( $this->mock, 'directoryExists' ) )
		{
			$this->mock->expects( $this->once() )->method( 'directoryExists' )
				->will( $this->returnValue( false ) );
		}

		$result = $this->object->has( 'test' );

		$this->assertFalse( $result );
	}


	public function testHasException()
	{
		$this->mock->expects( $this->once() )->method( 'fileExists' )
			->will( $this->throwException( new \RuntimeException() ) );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$this->object->has( 'test' );
	}


	public function testRead()
	{
		$this->mock->expects( $this->once() )->method( 'read' )
			->will( $this->returnValue( 'value' ) );

		$this->assertEquals( 'value', $this->object->read( 'test' ) );
	}


	public function testReadException()
	{
		$this->mock->expects( $this->once() )->method( 'read' )
			->will( $this->throwException( new \RuntimeException() ) );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$this->object->read( 'test' );
	}


	public function testReadf()
	{
		$file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'flytest';
		file_put_contents( $file, 'test' );

		$this->mock->expects( $this->once() )->method( 'readStream' )
			->will( $this->returnValue( fopen( $file, 'r' ) ) );

		$result = $this->object->readf( 'file' );

		$this->assertEquals( 'test', file_get_contents( $result ) );

		unlink( $result );
		unlink( $file );
	}


	public function testReads()
	{
		$this->mock->expects( $this->once() )->method( 'readStream' )
			->will( $this->returnValue( 1 ) );

		$this->assertEquals( 1, $this->object->reads( 'test' ) );
	}


	public function testReadsException()
	{
		$this->mock->expects( $this->once() )->method( 'readStream' )
			->will( $this->throwException( new \RuntimeException() ) );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$this->object->reads( 'test' );
	}


	public function testWrite()
	{
		$this->mock->expects( $this->once() )->method( 'write' );

		$object = $this->object->write( 'test', 'value' );

		$this->assertInstanceOf( \Aimeos\Base\Filesystem\Iface::class, $object );
	}


	public function testWriteException()
	{
		$this->mock->expects( $this->once() )->method( 'write' )
			->will( $this->throwException( new \RuntimeException() ) );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$this->object->write( 'test', 'value' );
	}


	public function testWritef()
	{
		$file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'flytest';
		file_put_contents( $file, 'test' );

		$this->mock->expects( $this->once() )->method( 'writeStream' );

		$object = $this->object->writef( 'file', $file );

		unlink( $file );
		$this->assertInstanceOf( \Aimeos\Base\Filesystem\Iface::class, $object );
	}


	public function testWritefException()
	{
		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$this->object->writef( 'file', '/test' );
	}


	public function testWrites()
	{
		$this->mock->expects( $this->once() )->method( 'writeStream' );

		$object = $this->object->writes( 'test', 1 );

		$this->assertInstanceOf( \Aimeos\Base\Filesystem\Iface::class, $object );
	}


	public function testWritesException()
	{
		$this->mock->expects( $this->once() )->method( 'writeStream' )
			->will( $this->throwException( new \RuntimeException() ) );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$this->object->writes( 'test', null );
	}


	public function testMove()
	{
		$this->mock->expects( $this->once() )->method( 'move' )
			->will( $this->returnValue( true ) );

		$object = $this->object->move( 'file1', 'file2' );

		$this->assertInstanceOf( \Aimeos\Base\Filesystem\Iface::class, $object );
	}


	public function testMoveException()
	{
		$this->mock->expects( $this->once() )->method( 'move' )
			->will( $this->throwException( new \RuntimeException() ) );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$this->object->move( 'file1', 'file2' );
	}


	public function testCopy()
	{
		$this->mock->expects( $this->once() )->method( 'copy' );

		$object = $this->object->copy( 'file1', 'file2' );

		$this->assertInstanceOf( \Aimeos\Base\Filesystem\Iface::class, $object );
	}


	public function testCopyException()
	{
		$this->mock->expects( $this->once() )->method( 'copy' )
			->will( $this->throwException( new \RuntimeException() ) );

		$this->expectException( \Aimeos\Base\Filesystem\Exception::class );
		$this->object->copy( 'file1', 'file2' );
	}
}
