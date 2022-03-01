<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2022
 * @package Base
 * @subpackage Filesystem
 */


namespace Aimeos\Base\Filesystem;

use League\Flysystem\Filesystem;
use League\Flysystem\PhpseclibV2\SftpAdapter;
use League\Flysystem\PhpseclibV2\SftpConnectionProvider;
use League\Flysystem\UnixVisibility\PortableVisibilityConverter;


/**
 * Implementation of Flysystem SFTP file system adapter
 *
 * @package Base
 * @subpackage Filesystem
 */
class FlySftp extends FlyBase implements Iface, DirIface, MetaIface
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

			if( !isset( $config['host'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'host' ) );
			}

			if( !isset( $config['username'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'username' ) );
			}

			if( !isset( $config['root'] ) ) {
				throw new Exception( sprintf( 'Configuration option "%1$s" missing', 'root' ) );
			}

			$provider = new SftpConnectionProvider(
				$config['host'],
				$config['username'],
				$config['password'] ?? null,
				$config['privateKey'] ?? null,
				$config['passphrase'] ?? null,
				$config['port'] ?? 22,
				$config['agent'] ?? false,
				$config['timeout'] ?? 10,
				$config['retry'] ?? 4,
				$config['fingerprint'] ?? null
			);

			$converter = PortableVisibilityConverter::fromArray( [
				'file' => [
					'public' => 0640,
					'private' => 0604,
				],
				'dir' => [
					'public' => 0740,
					'private' => 7604,
				],
			] );


			$this->fs = new Filesystem( new SftpAdapter( $provider, $config['root'], $converter ) );
		}

		return $this->fs;
	}
}
