<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2021
 * @package MW
 * @subpackage Filesystem
 */


namespace Aimeos\MW\Filesystem;

use OpenCloud\OpenStack;
use OpenCloud\Rackspace;
use League\Flysystem\Filesystem;
use League\Flysystem\Rackspace\RackspaceAdapter;


/**
 * Implementation of Flysystem Rackspace file system adapter
 *
 * @package MW
 * @subpackage Filesystem
 */
class FlyRackspace extends FlyBase implements Iface, DirIface, MetaIface
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

			if( !isset( $config['container'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'container' ) );
			}

			$client = new OpenStack( Rackspace::UK_IDENTITY_ENDPOINT, $config );
			$container = $client->objectStoreService( 'cloudFiles', 'LON' )->getContainer( $config['container'] );
			$this->fs = new Filesystem( new RackspaceAdapter( $container ) );
		}

		return $this->fs;
	}
}
