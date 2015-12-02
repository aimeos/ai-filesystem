<?php

namespace Aimeos\MW\Filesystem;


class FlyTest extends \PHPUnit_Framework_TestCase
{
	private $mock;
	private $object;


	protected function setUp()
	{
		if( !interface_exists( '\\League\\Flysystem\\FilesystemInterface' ) ) {
			$this->markTestSkipped( 'Install Flysystem first' );
		}

		$this->object = $this->getMockBuilder( '\\Aimeos\\MW\\Filesystem\\FlyNone' )
			->setConstructorArgs( array( array( 'adapter' => 'FlyNone' ) ) )
			->setMethods( array( 'getProvider' ) )
			->getMock();

		$this->mock = $this->getMockBuilder( '\\League\\Flysystem\\FilesystemInterface' )
			->disableOriginalConstructor()
			->getMock();

		$this->object->expects( $this->once() )->method( 'getProvider' )
			->will( $this->returnValue( $this->mock ) );
	}


	protected function tearDown()
	{
		unset( $this->object, $this->mock );
	}


	public function testIsdir()
	{
		$this->mock->expects( $this->once() )->method( 'getMetadata' )
			->will( $this->returnValue( array( 'type' => 'dir' ) ) );

		$this->assertTrue( $this->object->isdir( 'test' ) );
	}


	public function testIsdirFalse()
	{
		$this->mock->expects( $this->once() )->method( 'getMetadata' )
			->will( $this->returnValue( array( 'type' => 'file' ) ) );

		$this->assertFalse( $this->object->isdir( 'test' ) );
	}


	public function testMkdir()
	{
		$this->mock->expects( $this->once() )->method( 'createDir' )
			->will( $this->returnValue( true ) );

		$this->object->mkdir( 'test' );
	}


	public function testMkdirException()
	{
		$this->mock->expects( $this->once() )->method( 'createDir' )
			->will( $this->returnValue( false ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->mkdir( 'test' );
	}


	public function testRmdir()
	{
		$this->mock->expects( $this->once() )->method( 'deleteDir' )
			->will( $this->returnValue( true ) );

		$this->object->rmdir( 'test' );
	}


	public function testRmdirException()
	{
		$this->mock->expects( $this->once() )->method( 'deleteDir' )
			->will( $this->returnValue( false ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->rmdir( 'test' );
	}


	public function testScan()
	{
		$this->mock->expects( $this->once() )->method( 'listContents' )
			->will( $this->returnValue( array( array( 'basename' => 'test' ) ) ) );

		$this->assertEquals( array( 'test' ), $this->object->scan() );
	}


	public function testSize()
	{
		$this->mock->expects( $this->once() )->method( 'getSize' )
			->will( $this->returnValue( 4 ) );

		$this->assertEquals( 4, $this->object->size( 'test' ) );
	}


	public function testSizeException()
	{
		$this->mock->expects( $this->once() )->method( 'getSize' )
			->will( $this->returnValue( false ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->size( 'test' );
	}


	public function testSizeException2()
	{
		$this->mock->expects( $this->once() )->method( 'getSize' )
		->will( $this->throwException( new \Exception() ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->size( 'test' );
	}


	public function testTime()
	{
		$this->mock->expects( $this->once() )->method( 'getTimestamp' )
			->will( $this->returnValue( 4 ) );

		$this->assertEquals( 4, $this->object->time( 'test' ) );
	}


	public function testTimeException()
	{
		$this->mock->expects( $this->once() )->method( 'getTimestamp' )
			->will( $this->returnValue( false ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->time( 'test' );
	}


	public function testTimeException2()
	{
		$this->mock->expects( $this->once() )->method( 'getTimestamp' )
			->will( $this->throwException( new \Exception() ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->time( 'test' );
	}


	public function testRm()
	{
		$this->mock->expects( $this->once() )->method( 'delete' )
		->will( $this->returnValue( 4 ) );

		$this->object->rm( 'test' );
	}


	public function testRmException()
	{
		$this->mock->expects( $this->once() )->method( 'delete' )
		->will( $this->throwException( new \Exception() ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->rm( 'test' );
	}


	public function testHas()
	{
		$this->mock->expects( $this->once() )->method( 'has' )
			->will( $this->returnValue( true ) );

		$result = $this->object->has( 'test' );

		$this->assertTrue( $result );
	}


	public function testHasFalse()
	{
		$this->mock->expects( $this->once() )->method( 'has' )
			->will( $this->returnValue( false ) );

		$result = $this->object->has( 'test' );

		$this->assertFalse( $result );
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
			->will( $this->returnValue( false ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->read( 'test' );
	}


	public function testReadException2()
	{
		$this->mock->expects( $this->once() )->method( 'read' )
			->will( $this->throwException( new \Exception() ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
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
			->will( $this->returnValue( false ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->reads( 'test' );
	}


	public function testReadsException2()
	{
		$this->mock->expects( $this->once() )->method( 'readStream' )
			->will( $this->throwException( new \Exception() ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->reads( 'test' );
	}


	public function testWrite()
	{
		$this->mock->expects( $this->once() )->method( 'put' )
			->will( $this->returnValue( true ) );

		$this->object->write( 'test', 'value' );
	}


	public function testWriteException()
	{
		$this->mock->expects( $this->once() )->method( 'put' )
			->will( $this->returnValue( false ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->write( 'test', 'value' );
	}


	public function testWriteException2()
	{
		$this->mock->expects( $this->once() )->method( 'put' )
			->will( $this->throwException( new \Exception() ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->write( 'test', 'value' );
	}


	public function testWritef()
	{
		$file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'flytest';
		file_put_contents( $file, 'test' );

		$this->mock->expects( $this->once() )->method( 'putStream' );

		$this->object->writef( 'file', $file );

		unlink( $file );
	}


	public function testWrites()
	{
		$this->mock->expects( $this->once() )->method( 'putStream' )
			->will( $this->returnValue( true ) );

		$this->object->writes( 'test', 1 );
	}


	public function testWritesException()
	{
		$this->mock->expects( $this->once() )->method( 'putStream' )
			->will( $this->returnValue( false ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->writes( 'test', 2 );
	}


	public function testWritesException2()
	{
		$this->mock->expects( $this->once() )->method( 'putStream' )
			->will( $this->throwException( new \Exception() ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->writes( 'test', null );
	}


	public function testMove()
	{
		$this->mock->expects( $this->once() )->method( 'rename' )
			->will( $this->returnValue( true ) );

		$this->object->move( 'file1', 'file2' );
	}


	public function testMoveException()
	{
		$this->mock->expects( $this->once() )->method( 'rename' )
			->will( $this->returnValue( false ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->move( 'file1', 'file2' );
	}


	public function testMoveException2()
	{
		$this->mock->expects( $this->once() )->method( 'rename' )
			->will( $this->throwException( new \Exception() ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->move( 'file1', 'file2' );
	}


	public function testCopy()
	{
		$this->mock->expects( $this->once() )->method( 'copy' )
		->will( $this->returnValue( true ) );

		$this->object->copy( 'file1', 'file2' );
	}


	public function testCopyException()
	{
		$this->mock->expects( $this->once() )->method( 'copy' )
		->will( $this->returnValue( false ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->copy( 'file1', 'file2' );
	}


	public function testCopyException2()
	{
		$this->mock->expects( $this->once() )->method( 'copy' )
		->will( $this->throwException( new \Exception() ) );

		$this->setExpectedException( '\Aimeos\MW\Filesystem\Exception' );
		$this->object->copy( 'file1', 'file2' );
	}
}
