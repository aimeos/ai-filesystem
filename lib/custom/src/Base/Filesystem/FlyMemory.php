<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2022
 * @package Base
 * @subpackage Filesystem
 */


namespace Aimeos\Base\Filesystem;

use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;


/**
 * Implementation of Flysystem memory file system adapter
 *
 * @package Base
 * @subpackage Filesystem
 */
class FlyMemory extends FlyBase implements Iface, DirIface, MetaIface
{
	private $fs;


	/**
	 * Returns the file system provider
	 *
	 * @return \League\Flysystem\FilesystemInterface File system provider
	 */
	protected function getProvider()
	{
		if( !isset( $this->fs ) ) {
			$this->fs = new Filesystem( new MemoryAdapter() );
		}

		return $this->fs;
	}
}