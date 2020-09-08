<p align="center">
  <img alt="avtocod" src="https://avatars1.githubusercontent.com/u/32733112?s=70&v=4" width="70" height="70" />
</p>

[![Version][badge_packagist_version]][link_packagist]
[![PHP Version][badge_php_version]][link_packagist]
[![Build Status][badge_build_status]][link_build_status]
[![Coverage][badge_coverage]][link_coverage]
[![Downloads count][badge_downloads_count]][link_packagist]
[![License][badge_license]][link_license]

# PHP SDK for [`avtocod/specs`][specs]

This repository contains SDK for data from [`avtocod/specs`][specs] specifications repository.

## Install

Require this package with composer using the following command:

```bash
$ composer require avtocod/specs-php "^1.0"
```

> Installed `composer` is required ([how to install composer][getcomposer]).

> You need to fix the major version of package.

## Usage

```php
use Avtocod\Specifications\Specifications;

// Get specifications (not SDK) version
$version = Specifications::version();

// Get report content (full example)
$report_example = Specifications::getReportExample();

// Get report json-schema (as an object or associative array)
$report_schema = Specifications::getReportJsonSchema();
```

For more examples - look into sources.

### Testing

For package testing we use `phpunit` framework and `docker-ce` + `docker-compose` as develop environment. So, just write into your terminal after repository cloning:

```bash
$ make build
$ make latest # or 'make lowest'
$ make test
```

## Changes log

[![Release date][badge_release_date]][link_releases]
[![Commits since latest release][badge_commits_since_release]][link_commits]

Changes log can be [found here][link_changes_log].

## Support

[![Issues][badge_issues]][link_issues]
[![Issues][badge_pulls]][link_pulls]

If you will find any package errors, please, [make an issue][link_create_issue] in current repository.

## License

This is open-sourced software licensed under the [MIT License][link_license].

[badge_packagist_version]:https://img.shields.io/packagist/v/avtocod/specs-php.svg?maxAge=180
[badge_php_version]:https://img.shields.io/packagist/php-v/avtocod/specs-php.svg?longCache=true
[badge_build_status]:https://img.shields.io/github/workflow/status/avtocod/specs-php/tests/master
[badge_coverage]:https://img.shields.io/codecov/c/github/avtocod/specs-php/master.svg?maxAge=60
[badge_downloads_count]:https://img.shields.io/packagist/dt/avtocod/specs-php.svg?maxAge=180
[badge_license]:https://img.shields.io/packagist/l/avtocod/specs-php.svg?longCache=true
[badge_release_date]:https://img.shields.io/github/release-date/avtocod/specs-php.svg?style=flat-square&maxAge=180
[badge_commits_since_release]:https://img.shields.io/github/commits-since/avtocod/specs-php/latest.svg?style=flat-square&maxAge=180
[badge_issues]:https://img.shields.io/github/issues/avtocod/specs-php.svg?style=flat-square&maxAge=180
[badge_pulls]:https://img.shields.io/github/issues-pr/avtocod/specs-php.svg?style=flat-square&maxAge=180
[link_releases]:https://github.com/avtocod/specs-php/releases
[link_packagist]:https://packagist.org/packages/avtocod/specs-php
[link_build_status]:https://github.com/avtocod/specs-php/actions
[link_coverage]:https://codecov.io/gh/avtocod/specs-php/
[link_changes_log]:https://github.com/avtocod/specs-php/blob/master/CHANGELOG.md
[link_issues]:https://github.com/avtocod/specs-php/issues
[link_create_issue]:https://github.com/avtocod/specs-php/issues/new/choose
[link_commits]:https://github.com/avtocod/specs-php/commits
[link_pulls]:https://github.com/avtocod/specs-php/pulls
[link_license]:https://github.com/avtocod/specs-php/blob/master/LICENSE
[getcomposer]:https://getcomposer.org/download/
[specs]:https://github.com/avtocod/specs
