<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2023
 * @package Base
 * @subpackage Filesystem
 */


namespace Aimeos\Base\Filesystem;

use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;


/**
 * Implementation of Flysystem local file system adapter
 *
 * @package Base
 * @subpackage Filesystem
 */
class FlyLocal extends FlyBase implements Iface, DirIface, MetaIface
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

			if( !isset( $config['basedir'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'basedir' ) );
			}

			$adapter = new LocalFilesystemAdapter( $config['basedir'] );
			$this->fs = new Filesystem( $adapter );
		}

		return $this->fs;
	}
}
