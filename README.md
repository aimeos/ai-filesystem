<a href="https://aimeos.org/">
    <img src="https://aimeos.org/fileadmin/template/icons/logo.png" alt="Aimeos logo" title="Aimeos" align="right" height="60" />
</a>

# Aimeos file system extension

[![Build Status](https://circleci.com/gh/aimeos/ai-filesystem.svg?style=shield)](https://circleci.com/gh/aimeos/ai-filesystem)
[![Coverage Status](https://coveralls.io/repos/aimeos/ai-filesystem/badge.svg?branch=master)](https://coveralls.io/r/aimeos/ai-filesystem?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/aimeos/ai-filesystem/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/aimeos/ai-filesystem/?branch=master)
[![License](https://poser.pugx.org/aimeos/ai-filesystem/license.svg)](https://packagist.org/packages/aimeos/ai-filesystem)

The Aimeos file system extension contains adapter for storing files in the cloud, on remote servers or other storage facilities.

## Table of contents

- [Installation](#installation)
- [Configuration](#configuration)
- [License](#license)
- [Links](#links)

## Installation

As every Aimeos extension, the easiest way is to install it via [composer](https://getcomposer.org/). If you don't have composer installed yet, you can execute this string on the command line to download it:
```
php -r "readfile('https://getcomposer.org/installer');" | php -- --filename=composer
```

Add the filesystem extension name to the "require" section of your ```composer.json``` (or your ```composer.aimeos.json```, depending on what is available) file:
```
"require": [
    "aimeos/ai-filesystem": "dev-master",
    ...
],
```

Afterwards you only need to execute the composer update command on the command line:
```
composer update
```

These commands will install the Aimeos extension into the extension directory and it will be available immediately.

## Configuration

All file system adapter are configured below the ```resource/fs``` configuration key, e.g. in the resource section of your config file:
```
'resource' => array(
	'fs' => array(
		// file system adapter specific configuration
	),
),
```

### Amazon S3

```
'fs' => array(
	'adapter' => 'FlyAwsS3',
	'credentials' => array(
		'key'    => 'your-key',
		'secret' => 'your-secret',
	),
	'region' => 'your-region',
	'version' => 'latest|api-version',
	'bucket' => 'your-bucket-name',
	'prefix' => 'your-prefix', // optional
),
```

### Azure

```
'fs' => array(
	'adapter' => 'FlyAzure',
	'endpoint' => 'DefaultEndpointsProtocol=https;AccountName=your-account;AccountKey=your-api-key',
	'container' => 'your-container',
),
```

### Copy.com

```
'fs' => array(
	'adapter' => 'FlyCopy',
	'consumerkey' => 'your-consumer-key',
	'consumersecret' => 'your-consumer-secret',
	'accesstoken' => 'your-access-token',
	'tokensecret' => 'your-token-secret',
	'prefix' => 'your-prefix', // optional
),
```

### Dropbox

Visit https://www.dropbox.com/developers/apps and get your "app secret".
You can also generate an OAuth access token for testing by using the Dropbox App Console without going through the authorization steps.

```
'fs' => array(
	'adapter' => 'FlyDropbox',
	'accesstoken' => 'your-access-token',
	'appsecret' => 'your-app-secret',
	'prefix' => 'your-prefix', // optional
),
```

### FTP

```
'fs' => array(
	'adapter' => 'FlyFtp',
	'host' => 'your-hostname-or-ipaddress',
	'username' => 'your-username',
	'password' => 'your-password',
	'port' => 21, // optional
	'root' => '/path/to/basedir', // optional
	'passive' => true, // optional
	'ssl' => true, // optional
	'timeout' => 30, // optional
),
```

### GridFS

```
'fs' => array(
	'adapter' => 'FlyGridfs',
	'dbname' => 'your-database-name',
),
```

### Local

```
'fs' => array(
	'adapter' => 'FlyLocal',
	'basedir' => 'your-basedir-path',
),
```

### Memory

```
'fs' => array(
	'adapter' => 'FlyMemory',
),
```

### None / Blackhole

```
'fs' => array(
	'adapter' => 'FlyNone',
),
```

### PHPCR

Content repository stored in a database. Depending on the driver, you have to use different [DBAL connection settings](http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html).
```
'fs' => array(
	'adapter' => 'FlyPhpcr',
	'root' => 'your-phpcr-root',
	'driver' => 'pdo_sqlite', // can be also pdo_mysql or other database drivers
	'path'   => '/path/to/sqlite.db', // use driver specific DBAL configuration option instead
),
```

### Rackspace

```
'fs' => array(
	'adapter' => 'FlyRackspace',
	'username' => 'your-username',
	'password' => 'your-password',
	'container' => 'your-container',
),
```

### Replicate

```
'fs' => array(
	'adapter' => 'FlyReplicate',
	'source' => array(
		'adapter' => '...', // one of the other supported adapters
		// adapter specific configuration options
	),
	'replica' => array(
		'adapter' => '...', // one of the other supported adapters
		// adapter specific configuration options
	),
),
```

### SFTP

```
'fs' => array(
	'adapter' => 'FlySftp',
    'host' => 'your-hostname-or-ipaddress',
    'port' => 21, // optional
	'username' => 'your-username', // optional
	'password' => 'your-password', // optional
    'privateKey' => 'path/to/or/contents/of/private/key', // optional
    'root' => '/path/to/basedir', // optional
    'timeout' => 10, // optional
),
```

### WebDAV

```
'fs' => array(
	'adapter' => 'FlyWebdav',
    'baseUri' => 'your-webdav-uri',
    'proxy' => 'your-proxy', // optional
	'userName' => 'your-username', // optional
	'password' => 'your-password', // optional
    'authType' => 'authentication-type', // optional, 1=Basic, 2=Digest, 4=NTLM
    'encoding' => 'encoding-type', // optional, 1=None, 2=Deflate, 4=Gzip, 7=All
	'prefix' => 'your-prefix', // optional
),
```

### Zip archive

```
'fs' => array(
	'adapter' => 'FlyZip',
    'filepath' => '/path/to/zipfile',
),
```

## License

The Aimeos filesystem extension is licensed under the terms of the LGPLv3 Open Source license and is available for free.

## Links

* [Web site](https://aimeos.org/)
* [Documentation](https://aimeos.org/docs)
* [Help](https://aimeos.org/help)
* [Issue tracker](https://github.com/aimeos/ai-filesystem/issues)
* [Source code](https://github.com/aimeos/ai-filesystem)
