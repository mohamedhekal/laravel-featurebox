<?php

namespace MohamedHekal\LaravelFeatureBox\Contracts;

interface FeatureBoxInterface
{
    /**
     * Check if a feature is enabled.
     */
    public function isEnabled(string $feature, array $context = []): bool;

    /**
     * Check if a feature is disabled.
     */
    public function isDisabled(string $feature, array $context = []): bool;

    /**
     * Enable a feature.
     */
    public function enable(string $feature, array $conditions = []): bool;

    /**
     * Disable a feature.
     */
    public function disable(string $feature): bool;

    /**
     * Get all features.
     */
    public function all(): array;

    /**
     * Get a specific feature.
     */
    public function get(string $feature): ?array;
}
