<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2021
 * @package MW
 * @subpackage Filesystem
 */


namespace Aimeos\MW\Filesystem;

use WindowsAzure\Common\ServicesBuilder;
use League\Flysystem\Azure\AzureAdapter;
use League\Flysystem\Filesystem;


/**
 * Implementation of Flysystem Azure file system adapter
 *
 * @package MW
 * @subpackage Filesystem
 */
class FlyAzure extends FlyBase implements Iface, DirIface, MetaIface
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

			if( !isset( $config['endpoint'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'endpoint' ) );
			}

			if( !isset( $config['container'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'container' ) );
			}

			$service = ServicesBuilder::getInstance()->createBlobService( $config['endpoint'] );
			$this->fs = new Filesystem( new AzureAdapter( $service, $config['container'] ) );
		}

		return $this->fs;
	}
}
