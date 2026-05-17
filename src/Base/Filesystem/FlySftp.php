<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2026
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
				// @phpstan-ignore argument.type
				$config['host'],
				// @phpstan-ignore argument.type
				$config['username'],
				// @phpstan-ignore argument.type
				$config['password'] ?? null,
				// @phpstan-ignore argument.type
				$config['privateKey'] ?? null,
				// @phpstan-ignore argument.type
				$config['passphrase'] ?? null,
				// @phpstan-ignore argument.type
				$config['port'] ?? 22,
				// @phpstan-ignore argument.type
				$config['agent'] ?? false,
				// @phpstan-ignore argument.type
				$config['timeout'] ?? 10,
				// @phpstan-ignore argument.type
				$config['retry'] ?? 4,
				// @phpstan-ignore argument.type
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


			// @phpstan-ignore argument.type
			$this->fs = new Filesystem( new SftpAdapter( $provider, $config['root'], $converter ) );
		}

		return $this->fs;
	}
}
