<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2021
 * @package MW
 * @subpackage Filesystem
 */


namespace Aimeos\MW\Filesystem;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;


/**
 * Implementation of Flysystem local file system adapter
 *
 * @package MW
 * @subpackage Filesystem
 */
class FlyLocal extends FlyBase implements Iface, DirIface, MetaIface
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

			if( !isset( $config['basedir'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'basedir' ) );
			}

			$adapter = new Local( $config['basedir'], LOCK_EX, Local::SKIP_LINKS, $config );
			$this->fs = new Filesystem( $adapter );
		}

		return $this->fs;
	}
}
