<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2025
 * @package Base
 * @subpackage Filesystem
 */


namespace Aimeos\Base\Filesystem;

use League\Flysystem\Filesystem;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;
use Google\Cloud\Storage\StorageClient;


/**
 * Implementation of Flysystem AWS file system adapter
 *
 * @package Base
 * @subpackage Filesystem
 */
class FlyGoogleCloud extends FlyBase implements Iface, DirIface, MetaIface
{
	private ?Filesystem $fs = null;


	/**
	 * Returns the file system provider
	 *
	 * @return \League\Flysystem\Filesystem File system provider
	 */
	protected function getProvider()
	{
		if( !isset( $this->fs ) )
		{
			$config = $this->getConfig();

			if( !isset( $config['bucket'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'bucket' ) );
			}

			$client = new StorageClient( $config );
			$bucket = $client->bucket( $config['bucket'] );
			$adapter = new GoogleCloudStorageAdapter( $bucket, $config['prefix'] ?? '' );
			$this->fs = new Filesystem( $adapter );
		}

		return $this->fs;
	}
}
