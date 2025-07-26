<?php

namespace MohamedHekal\LaravelFeatureBox;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use MohamedHekal\LaravelFeatureBox\Contracts\FeatureBoxInterface;

class FeatureBox implements FeatureBoxInterface
{
    /**
     * Check if a feature is enabled.
     */
    public function isEnabled(string $feature, array $context = []): bool
    {
        $featureData = $this->get($feature);

        if (! $featureData) {
            return false;
        }

        if (! $featureData['is_enabled']) {
            return false;
        }

        // Check conditions if any
        if (! empty($featureData['conditions'])) {
            return $this->evaluateConditions($featureData['conditions'], $context);
        }

        return true;
    }

    /**
     * Check if a feature is disabled.
     */
    public function isDisabled(string $feature, array $context = []): bool
    {
        return ! $this->isEnabled($feature, $context);
    }

    /**
     * Enable a feature.
     */
    public function enable(string $feature, array $conditions = []): bool
    {
        try {
            DB::table('features')->updateOrInsert(
                ['name' => $feature],
                [
                    'is_enabled' => true,
                    'conditions' => json_encode($conditions),
                    'updated_at' => now(),
                ]
            );

            $this->clearCache();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Disable a feature.
     */
    public function disable(string $feature): bool
    {
        try {
            DB::table('features')
                ->where('name', $feature)
                ->update([
                    'is_enabled' => false,
                    'updated_at' => now(),
                ]);

            $this->clearCache();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get all features.
     */
    public function all(): array
    {
        return Cache::remember('featurebox.all', 300, function () {
            return DB::table('features')
                ->select('name', 'is_enabled', 'conditions', 'created_at', 'updated_at')
                ->get()
                ->map(function ($feature) {
                    return [
                        'name' => $feature->name,
                        'is_enabled' => (bool) $feature->is_enabled,
                        'conditions' => json_decode($feature->conditions, true) ?: [],
                        'created_at' => $feature->created_at,
                        'updated_at' => $feature->updated_at,
                    ];
                })
                ->toArray();
        });
    }

    /**
     * Get a specific feature.
     */
    public function get(string $feature): ?array
    {
        return Cache::remember("featurebox.{$feature}", 300, function () use ($feature) {
            $featureData = DB::table('features')
                ->where('name', $feature)
                ->first();

            if (! $featureData) {
                return null;
            }

            return [
                'name' => $featureData->name,
                'is_enabled' => (bool) $featureData->is_enabled,
                'conditions' => json_decode($featureData->conditions, true) ?: [],
                'created_at' => $featureData->created_at,
                'updated_at' => $featureData->updated_at,
            ];
        });
    }

    /**
     * Evaluate conditions for a feature.
     */
    protected function evaluateConditions(array $conditions, array $context): bool
    {
        // Environment check
        if (isset($conditions['environments'])) {
            $currentEnv = app()->environment();
            if (! in_array($currentEnv, $conditions['environments'])) {
                return false;
            }
        }

        // User roles check
        if (isset($conditions['user_roles']) && isset($context['user_id'])) {
            $user = auth()->user();
            if (! $user || ! in_array($user->role ?? 'user', $conditions['user_roles'])) {
                return false;
            }
        }

        // User IDs check
        if (isset($conditions['user_ids']) && isset($context['user_id'])) {
            if (! in_array($context['user_id'], $conditions['user_ids'])) {
                return false;
            }
        }

        // Date range check
        if (isset($conditions['start_date'])) {
            $startDate = \Carbon\Carbon::parse($conditions['start_date']);
            if (now()->lt($startDate)) {
                return false;
            }
        }

        if (isset($conditions['end_date'])) {
            $endDate = \Carbon\Carbon::parse($conditions['end_date']);
            if (now()->gt($endDate)) {
                return false;
            }
        }

        // Custom conditions check
        if (isset($conditions['custom'])) {
            foreach ($conditions['custom'] as $key => $value) {
                if (! isset($context[$key]) || $context[$key] !== $value) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Clear the cache.
     */
    protected function clearCache(): void
    {
        Cache::forget('featurebox.all');

        // Clear individual feature caches
        $features = DB::table('features')->pluck('name');
        foreach ($features as $feature) {
            Cache::forget("featurebox.{$feature}");
        }
    }
}
