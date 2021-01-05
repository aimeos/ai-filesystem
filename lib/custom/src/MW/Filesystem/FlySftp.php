<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2021
 * @package MW
 * @subpackage Filesystem
 */


namespace Aimeos\MW\Filesystem;

use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;


/**
 * Implementation of Flysystem SFTP file system adapter
 *
 * @package MW
 * @subpackage Filesystem
 */
class FlySftp extends FlyBase implements Iface, DirIface, MetaIface
{
	private $fs;


	/**
	 * Returns the file system provider
	 *
	 * @return \League\Flysystem\FilesystemInterface File system provider
	 */
	protected function getProvider()
	{
		if( !isset( $this->fs ) ) {
			$this->fs = new Filesystem( new SftpAdapter( $this->getConfig() ) );
		}

		return $this->fs;
	}
}
