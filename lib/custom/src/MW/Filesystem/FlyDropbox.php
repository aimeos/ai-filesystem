<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2021
 * @package MW
 * @subpackage Filesystem
 */


namespace Aimeos\MW\Filesystem;

use Dropbox\Client;
use League\Flysystem\Filesystem;
use League\Flysystem\Dropbox\DropboxAdapter;


/**
 * Implementation of Flysystem Dropbox file system adapter
 *
 * @package MW
 * @subpackage Filesystem
 */
class FlyDropbox extends FlyBase implements Iface, DirIface, MetaIface
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

			if( !isset( $config['accesstoken'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'accesstoken' ) );
			}

			if( !isset( $config['appsecret'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'appsecret' ) );
			}

			$prefix = ( isset( $config['prefix'] ) ? $config['prefix'] : null );

			$client = new Client( $config['accesstoken'], $config['appsecret'] );
			$this->fs = new Filesystem( new DropboxAdapter( $client, $prefix ) );
		}

		return $this->fs;
	}
}
