<?php

declare(strict_types=1);

namespace Avtocod\Specifications\Tests\Services;

use OutOfBoundsException;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;
use Avtocod\Specifications\Services\Versions;

use function json_decode;
use function array_merge;
use function file_get_contents;

/**
 * @group Services
 * @group Services_Versions
 *
 * @covers \Avtocod\Specifications\Services\Versions<extended>
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
     * @return array
     */
    private function getAllPackagesData(): array
    {
        $lock_data = json_decode(file_get_contents(__DIR__ . '/../../composer.lock'), true);

        return array_merge($lock_data['packages'], $lock_data['packages-dev']);
    }
}
