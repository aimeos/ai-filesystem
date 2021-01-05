<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2021
 * @package MW
 * @subpackage Filesystem
 */


namespace Aimeos\MW\Filesystem;

use League\Flysystem\Filesystem;
use League\Flysystem\WebDAV\WebDAVAdapter;


/**
 * Implementation of Flysystem WebDAV file system adapter
 *
 * @package MW
 * @subpackage Filesystem
 */
class FlyWebdav extends FlyBase implements Iface, DirIface, MetaIface
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
			$prefix = ( isset( $config['prefix'] ) ? $config['prefix'] : null );

			$client = new \Sabre\DAV\Client( $config );
			$this->fs = new Filesystem( new WebDAVAdapter( $client, $prefix ) );
		}

		return $this->fs;
	}
}
