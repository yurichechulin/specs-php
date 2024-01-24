# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog][keepachangelog] and this project adheres to [Semantic Versioning][semver].

## v1.8.0

### Added

- `Laravel 10` support
- `PHP Unit 10` support

### Changed

- Minimal PHP version now is `8.0.2`
- Minimal Laravel version now is `9.0`
- Minimal `phpunit/phpunit` version now is `9.6`
- Minimal `phpstan/phpstan` version now is `1.10`
- Version of `composer` in docker container updated up to `2.6.6`

## v1.7.0

### Added

- Support Laravel `9.x`

### Changed

- Version of php in docker container updated up to `8.0`

## v1.6.0

### Added

- Support for PHP version `8.0`

### Changed

- Package `phpstan/phpstan` is fixed at `0.12.99`
- Updated environment (`Dockerfile`) for local development & tests (`php:7.4.29-alpine3.15`, `composer:2.3.5`, `xdebug-3.1.4`)

## v1.5.0

### Changed

- Composer version updated from `v1` to `v2` at CI
- Package `ocramius/package-versions` replaced to internal service `Versions`

## v1.4.0

### Changed

- Minimal required PHP version now is `7.3`

### Removed

- Dependency `tarampampam/wrappers-php`

## v1.3.0

### Changed

- Dependency `avtocod/specs` version `~3.70` is supported now

## v1.2.0

### Added

- Class `Avtocod\Specifications\Structures\VehicleBodyType` for object representation of vehicle body type specifications
- Class `Avtocod\Specifications\Structures\VehicleEngineType` for object representation of vehicle engine type specifications
- Class `Avtocod\Specifications\Structures\VehicleSteeringWheelType` for object representation of vehicle steering wheel specifications
- Class `Avtocod\Specifications\Structures\VehicleTransmissionType` for object representation of vehicle transmission type specifications
- Class `Avtocod\Specifications\Structures\VehicleDrivingWheelsType` for object representation of vehicle driving wheels type specifications

### Changed

- Replaced usage `assertEquals()` by `assertSame()` in unit-tests

## v1.1.0

### Changed

- Dependency `illuminate/support` version `~8.0` is supported now
- Minimal required `illuminate/support` version now is `6.0` (instead `^5.6`)
- Dependency `tarampampam/wrappers-php` version `~2.0` is supported now

## v1.0.0

### Added

- Class `Avtocod\Specifications\Specifications` for access to specifications, report examples and json-schemas
- Class `Avtocod\Specifications\Specifications\Field` for object representation of fields specifications
- Class `Avtocod\Specifications\Specifications\IdentifierType` for object representation of identifiers types specifications
- Class `Avtocod\Specifications\Specifications\Source` for object representation of sources specifications
- Class `Avtocod\Specifications\Specifications\VehicleMark` for object representation of vehicle marks specifications
- Class `Avtocod\Specifications\Specifications\VehicleModel` for object representation of vehicle models specifications
- Class `Avtocod\Specifications\Specifications\VehicleType` for object representation of vehicle types specifications
- Github actions workflow for unit-tests
- Dependency `avtocod/specs:~3.46`

[keepachangelog]:https://keepachangelog.com/en/1.0.0/
[semver]:https://semver.org/spec/v2.0.0.html
