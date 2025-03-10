<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2025
 * @package Base
 * @subpackage Filesystem
 */


namespace Aimeos\Base\Filesystem;

use League\Flysystem\Filesystem;
use League\Flysystem\Ftp\FtpAdapter;


/**
 * Implementation of Flysystem FTP file system adapter
 *
 * @package Base
 * @subpackage Filesystem
 */
class FlyFtp extends FlyBase implements Iface, DirIface, MetaIface
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
			$options = \League\Flysystem\Ftp\FtpConnectionOptions::fromArray( $this->getConfig() );
			$this->fs = new Filesystem( new FtpAdapter( $options ) );
		}

		return $this->fs;
	}
}
