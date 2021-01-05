<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2021
 * @package MW
 * @subpackage Filesystem
 */


namespace Aimeos\MW\Filesystem;


/**
 * Implementation of Flysystem file system adapter
 *
 * @package MW
 * @subpackage Filesystem
 */
abstract class FlyBase implements Iface, DirIface, MetaIface
{
	private $config;
	private $tempdir;


	/**
	 * Initializes the object
	 *
	 * @param array $config Configuration options
	 */
	public function __construct( array $config )
	{
		$this->config = $config;

		if( !isset( $config['tempdir'] ) ) {
			$config['tempdir'] = sys_get_temp_dir();
		}

		if( !is_dir( $config['tempdir'] ) && mkdir( $config['tempdir'], 0755, true ) === false ) {
			throw new Exception( sprintf( 'Directory "%1$s" could not be created', $config['tempdir'] ) );
		}

		$ds = DIRECTORY_SEPARATOR;
		$this->tempdir = realpath( str_replace( '/', $ds, rtrim( $config['tempdir'], '/' ) ) ) . $ds;
	}


	/**
	 * Tests if the given path is a directory
	 *
	 * @param string $path Path to the file or directory
	 * @return bool True if directory, false if not
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function isdir( string $path ) : bool
	{
		$result = $this->getProvider()->getMetadata( $path );

		if( $result['type'] === 'dir' ) {
			return true;
		}

		return false;
	}


	/**
	 * Creates a new directory for the given path
	 *
	 * @param string $path Path to the directory
	 * @return \Aimeos\MW\Filesystem\DirIface Filesystem object for fluent interface
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function mkdir( string $path ) : DirIface
	{
		if( $this->getProvider()->createDir( $path ) === false ) {
			throw new Exception( $path );
		}

		return $this;
	}


	/**
	 * Deletes the directory for the given path
	 *
	 * @param string $path Path to the directory
	 * @return \Aimeos\MW\Filesystem\DirIface Filesystem object for fluent interface
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function rmdir( string $path ) : DirIface
	{
		if( $this->getProvider()->deleteDir( $path ) === false ) {
			throw new Exception( $path );
		}

		return $this;
	}


	/**
	 * Returns an iterator over the entries in the given path
	 *
	 * {@inheritDoc}
	 *
	 * @param string $path Path to the filesystem or directory
	 * @return iterable Iterator over the entries or array with entries
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function scan( string $path = null ) : iterable
	{
		$list = [];

		foreach( $this->getProvider()->listContents( $path ) as $entry ) {
			$list[] = $entry['basename'];
		}

		return $list;
	}


	/**
	 * Returns the file size
	 *
	 * @param string $path Path to the file
	 * @return int Size in bytes
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function size( string $path ) : int
	{
		try {
			$size = $this->getProvider()->getSize( $path );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		if( $size === false ) {
			throw new Exception( $path );
		}

		return $size;
	}


	/**
	 * Returns the Unix time stamp for the file
	 *
	 * @param string $path Path to the file
	 * @return int Unix time stamp in seconds
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function time( string $path ) : int
	{
		try {
			$time = $this->getProvider()->getTimestamp( $path );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		if( $time === false ) {
			throw new Exception( $path );
		}

		return $time;
	}


	/**
	 * Deletes the file for the given path
	 *
	 * @param string $path Path to the file
	 * @return \Aimeos\MW\Filesystem\Iface Filesystem object for fluent interface
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function rm( string $path ) : Iface
	{
		try {
			$this->getProvider()->delete( $path );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		return $this;
	}


	/**
	 * Tests if a file exists at the given path
	 *
	 * @param string $path Path to the file
	 * @return bool True if it exists, false if not
	 */
	public function has( string $path ) : bool
	{
		return $this->getProvider()->has( $path );
	}


	/**
	 * Returns the content of the file
	 *
	 * {@inheritDoc}
	 *
	 * @param string $path Path to the file
	 * @return string File content
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function read( string $path ) : string
	{
		try {
			$content = $this->getProvider()->read( $path );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		if( $content === false ) {
			throw new Exception( $path );
		}

		return $content;
	}


	/**
	 * Reads the content of the remote file and writes it to a local one
	 *
	 * @param string $path Path to the remote file
	 * @return string Path of the local file
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function readf( string $path ) : string
	{
		if( ( $filename = tempnam( $this->tempdir, 'ai-' ) ) === false ) {
			throw new Exception( sprintf( 'Unable to create file in "%1$s"', $this->tempdir ) );
		}

		if( ( $handle = @fopen( $filename, 'w' ) ) === false ) {
			throw new Exception( sprintf( 'Unable to open file "%1$s"', $filename ) );
		}

		$stream = $this->reads( $path );

		if( @stream_copy_to_stream( $stream, $handle ) == false ) {
			throw new Exception( sprintf( 'Couldn\'t copy stream for "%1$s"', $path ) );
		}

		fclose( $stream );
		fclose( $handle );

		return $filename;
	}


	/**
	 * Returns the stream descriptor for the file
	 *
	 * {@inheritDoc}
	 *
	 * @param string $path Path to the file
	 * @return resource File stream descriptor
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function reads( string $path )
	{
		try {
			$handle = $this->getProvider()->readStream( $path );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		if( $handle === false ) {
			throw new Exception( $path );
		}

		return $handle;
	}


	/**
	 * Writes the given content to the file
	 *
	 * {@inheritDoc}
	 *
	 * @param string $path Path to the file
	 * @param string $content New file content
	 * @return \Aimeos\MW\Filesystem\Iface Filesystem object for fluent interface
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function write( string $path, string $content ) : Iface
	{
		try {
			$result = $this->getProvider()->put( $path, $content );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		if( $result === false ) {
			throw new Exception( $path );
		}

		return $this;
	}


	/**
	 * Writes the content of the local file to the remote path
	 *
	 * {@inheritDoc}
	 *
	 * @param string $path Path to the remote file
	 * @param string $file Path to the local file
	 * @return \Aimeos\MW\Filesystem\Iface Filesystem object for fluent interface
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function writef( string $path, string $local ) : Iface
	{
		if( ( $handle = @fopen( $local, 'r' ) ) === false ) {
			throw new Exception( sprintf( 'Unable to open file "%1$s"', $local ) );
		}

		$this->writes( $path, $handle );

		if( is_resource( $handle ) ) {
			fclose( $handle );
		}

		return $this;
	}


	/**
	 * Write the content of the stream descriptor into the remote file
	 *
	 * {@inheritDoc}
	 *
	 * @param string $path Path to the file
	 * @param resource $stream File stream descriptor
	 * @return \Aimeos\MW\Filesystem\Iface Filesystem object for fluent interface
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function writes( string $path, $stream ) : Iface
	{
		try {
			$result = $this->getProvider()->putStream( $path, $stream );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		if( $result === false ) {
			throw new Exception( $path );
		}

		return $this;
	}


	/**
	 * Renames a file, moves it to a new location or both at once
	 *
	 * @param string $from Path to the original file
	 * @param string $to Path to the new file
	 * @return \Aimeos\MW\Filesystem\Iface Filesystem object for fluent interface
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function move( string $from, string $to ) : Iface
	{
		try {
			$result = $this->getProvider()->rename( $from, $to );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		if( $result === false ) {
			throw new Exception( sprintf( 'Error moving "%1$s" to "%2$s"', $from, $to ) );
		}

		return $this;
	}


	/**
	 * Copies a file to a new location
	 *
	 * @param string $from Path to the original file
	 * @param string $to Path to the new file
	 * @return \Aimeos\MW\Filesystem\Iface Filesystem object for fluent interface
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function copy( string $from, string $to ) : Iface
	{
		try {
			$result = $this->getProvider()->copy( $from, $to );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		if( $result === false ) {
			throw new Exception( sprintf( 'Error copying "%1$s" to "%2$s"', $from, $to ) );
		}

		return $this;
	}


	/**
	 * Returns the flysystem adapter
	 *
	 * @return \League\Flysystem\AdapterInterface Flysystem adapter
	 */
	protected function getAdapter()
	{
		return $this->getProvider()->getAdapter();
	}


	/**
	 * Returns the configuration options
	 *
	 * @return array Configuration options
	 */
	protected function getConfig()
	{
		return $this->config;
	}


	/**
	 * Returns the file system provider
	 *
	 * @return \League\Flysystem\FilesystemInterface File system provider
	 */
	abstract protected function getProvider();
}
