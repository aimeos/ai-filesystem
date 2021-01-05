<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2021
 * @package MW
 * @subpackage Filesystem
 */


namespace Aimeos\MW\Filesystem;

use Aws\S3\S3Client;
use League\Flysystem\Filesystem;
use League\Flysystem\AwsS3v3\AwsS3Adapter;


/**
 * Implementation of Flysystem AWS file system adapter
 *
 * @package MW
 * @subpackage Filesystem
 */
class FlyAwsS3 extends FlyBase implements Iface, DirIface, MetaIface
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

			if( !isset( $config['bucket'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'bucket' ) );
			}

			$prefix = ( isset( $config['prefix'] ) ? $config['prefix'] : null );

			$client = S3Client::factory( $config );
			$adapter = new AwsS3Adapter( $client, $config['bucket'], $prefix );
			$this->fs = new Filesystem( $adapter );
		}

		return $this->fs;
	}
}
