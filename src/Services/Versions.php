<?php

declare(strict_types=1);

namespace Avtocod\Specifications\Services;

use Composer\InstalledVersions;

/**
 * Wrapper for Composer runtime utility `InstalledVersions`.
 */
final class Versions
{
    /**
     * Returns the full version of the specified package as `v1.4.0@5a29c10`.
     *
     * @param string $packageName
     *
     * @return string
     */
    public static function getVersion(string $packageName): string
    {
        return InstalledVersions::getPrettyVersion($packageName) . '@' . InstalledVersions::getReference($packageName);
    }
}
