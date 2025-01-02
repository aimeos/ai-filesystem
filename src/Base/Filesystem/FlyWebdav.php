<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2025
 * @package Base
 * @subpackage Filesystem
 */


namespace Aimeos\Base\Filesystem;

use League\Flysystem\Filesystem;
use League\Flysystem\WebDAV\WebDAVAdapter;


/**
 * Implementation of Flysystem WebDAV file system adapter
 *
 * @package Base
 * @subpackage Filesystem
 */
class FlyWebdav extends FlyBase implements Iface, DirIface, MetaIface
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

			if( !isset( $config['baseUri'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'baseUri' ) );
			}

			$client = new \Sabre\DAV\Client( $config );
			$this->fs = new Filesystem( new WebDAVAdapter( $client ) );
		}

		return $this->fs;
	}
}
