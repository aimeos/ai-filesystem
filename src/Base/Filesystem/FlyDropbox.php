<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2022
 * @package Base
 * @subpackage Filesystem
 */


namespace Aimeos\Base\Filesystem;

use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;
use League\Flysystem\Filesystem;


/**
 * Implementation of Flysystem Dropbox file system adapter
 *
 * @package Base
 * @subpackage Filesystem
 */
class FlyDropbox extends FlyBase implements Iface, DirIface, MetaIface
{
	private $fs;


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

			if( !isset( $config['accesstoken'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'accesstoken' ) );
			}

			$client = new Client( $config['accesstoken'] );
			$this->fs = new Filesystem( $adapter = new DropboxAdapter( $client ), ['case_sensitive' => false] );
		}

		return $this->fs;
	}
}
