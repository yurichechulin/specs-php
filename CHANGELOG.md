# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog][keepachangelog] and this project adheres to [Semantic Versioning][semver].

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
