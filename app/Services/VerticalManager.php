<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use RuntimeException;

/**
 * VerticalManager
 *
 * Resolves vertical configuration by slug.
 * Scans config/verticals/ — each file is one vertical.
 * No hardcoding. Adding a new vertical = adding a new config file.
 */
class VerticalManager
{
    /**
     * Get config for a specific vertical by slug.
     * Throws if the vertical doesn't exist.
     */
    public function get(string $slug): array
    {
        $path = config_path("verticals/{$slug}.php");

        if (! File::exists($path)) {
            throw new RuntimeException("Vertical [{$slug}] is not configured.");
        }

        return require $path;
    }

    /**
     * Get all configured verticals.
     * Returns array of vertical configs, keyed by slug.
     */
    public function all(): array
    {
        $verticals = [];

        foreach (File::files(config_path('verticals')) as $file) {
            $slug = $file->getFilenameWithoutExtension();
            $verticals[$slug] = require $file->getPathname();
        }

        return $verticals;
    }

    /**
     * Check if a vertical has a specific module enabled.
     */
    public function hasModule(string $slug, string $module): bool
    {
        $vertical = $this->get($slug);
        return in_array($module, $vertical['modules'] ?? []);
    }

    /**
     * Get the API client configured for a vertical.
     */
    public function apiClient(string $slug): ApiClient
    {
        $vertical = $this->get($slug);

        return new ApiClient(
            baseUrl: $vertical['api_base'],
            token:   $vertical['token'],
        );
    }
}
