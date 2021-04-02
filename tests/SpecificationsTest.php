<?php

declare(strict_types=1);

namespace Avtocod\Specifications\Tests;

use Exception;
use ReflectionClass;
use ReflectionMethod;
use InvalidArgumentException;
use PackageVersions\Versions;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;
use Avtocod\Specifications\Specifications;
use Avtocod\Specifications\Structures\Field;
use Avtocod\Specifications\Structures\Source;
use Avtocod\Specifications\Structures\VehicleMark;
use Avtocod\Specifications\Structures\VehicleType;
use Avtocod\Specifications\Structures\VehicleModel;
use Avtocod\Specifications\Structures\IdentifierType;
use Avtocod\Specifications\Structures\VehicleBodyType;
use Avtocod\Specifications\Structures\VehicleEngineType;
use Avtocod\Specifications\Structures\VehicleTransmissionType;
use Avtocod\Specifications\Structures\VehicleDrivingWheelsType;
use Avtocod\Specifications\Structures\VehicleSteeringWheelType;

/**
 * @covers \Avtocod\Specifications\Specifications<extended>
 */
class SpecificationsTest extends TestCase
{
    /**
     * @var Specifications
     */
    protected $instance;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->instance  = new Specifications;
    }

    /**
     * Test constants.
     *
     * @return void
     */
    public function testConstants(): void
    {
        $this->assertSame('avtocod/specs', Specifications::AVTOCOD_SPECS_PACKAGE_NAME);
        $this->assertSame('default', Specifications::GROUP_NAME_DEFAULT);
        $this->assertSame('ID_TYPE_CAR', Specifications::VEHICLE_TYPE_DEFAULT);
    }

    /**
     * @return void
     */
    public function testGetRootDirectoryPath(): void
    {
        $reflection = new \ReflectionClass(\Composer\Autoload\ClassLoader::class);
        $vendor_dir = \dirname((string) $reflection->getFileName(), 2);
        $root       = $vendor_dir . \DIRECTORY_SEPARATOR . $this->instance::AVTOCOD_SPECS_PACKAGE_NAME;

        $this->assertSame($root, $this->instance::getRootDirectoryPath());
        $this->assertSame($root . \DIRECTORY_SEPARATOR . 'foo', $this->instance::getRootDirectoryPath('foo'));
        $this->assertSame($root . \DIRECTORY_SEPARATOR . 'foo', $this->instance::getRootDirectoryPath(' /foo'));
    }

    /**
     * @return void
     */
    public function testGetFieldsSpecification(): void
    {
        foreach (['default', null] as $group_name) {
            $result  = $this->instance::getFieldsSpecification($group_name);
            $this->assertInstanceOf(Collection::class, $result);

            foreach ($result as $item) {
                $this->assertInstanceOf(Field::class, $item);
            }

            $raw = \json_decode(\file_get_contents($this->instance::getRootDirectoryPath(
                '/fields/default/fields_list.json'
            )), true);

            $this->assertCount(\count($raw), $result);

            foreach ($raw as $i => $field_data) {
                $this->assertSame($path = $field_data['path'], $result[$i]->getPath());
                $this->assertSame($field_data['description'], $result[$i]->getDescription());
                $this->assertSame($field_data['types'], $result[$i]->getTypes());
                $this->assertSame(
                    $fillable_by = $field_data['fillable_by'],
                    $result[$i]->getFillableBy(),
                    "{$path} has no 'fillable_by' attribute"
                );

                $this->assertIsArray($fillable_by);
            }
        }
    }

    /**
     * @return void
     */
    public function testGetFieldsJsonSchema(): void
    {
        foreach (['default', null] as $group_name) {
            $this->assertIsObject($as_object = $this->instance::getFieldsJsonSchema($group_name));
            $this->assertIsArray($this->instance::getFieldsJsonSchema($group_name, true));
        }
    }

    /**
     * @return void
     */
    public function testGetReportExample(): void
    {
        foreach (['default', null] as $group_name) {
            foreach (['full', 'empty'] as $name) {
                $result = $this->instance::getReportExample($group_name, $name);
                $this->assertIsArray($result);

                $raw = \json_decode(\file_get_contents($this->instance::getRootDirectoryPath(
                    "/reports/default/examples/{$name}.json"
                )), true);

                $this->assertSame($result, $raw);
            }
        }
    }

    /**
     * @return void
     */
    public function testGetReportExampleWithInvalidGroupName(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessageRegExp('~file.+was not found~i');

        $this->instance::getReportExample('foo bar');
    }

    /**
     * @return void
     */
    public function testGetReportJsonSchema(): void
    {
        foreach (['default', null] as $group_name) {
            $this->assertIsObject($as_object = $this->instance::getReportJsonSchema($group_name));
            $this->assertIsArray($this->instance::getReportJsonSchema($group_name, true));
        }
    }

    /**
     * @return void
     */
    public function testGetIdentifierTypesSpecification(): void
    {
        foreach (['default', null] as $group_name) {
            $result = $this->instance::getIdentifierTypesSpecification($group_name);
            $this->assertInstanceOf(Collection::class, $result);

            foreach ($result as $item) {
                $this->assertInstanceOf(IdentifierType::class, $item);
            }

            $raw = \json_decode(\file_get_contents($this->instance::getRootDirectoryPath(
                '/identifiers/default/types_list.json'
            )), true);

            $this->assertCount(\count($raw), $result);

            foreach ($raw as $identifier_data) {
                $type = $identifier_data['type'];

                $this->assertSame($identifier_data['description'], $result[$type]->getDescription());
                $this->assertSame($identifier_data['type'], $result[$type]->getType());
            }
        }
    }

    /**
     * Test `getIdentifierTypesSpecification()` method exception throwing.
     *
     * @return void
     */
    public function testGetIdentifierTypesSpecificationWithInvalidGroupName(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessageRegExp('~file.+was not found~i');

        $this->instance::getIdentifierTypesSpecification('foo bar');
    }

    /**
     * @return void
     */
    public function testGetIdentifierTypesJsonSchema(): void
    {
        foreach (['default', null] as $group_name) {
            $this->assertIsObject($as_object = $this->instance::getIdentifierTypesJsonSchema($group_name));
            $this->assertIsArray($this->instance::getIdentifierTypesJsonSchema($group_name, true));
        }
    }

    /**
     * @return void
     */
    public function testVersion(): void
    {
        $this->assertSame(
            $version = Versions::getVersion($this->instance::AVTOCOD_SPECS_PACKAGE_NAME),
            $this->instance::version(false)
        );

        $this->assertSame(\mb_substr($version, 0, (int) \mb_strpos($version, '@')), $this->instance::version());
    }

    /**
     * @return void
     */
    public function testGetFieldsSpecificationWithInvalidGroupName(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessageRegExp('~file.+was not found~i');

        $this->instance::getFieldsSpecification('foo bar');
    }

    /**
     * @return void
     */
    public function testGetSourcesSpecification(): void
    {
        foreach (['default', null] as $group_name) {
            $result = $this->instance::getSourcesSpecification($group_name);
            $this->assertInstanceOf(Collection::class, $result);

            foreach ($result as $item) {
                $this->assertInstanceOf(Source::class, $item);
            }

            $raw = \json_decode(\file_get_contents($this->instance::getRootDirectoryPath(
                '/sources/default/sources_list.json'
            )), true);

            $this->assertCount(\count($raw), $result);

            foreach ($raw as $source_data) {
                $name = $source_data['name'];

                $this->assertSame($source_data['name'], $result[$name]->getName());
                $this->assertSame($source_data['description'], $result[$name]->getDescription());
            }
        }
    }

    /**
     * @return void
     */
    public function testGetSourcesJsonSchema(): void
    {
        foreach (['default', null] as $group_name) {
            $this->assertIsObject($as_object = $this->instance::getSourcesJsonSchema($group_name));
            $this->assertIsArray($this->instance::getSourcesJsonSchema($group_name, true));
        }
    }

    /**
     * @return void
     */
    public function testGetVehiclesMarksSpecification(): void
    {
        foreach (['default', null] as $group_name) {
            $result = $this->instance::getVehicleMarksSpecification($group_name);
            $this->assertInstanceOf(Collection::class, $result);

            foreach ($result as $item) {
                $this->assertInstanceOf(VehicleMark::class, $item);
            }

            $raw = \json_decode(\file_get_contents($this->instance::getRootDirectoryPath(
                '/vehicles/default/marks.json'
            )), true);

            $this->assertCount(count($raw), $result);

            foreach ($raw as $source_data) {
                $mark_id = $source_data['id'];

                $this->assertSame($source_data['id'], $result[$mark_id]->getId());
                $this->assertSame($source_data['name'], $result[$mark_id]->getName());
            }
        }
    }

    /**
     * @return void
     */
    public function testGetVehicleModelsSpecification(): void
    {
        foreach (['default', null] as $group_name) {
            $result = $this->instance::getVehicleModelsSpecification($group_name);
            $this->assertInstanceOf(Collection::class, $result);

            foreach ($result as $item) {
                $this->assertInstanceOf(VehicleModel::class, $item);
            }

            $raw = \json_decode(\file_get_contents($this->instance::getRootDirectoryPath(
                '/vehicles/default/models.json'
            )), true);

            $this->assertCount(count($raw), $result);

            foreach ($raw as $source_data) {
                $model_id = $source_data['id'];

                $this->assertSame($source_data['id'], $result[$model_id]->getId());
                $this->assertSame($source_data['name'], $result[$model_id]->getName());
                $this->assertSame($source_data['mark_id'], $result[$model_id]->getMarkId());
            }
        }
    }

    /**
     * @return void
     */
    public function testGetVehicleModelsByTypeSpecification(): void
    {
        foreach (['default', null] as $group_name) {
            foreach ($this->getVehicleTypeAliasByIdMap() as $vehicle_type => $alias) {
                $result = $this->instance::getVehicleModelsSpecification($group_name, $vehicle_type);
                $this->assertInstanceOf(Collection::class, $result);
                foreach ($result as $item) {
                    $this->assertInstanceOf(VehicleModel::class, $item);
                }
                if ($vehicle_type === Specifications::VEHICLE_TYPE_DEFAULT) {
                    $path_file = '/vehicles/default/models.json';
                } else {
                    $path_file = sprintf('/vehicles/default/models_%s.json', $alias);
                }
                $raw       = \json_decode(
                    \file_get_contents($this->instance::getRootDirectoryPath($path_file)), true
                );
                $this->assertCount(count($raw), $result);

                foreach ($raw as $source_data) {
                    $model_id = $source_data['id'];
                    $this->assertSame($source_data['id'], $result[$model_id]->getId());
                    $this->assertSame($source_data['name'], $result[$model_id]->getName());
                    $this->assertSame($source_data['mark_id'], $result[$model_id]->getMarkId());
                }
            }
        }
    }

    /**
     * @return void
     */
    public function testGetVehicleBodyTypesSpecification(): void
    {
        foreach (['default', null] as $group_name) {
            $result = $this->instance::getVehicleBodyTypesSpecification($group_name);
            $this->assertInstanceOf(Collection::class, $result);

            foreach ($result as $item) {
                $this->assertInstanceOf(VehicleBodyType::class, $item);
            }

            $raw = \json_decode(\file_get_contents($this->instance::getRootDirectoryPath(
                '/vehicles/default/body_types.json'
            )), true);

            $this->assertCount(count($raw), $result);

            foreach ($raw as $source_data) {
                $item_id = $source_data['id'];

                $this->assertSame($source_data['id'], $result[$item_id]->getId());
                $this->assertSame($source_data['name'], $result[$item_id]->getName());
            }
        }
    }

    /**
     * @return void
     */
    public function testGetVehicleDrivingWheelsTypesSpecification(): void
    {
        foreach (['default', null] as $group_name) {
            $result = $this->instance::getVehicleDrivingWheelsTypesSpecification($group_name);
            $this->assertInstanceOf(Collection::class, $result);

            foreach ($result as $item) {
                $this->assertInstanceOf(VehicleDrivingWheelsType::class, $item);
            }

            $raw = \json_decode(\file_get_contents($this->instance::getRootDirectoryPath(
                '/vehicles/default/driving_wheels_types.json'
            )), true);

            $this->assertCount(count($raw), $result);

            foreach ($raw as $source_data) {
                $item_id = $source_data['id'];

                $this->assertSame($source_data['id'], $result[$item_id]->getId());
                $this->assertSame($source_data['name'], $result[$item_id]->getName());
            }
        }
    }

    /**
     * @return void
     */
    public function testGetVehicleEngineTypesSpecification(): void
    {
        foreach (['default', null] as $group_name) {
            $result = $this->instance::getVehicleEngineTypesSpecification($group_name);
            $this->assertInstanceOf(Collection::class, $result);

            foreach ($result as $item) {
                $this->assertInstanceOf(VehicleEngineType::class, $item);
            }

            $raw = \json_decode(\file_get_contents($this->instance::getRootDirectoryPath(
                '/vehicles/default/engine_types.json'
            )), true);

            $this->assertCount(count($raw), $result);

            foreach ($raw as $source_data) {
                $item_id = $source_data['id'];

                $this->assertSame($source_data['id'], $result[$item_id]->getId());
                $this->assertSame($source_data['name'], $result[$item_id]->getName());
            }
        }
    }

    /**
     * @return void
     */
    public function testGetVehicleSteeringWheelTypesSpecification(): void
    {
        foreach (['default', null] as $group_name) {
            $result = $this->instance::getVehicleSteeringWheelTypesSpecification($group_name);
            $this->assertInstanceOf(Collection::class, $result);

            foreach ($result as $item) {
                $this->assertInstanceOf(VehicleSteeringWheelType::class, $item);
            }

            $raw = \json_decode(\file_get_contents($this->instance::getRootDirectoryPath(
                '/vehicles/default/steering_wheel_types.json'
            )), true);

            $this->assertCount(count($raw), $result);

            foreach ($raw as $source_data) {
                $item_id = $source_data['id'];

                $this->assertSame($source_data['id'], $result[$item_id]->getId());
                $this->assertSame($source_data['name'], $result[$item_id]->getName());
            }
        }
    }

    /**
     * @return void
     */
    public function testGetVehicleTransmissionTypesSpecification(): void
    {
        foreach (['default', null] as $group_name) {
            $result = $this->instance::getVehicleTransmissionTypesSpecification($group_name);
            $this->assertInstanceOf(Collection::class, $result);

            foreach ($result as $item) {
                $this->assertInstanceOf(VehicleTransmissionType::class, $item);
            }

            $raw = \json_decode(\file_get_contents($this->instance::getRootDirectoryPath(
                '/vehicles/default/transmission_types.json'
            )), true);

            $this->assertCount(count($raw), $result);

            foreach ($raw as $source_data) {
                $item_id = $source_data['id'];

                $this->assertSame($source_data['id'], $result[$item_id]->getId());
                $this->assertSame($source_data['name'], $result[$item_id]->getName());
            }
        }
    }

    /**
     * @return void
     */
    public function testGetVehicleModelsByTypeSpecificationException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unknown vehicle type identifier [UNKNOWN]');

        $this->instance::getVehicleModelsSpecification(null, 'UNKNOWN');
    }

    /**
     * @return void
     */
    public function testGetVehicleTypeAliasById(): void
    {
        $method_name = 'getVehicleTypeAliasById';
        $method      = $this->getNonPublicMethod(get_class($this->instance), $method_name);

        foreach (['default', null] as $group_name) {
            foreach ($this->getVehicleTypeAliasByIdMap() as $id => $alias) {
                $this->assertSame($alias, $method->invokeArgs($this->instance, [$id, $group_name]));
            }
        }
    }

    /**
     * @return void
     */
    public function testGetVehicleTypeAliasByIdException(): void
    {
        $method_name = 'getVehicleTypeAliasById';
        $method      = $this->getNonPublicMethod(get_class($this->instance), $method_name);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unknown vehicle type identifier [UNKNOWN]');

        $method->invokeArgs($this->instance, ['UNKNOWN', null]);
    }

    public function testGetVehicleModelsSpecificationFilePath(): void
    {
        $method_name = 'getVehicleModelsSpecificationFilePath';
        $method      = $this->getNonPublicMethod(get_class($this->instance), $method_name);

        foreach (['default', 'custom'] as $group_name) {
            foreach ($this->getVehicleModelsFilePathByTypeId($group_name) as $id => $path) {
                $this->assertSame($path, $method->invokeArgs($this->instance, [$id, $group_name]));
            }
        }
    }

    public function testGetVehicleModelsSpecificationFilePathException(): void
    {
        $method_name = 'getVehicleModelsSpecificationFilePath';
        $method      = $this->getNonPublicMethod(get_class($this->instance), $method_name);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unknown vehicle type identifier [UNKNOWN]');

        $method->invokeArgs($this->instance, ['UNKNOWN', 'default']);
    }

    /**
     * @return void
     */
    public function testGetVehicleTypesSpecification(): void
    {
        foreach (['default', null] as $group_name) {
            $result = $this->instance::getVehicleTypesSpecification($group_name);
            $this->assertInstanceOf(Collection::class, $result);

            foreach ($result as $item) {
                $this->assertInstanceOf(VehicleType::class, $item);
            }

            $raw = \json_decode(\file_get_contents($this->instance::getRootDirectoryPath(
                '/vehicles/default/types.json'
            )), true);

            $this->assertCount(count($raw), $result);

            foreach ($raw as $source_data) {
                $type_id = $source_data['id'];

                $this->assertSame($source_data['id'], $result[$type_id]->getId());
                $this->assertSame($source_data['name'], $result[$type_id]->getName());
            }
        }
    }

    /**
     * @return void
     */
    public function testGetSourcesSpecificationWithInvalidGroupName(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessageRegExp('~file.+was not found~i');

        $this->instance::getSourcesSpecification('foo bar');
    }

    /**
     * @return void
     */
    public function testGetJsonFileContent(): void
    {
        $method_name = 'getJsonFileContent';
        $method      = $this->getNonPublicMethod(get_class($this->instance), $method_name);

        $path = $this->instance::getRootDirectoryPath('/vehicles/default/types.json');
        $this->assertIsArray($method->invokeArgs($this->instance, [$path, true]));
        $this->assertIsObject($method->invokeArgs($this->instance, [$path, false]));

        $wrong_path = $this->instance::getRootDirectoryPath('/not_exists.json');
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("File [{$wrong_path}] was not found");
        $method->invokeArgs($this->instance, [$wrong_path, true]);
    }

    /**
     * Return vehicle type aliases mapped to vehicle type ids.
     *
     * @return array
     */
    protected function getVehicleTypeAliasByIdMap(): array
    {
        return [
            'ID_TYPE_AGRICULTURAL' => 'agricultural',
            'ID_TYPE_ARTIC'        => 'artic',
            'ID_TYPE_ATV'          => 'atv',
            'ID_TYPE_AUTOLOADER'   => 'autoloader',
            'ID_TYPE_BULLDOZER'    => 'bulldozer',
            'ID_TYPE_BUS'          => 'bus',
            'ID_TYPE_CAR'          => 'car',
            'ID_TYPE_CONSTRUCTION' => 'construction',
            'ID_TYPE_CRANE'        => 'crane',
            'ID_TYPE_SELF_LOADER'  => 'self_loader',
            'ID_TYPE_DREDGE'       => 'dredge',
            'ID_TYPE_LIGHT_TRUCK'  => 'light_truck',
            'ID_TYPE_MOTORCYCLE'   => 'motorcycle',
            'ID_TYPE_MUNICIPAL'    => 'municipal',
            'ID_TYPE_SCOOTER'      => 'scooter',
            'ID_TYPE_SNOWMOBILE'   => 'snowmobile',
            'ID_TYPE_TRAILER'      => 'trailer',
            'ID_TYPE_TRUCK'        => 'truck',
        ];
    }

    /**
     * Return vehicle models specs files paths mapped to vehicle type id.
     *
     * @example
     * [
     *      ...
     *      'ID_TYPE_CAR' => '/vehicles/default/models.json',
     *      'ID_TYPE_SCOOTER' => '/vehicles/default/models_scooter.json',
     *      ...
     * ]
     *
     * @param string $group_name
     *
     * @return array
     */
    protected function getVehicleModelsFilePathByTypeId(?string $group_name = null): array
    {
        $group_name = $group_name ?? 'default';

        $alias_map = $this->getVehicleTypeAliasByIdMap();

        $file_paths = [];

        foreach ($alias_map as $id => $alias) {
            if ($id === Specifications::VEHICLE_TYPE_DEFAULT) {
                $file_paths[$id] = "/vehicles/{$group_name}/models.json";
            } else {
                $file_paths[$id] = "/vehicles/{$group_name}/models_{$alias}.json";
            }
        }

        return $file_paths;
    }

    /**
     * Make accessible non public method and return it.
     *
     * @param string $class_name
     * @param string $method_name
     *
     * @return ReflectionMethod
     */
    protected function getNonPublicMethod(string $class_name, string $method_name): ReflectionMethod
    {
        $class  = new ReflectionClass($class_name);
        $method = $class->getMethod($method_name);
        $method->setAccessible(true);

        return $method;
    }
}
