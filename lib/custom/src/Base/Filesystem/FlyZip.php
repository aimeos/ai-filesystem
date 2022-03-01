<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2022
 * @package Base
 * @subpackage Filesystem
 */


namespace Aimeos\Base\Filesystem;

use League\Flysystem\Filesystem;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;
use League\Flysystem\ZipArchive\FilesystemZipArchiveProvider;


/**
 * Implementation of Flysystem Zip archive file system adapter
 *
 * @package Base
 * @subpackage Filesystem
 */
class FlyZip extends FlyBase implements Iface, DirIface, MetaIface
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

			if( !isset( $config['filepath'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'filepath' ) );
			}

			$this->fs = new Filesystem( new ZipArchiveAdapter( new FilesystemZipArchiveProvider( $config['filepath'] ) ) );
		}

		return $this->fs;
	}
}
