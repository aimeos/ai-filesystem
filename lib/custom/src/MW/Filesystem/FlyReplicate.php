<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2021
 * @package MW
 * @subpackage Filesystem
 */


namespace Aimeos\MW\Filesystem;

use League\Flysystem\Filesystem;
use League\Flysystem\Replicate\ReplicateAdapter;


/**
 * Implementation of Flysystem Replicate file system adapter
 *
 * @package MW
 * @subpackage Filesystem
 */
class FlyReplicate extends FlyBase implements Iface, DirIface, MetaIface
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

			if( !isset( $config['source'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'source' ) );
			}

			if( !isset( $config['replica'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'replica' ) );
			}

			$source = Factory::create( (array) $config['source'] )->getAdapter();
			$replica = Factory::create( (array) $config['replica'] )->getAdapter();
			$this->fs = new Filesystem( new ReplicateAdapter( $source, $replica ) );
		}

		return $this->fs;
	}
}
