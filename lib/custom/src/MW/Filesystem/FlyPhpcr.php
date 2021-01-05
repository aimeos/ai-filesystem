<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2021
 * @package MW
 * @subpackage Filesystem
 */


namespace Aimeos\MW\Filesystem;

use League\Flysystem\Filesystem;
use League\Flysystem\Phpcr\PhpcrAdapter;
use Jackalope\RepositoryFactoryDoctrineDBAL;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\DriverManager;


/**
 * Implementation of Flysystem PHPCR file system adapter
 *
 * @package MW
 * @subpackage Filesystem
 */
class FlyPhpcr extends FlyBase implements Iface, DirIface, MetaIface
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

			if( !isset( $config['root'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'root' ) );
			}

			$conn = DriverManager::getConnection( $config );
			$factory = new RepositoryFactoryDoctrineDBAL();

			$repo = $factory->getRepository( array( 'jackalope.doctrine_dbal_connection' => $conn ) );
			$session = $repo->login( new \PHPCR\SimpleCredentials( null, null ) );

			$this->fs = new Filesystem( new PhpcrAdapter( $session, $config['root'] ) );
		}

		return $this->fs;
	}
}
