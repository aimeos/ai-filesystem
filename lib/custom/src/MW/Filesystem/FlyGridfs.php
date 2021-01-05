<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2021
 * @package MW
 * @subpackage Filesystem
 */


namespace Aimeos\MW\Filesystem;

use League\Flysystem\Filesystem;
use League\Flysystem\GridFS\GridFSAdapter;


/**
 * Implementation of Flysystem GridFS file system adapter
 *
 * @package MW
 * @subpackage Filesystem
 */
class FlyGridfs extends FlyBase implements Iface, DirIface, MetaIface
{
	private $fs;


	/**
	 * Returns the file system provider
	 *
	 * @return \League\Flysystem\FilesystemInterface File system provider
	 */
	protected function getProvider()
	{
		if( !isset( $this->fs ) )
		{
			$config = $this->getConfig();

			if( !isset( $config['dbname'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'dbname' ) );
			}

			$client = new \MongoClient();
			$this->fs = new Filesystem( new GridFSAdapter( $client->selectDB( $config['dbname'] )->getGridFS() ) );
		}

		return $this->fs;
	}
}
