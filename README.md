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

Then, install the extension using composer:

```
composer req aimeos/ai-filesystem
```

## Configuration

All file system adapter are configured below the ```resource/fs``` configuration key, e.g. in the resource section of your config file:

```
'resource' => [
	'fs' => [
		// file system adapter specific configuration
	],
],
```

### Amazon S3

Required adapter:

```
composer req league/flysystem-aws-s3-v3
```

Configuration:

```
'fs' => [
	'adapter' => 'FlyAwsS3',
	'credentials' => [
		'key' => 'your-key',
		'secret' => 'your-secret',
	],
	'region' => 'your-region',
	'version' => 'latest|api-version',
	'bucket' => 'your-bucket-name',
	'prefix' => 'your-prefix', // optional
],
```

### Azure

Required adapter (PHP 8.x only):

```
composer req league/flysystem-azure-blob-storage
```

Configuration:

```
'fs' => [
	'adapter' => 'FlyAzure',
	'endpoint' => 'DefaultEndpointsProtocol=https;AccountName=your-account;AccountKey=your-api-key',
	'container' => 'your-container',
	'prefix' => 'your-prefix', // optional
],
```

### Dropbox

Required adapter:

```
composer req spatie/flysystem-dropbox
```

Configuration:

```
'fs' => [
	'adapter' => 'FlyDropbox',
	'accesstoken' => 'your-access-token'
],
```

### FTP

Required adapter:

```
composer req league/flysystem-ftp
```

Configuration:

```
'fs' => [
	'adapter' => 'FlyFtp',
	'host' => 'your-hostname-or-ipaddress',
	'username' => 'your-username',
	'password' => 'your-password',
	'root' => '/path/to/basedir',
	'port' => 21, // optional
	'passive' => true, // optional
	'ssl' => true, // optional
	'timeout' => 30, // optional
	'utf8' => false, // optional
	'transferMode' => FTP_BINARY, // optional
	'systemType' => null, // 'windows' or 'unix'
	'ignorePassiveAddress' => null, // true or false
	'timestampsOnUnixListingsEnabled' => false, // true or false
	'recurseManually' => true // true
],
```

### Google Cloud

Required adapter:

```
composer req league/flysystem-google-cloud-storage
```

Configuration:

```
'fs' => [
	'adapter' => 'FlyGoogleCloud',
	'keyFile' => json_decode(file_get_contents('/path/to/keyfile.json'), true), // alternative
	'keyFilePath' => '/path/to/keyfile.json', // alternative
	'projectId' => 'myProject', // alternative
	'prefix' => 'your-prefix' // optional
],
```

For authentication details, have a look at the [Google Cloud client documentation](https://github.com/googleapis/google-cloud-php/blob/main/AUTHENTICATION.md).

### Local

Configuration:

```
'fs' => [
	'adapter' => 'FlyLocal',
	'basedir' => 'your-basedir-path',
],
```

### Memory

Required adapter:

```
composer req league/flysystem-memory
```

Configuration:

```
'fs' => [
	'adapter' => 'FlyMemory',
],
```

### SFTP

Required adapter:

```
composer req league/flysystem-sftp
```

Configuration:

```
'fs' => [
	'adapter' => 'FlySftp',
	'host' => 'your-hostname-or-ipaddress',
	'port' => 22, // optional
	'username' => 'your-username', // optional
	'password' => 'your-password', // optional
	'privateKey' => 'path/to/or/contents/of/private/key', // optional
	'passphrase' => 'passphrase-for-the-private-key', // optional
	'fingerprint' => 'fingerprint-string', // optional
	'timeout' => 10, // optional
	'retry' => 4, // optional
	'agent' => true // optional
],
```

### WebDAV

Required adapter (PHP 8.x only):

```
composer req league/flysystem-webdav
```

Configuration:

```
'fs' => [
	'adapter' => 'FlyWebdav',
	'baseUri' => 'your-webdav-uri',
	'proxy' => 'your-proxy', // optional
	'userName' => 'your-username', // optional
	'password' => 'your-password', // optional
	'authType' => 'authentication-type', // optional, 1=Basic, 2=Digest, 4=NTLM
	'encoding' => 'encoding-type', // optional, 1=None, 2=Deflate, 4=Gzip, 7=All
	'prefix' => 'your-prefix', // optional
],
```

### Zip archive

Required adapter:

```
composer req league/flysystem-ziparchive
```

Configuration:

```
'fs' => [
	'adapter' => 'FlyZip',
	'filepath' => '/path/to/zipfile',
],
```

## License

The Aimeos filesystem extension is licensed under the terms of the LGPLv3 Open Source license and is available for free.

## Links

* [Web site](https://aimeos.org/)
* [Documentation](https://aimeos.org/docs)
* [Help](https://aimeos.org/help)
* [Issue tracker](https://github.com/aimeos/ai-filesystem/issues)
* [Source code](https://github.com/aimeos/ai-filesystem)
