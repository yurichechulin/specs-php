<?php

declare(strict_types=1);

namespace Avtocod\Specifications\Tests\Services;

use JsonException;
use OutOfBoundsException;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;
use Avtocod\Specifications\Services\Versions;

use function json_decode;
use function array_merge;
use function file_get_contents;

/**
 * @group versions
 *
 * @covers \Avtocod\Specifications\Services\Versions
 */
class VersionsTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetValidVersions(): void
    {
        $this->assertNotEmpty($packages = $this->getAllPackagesData());

        foreach ($packages as $package) {
            $this->assertSame(
                $package['version'] . '@' . $package['source']['reference'],
                Versions::getVersion($package['name'])
            );
        }
    }

    /**
     * @return void
     */
    public function testExceptionOnInvalidPackageName(): void
    {
        $this->expectException(OutOfBoundsException::class);

        Versions::getVersion(Str::random() . '/' . Str::random());
    }

    /**
     * Get all packages data from `composer.lock` file.
     *
     * @throws JsonException
     *
     * @return array
     */
    private function getAllPackagesData(): array
    {
        $lock_data = json_decode(
            file_get_contents(__DIR__ . '/../../composer.lock'),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        return array_merge($lock_data['packages'], $lock_data['packages-dev']);
    }
}
