<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
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


	/**
	 * Initializes the object
	 *
	 * @param array $config Configuration options
	 */
	public function __construct( array $config )
	{
		$this->config = $config;
	}


	/**
	 * Tests if the given path is a directory
	 *
	 * @param string $path Path to the file or directory
	 * @return boolean True if directory, false if not
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function isdir( $path )
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
	 * @return void
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function mkdir( $path )
	{
		if( $this->getProvider()->createDir( $path ) === false ) {
			throw new Exception( $path );
		}
	}


	/**
	 * Deletes the directory for the given path
	 *
	 * @param string $path Path to the directory
	 * @return void
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function rmdir( $path )
	{
		if( $this->getProvider()->deleteDir( $path ) === false ) {
			throw new Exception( $path );
		}
	}


	/**
	 * Returns an iterator over the entries in the given path
	 *
	 * {@inheritDoc}
	 *
	 * @param string $path Path to the filesystem or directory
	 * @return \Iterator|array Iterator over the entries or array with entries
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function scan( $path = null )
	{
		$list = array();

		foreach( $this->getProvider()->listContents( $path ) as $entry ) {
			$list[] = $entry['basename'];
		}

		return $list;
	}


	/**
	 * Returns the file size
	 *
	 * @param string $path Path to the file
	 * @return integer Size in bytes
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function size( $path )
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
	 * @return integer Unix time stamp in seconds
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function time( $path )
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
	 * @return void
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function rm( $path )
	{
		try {
			$this->getProvider()->delete( $path );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}
	}


	/**
	 * Tests if a file exists at the given path
	 *
	 * @param string $path Path to the file
	 * @return boolean True if it exists, false if not
	 */
	public function has( $path )
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
	public function read( $path )
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
	 * Returns the stream descriptor for the file
	 *
	 * {@inheritDoc}
	 *
	 * @param string $path Path to the file
	 * @return resource File stream descriptor
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function reads( $path )
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
	 * @return void
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function write( $path, $content )
	{
		try {
			$result = $this->getProvider()->put( $path, $content );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		if( $result === false ) {
			throw new Exception( $path );
		}
	}


	/**
	 * Write the content of the stream descriptor into the remote file
	 *
	 * {@inheritDoc}
	 *
	 * @param string $path Path to the file
	 * @param resource $stream File stream descriptor
	 * @return void
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function writes( $path, $stream )
	{
		try {
			$result = $this->getProvider()->putStream( $path, $stream );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		if( $result === false ) {
			throw new Exception( $path );
		}
	}


	/**
	 * Renames a file, moves it to a new location or both at once
	 *
	 * @param string $from Path to the original file
	 * @param string $to Path to the new file
	 * @return void
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function move( $from, $to )
	{
		try {
			$result = $this->getProvider()->rename( $from, $to );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		if( $result === false ) {
			throw new Exception( sprintf( 'Error moving "%1$s" to "%2$s"', $from, $to ) );
		}
	}


	/**
	 * Copies a file to a new location
	 *
	 * @param string $from Path to the original file
	 * @param string $to Path to the new file
	 * @return void
	 * @throws \Aimeos\MW\Filesystem\Exception If an error occurs
	 */
	public function copy( $from, $to )
	{
		try {
			$result = $this->getProvider()->copy( $from, $to );
		} catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), 0, $e );
		}

		if( $result === false ) {
			throw new Exception( sprintf( 'Error copying "%1$s" to "%2$s"', $from, $to ) );
		}
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
	protected abstract function getProvider();
}
