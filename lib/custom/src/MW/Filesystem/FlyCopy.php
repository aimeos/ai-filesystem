<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package MW
 * @subpackage Filesystem
 */


namespace Aimeos\MW\Filesystem;

use Barracuda\Copy\API;
use League\Flysystem\Filesystem;
use League\Flysystem\Copy\CopyAdapter;


/**
 * Implementation of Flysystem Copy.com file system adapter
 *
 * @package MW
 * @subpackage Filesystem
 */
class FlyCopy extends FlyBase implements Iface, DirIface, MetaIface
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

			if( !isset( $config['consumerkey'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'consumerkey' ) );
			}

			if( !isset( $config['consumersecret'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'consumersecret' ) );
			}

			if( !isset( $config['accesstoken'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'accesstoken' ) );
			}

			if( !isset( $config['tokensecret'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'tokensecret' ) );
			}

			$prefix = ( isset( $config['prefix'] ) ? $config['prefix'] : null );

			$client = new API( $config['consumerkey'], $config['consumersecret'], $config['accesstoken'], $config['tokensecret'] );
			$this->fs = new Filesystem( new CopyAdapter( $client, $prefix ) );
		}

		return $this->fs;
	}
}
