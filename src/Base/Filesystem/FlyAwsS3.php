<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2023
 * @package Base
 * @subpackage Filesystem
 */


namespace Aimeos\Base\Filesystem;

use Aws\S3\S3Client;
use League\Flysystem\Filesystem;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;


/**
 * Implementation of Flysystem AWS file system adapter
 *
 * @package Base
 * @subpackage Filesystem
 */
class FlyAwsS3 extends FlyBase implements Iface, DirIface, MetaIface
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

			if( !isset( $config['bucket'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'bucket' ) );
			}

			$client = S3Client::factory( $config );
			$adapter = new AwsS3V3Adapter( $client, $config['bucket'], $config['prefix'] ?? '' );
			$this->fs = new Filesystem( $adapter );
		}

		return $this->fs;
	}
}
