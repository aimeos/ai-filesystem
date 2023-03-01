<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2023
 * @package Base
 * @subpackage Filesystem
 */


namespace Aimeos\Base\Filesystem;

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use League\Flysystem\AzureBlobStorage\AzureBlobStorageAdapter;
use League\Flysystem\Filesystem;


/**
 * Implementation of Flysystem Azure file system adapter
 *
 * @package Base
 * @subpackage Filesystem
 */
class FlyAzure extends FlyBase implements Iface, DirIface, MetaIface
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

			if( !isset( $config['endpoint'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'endpoint' ) );
			}

			if( !isset( $config['container'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'container' ) );
			}

			$service = BlobRestProxy::createBlobService( $config['endpoint'] );
			$adapter = new AzureBlobStorageAdapter( $service, $config['container'], $config['prefix'] ?? '' );
			$this->fs = new Filesystem( $adapter );
		}

		return $this->fs;
	}
}
