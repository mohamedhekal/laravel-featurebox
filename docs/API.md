# Laravel FeatureBox API Documentation

## Table of Contents

- [Overview](#overview)
- [Installation](#installation)
- [Basic Usage](#basic-usage)
- [API Reference](#api-reference)
- [Feature Conditions](#feature-conditions)
- [Artisan Commands](#artisan-commands)
- [Configuration](#configuration)
- [Advanced Usage](#advanced-usage)
- [Examples](#examples)
- [Troubleshooting](#troubleshooting)

## Overview

Laravel FeatureBox provides a simple and flexible feature toggle system for Laravel applications. It allows you to control feature visibility across different environments, users, and conditions.

## Installation

```bash
composer require mohamedhekal/laravel-featurebox
```

Publish configuration and migrations:

```bash
php artisan vendor:publish --tag=featurebox-config
php artisan vendor:publish --tag=featurebox-migrations
php artisan migrate
```

## Basic Usage

```php
use FeatureBox\Facades\FeatureBox;

// Check if a feature is enabled
if (FeatureBox::isEnabled('new_feature')) {
    // Feature is enabled
}

// Enable a feature
FeatureBox::enable('new_feature');

// Disable a feature
FeatureBox::disable('new_feature');
```

## API Reference

### Core Methods

#### `FeatureBox::isEnabled(string $feature, array $context = []): bool`

Check if a feature is enabled for the given context.

**Parameters:**
- `$feature` (string): The feature name
- `$context` (array): Optional context for condition evaluation

**Returns:** `bool` - True if feature is enabled, false otherwise

**Example:**
```php
// Basic check
$enabled = FeatureBox::isEnabled('new_feature');

// With context
$enabled = FeatureBox::isEnabled('premium_feature', [
    'user_id' => 123,
    'plan' => 'premium'
]);
```

#### `FeatureBox::isDisabled(string $feature, array $context = []): bool`

Check if a feature is disabled (opposite of `isEnabled`).

**Parameters:**
- `$feature` (string): The feature name
- `$context` (array): Optional context for condition evaluation

**Returns:** `bool` - True if feature is disabled, false otherwise

**Example:**
```php
if (FeatureBox::isDisabled('old_feature')) {
    // Show alternative
}
```

#### `FeatureBox::enable(string $feature, array $conditions = []): bool`

Enable a feature with optional conditions.

**Parameters:**
- `$feature` (string): The feature name
- `$conditions` (array): Optional conditions for the feature

**Returns:** `bool` - True if successful, false otherwise

**Example:**
```php
// Enable without conditions
FeatureBox::enable('simple_feature');

// Enable with conditions
FeatureBox::enable('conditional_feature', [
    'environments' => ['production'],
    'user_roles' => ['admin']
]);
```

#### `FeatureBox::disable(string $feature): bool`

Disable a feature.

**Parameters:**
- `$feature` (string): The feature name

**Returns:** `bool` - True if successful, false otherwise

**Example:**
```php
FeatureBox::disable('deprecated_feature');
```

#### `FeatureBox::get(string $feature): ?array`

Get detailed information about a feature.

**Parameters:**
- `$feature` (string): The feature name

**Returns:** `?array` - Feature data or null if not found

**Example:**
```php
$feature = FeatureBox::get('my_feature');
// Returns: [
//     'name' => 'my_feature',
//     'is_enabled' => true,
//     'conditions' => [...],
//     'created_at' => '2024-01-01 00:00:00',
//     'updated_at' => '2024-01-01 00:00:00'
// ]
```

#### `FeatureBox::all(): array`

Get all features with their status.

**Returns:** `array` - Array of all features

**Example:**
```php
$features = FeatureBox::all();
// Returns array of all features
```

## Feature Conditions

Feature conditions allow you to control when a feature is enabled based on various criteria.

### Supported Condition Types

#### Environment Conditions

```php
FeatureBox::enable('feature', [
    'environments' => ['production', 'staging']
]);
```

#### User Role Conditions

```php
FeatureBox::enable('feature', [
    'user_roles' => ['admin', 'moderator']
]);
```

#### User ID Conditions

```php
FeatureBox::enable('feature', [
    'user_ids' => [1, 2, 3, 4, 5]
]);
```

#### Date Range Conditions

```php
FeatureBox::enable('feature', [
    'start_date' => '2024-01-01',
    'end_date' => '2024-12-31'
]);
```

#### Custom Conditions

```php
FeatureBox::enable('feature', [
    'custom' => [
        'plan' => 'premium',
        'region' => 'US',
        'beta_user' => true
    ]
]);
```

### Complex Conditions

You can combine multiple condition types:

```php
FeatureBox::enable('feature', [
    'environments' => ['production'],
    'user_roles' => ['admin'],
    'start_date' => '2024-01-01',
    'custom' => [
        'plan' => 'premium'
    ]
]);
```

## Artisan Commands

### Enable Feature

```bash
# Enable without conditions
php artisan featurebox:enable new_feature

# Enable with conditions
php artisan featurebox:enable new_feature --conditions='{"environments":["production"],"user_roles":["admin"]}'
```

### Disable Feature

```bash
php artisan featurebox:disable new_feature
```

### List Features

```bash
php artisan featurebox:list
```

## Configuration

The package configuration is located at `config/featurebox.php`:

```php
return [
    'cache' => [
        'enabled' => env('FEATUREBOX_CACHE_ENABLED', true),
        'ttl' => env('FEATUREBOX_CACHE_TTL', 300), // 5 minutes
    ],
    
    'default_conditions' => [
        // Default conditions for all features
    ],
    
    'table' => env('FEATUREBOX_TABLE', 'features'),
];
```

### Environment Variables

```env
FEATUREBOX_CACHE_ENABLED=true
FEATUREBOX_CACHE_TTL=300
FEATUREBOX_TABLE=features
```

## Advanced Usage

### Blade Templates

```php
@if(FeatureBox::isEnabled('dark_mode'))
    <link rel="stylesheet" href="/css/dark-mode.css">
@endif

@if(FeatureBox::isEnabled('beta_features', ['user_id' => auth()->id()]))
    <div class="beta-badge">Beta User</div>
@endif
```

### Controllers

```php
public function checkout()
{
    $user = auth()->user();
    
    if (FeatureBox::isEnabled('new_checkout', [
        'user_id' => $user->id,
        'role' => $user->role
    ])) {
        return view('checkout.new');
    }
    
    return view('checkout.classic');
}
```

### Middleware

```php
class FeatureMiddleware
{
    public function handle($request, Closure $next, $feature)
    {
        if (!FeatureBox::isEnabled($feature)) {
            abort(404);
        }
        
        return $next($request);
    }
}
```

### Service Providers

```php
public function boot()
{
    // Enable features based on configuration
    if (config('app.env') === 'production') {
        FeatureBox::enable('production_feature');
    }
}
```

## Examples

### E-commerce Feature Rollout

```php
// Enable new checkout for premium users only
FeatureBox::enable('new_checkout', [
    'user_roles' => ['premium'],
    'environments' => ['production']
]);

// In your checkout controller
public function checkout()
{
    $user = auth()->user();
    
    if (FeatureBox::isEnabled('new_checkout', [
        'user_id' => $user->id,
        'role' => $user->role
    ])) {
        return $this->newCheckout();
    }
    
    return $this->classicCheckout();
}
```

### Beta Testing

```php
// Enable beta features for specific users
FeatureBox::enable('beta_dashboard', [
    'user_ids' => [1, 5, 10, 15],
    'start_date' => '2024-01-01',
    'end_date' => '2024-03-31'
]);
```

### Gradual Rollout

```php
// Roll out to 10% of users
FeatureBox::enable('gradual_rollout', [
    'custom' => [
        'rollout_percentage' => 10
    ]
]);

// In your code
$user = auth()->user();
$rolloutHash = crc32($user->id . 'gradual_rollout');
$inRollout = ($rolloutHash % 100) < 10;

if (FeatureBox::isEnabled('gradual_rollout', [
    'rollout_percentage' => $inRollout ? 10 : 0
])) {
    // New feature
}
```

### Environment-Specific Features

```php
// Enable debug features only in local environment
FeatureBox::enable('debug_panel', [
    'environments' => ['local']
]);
```

## Troubleshooting

### Common Issues

#### Feature Not Working

1. Check if the feature is enabled in the database
2. Verify conditions are correctly set
3. Ensure context is properly passed

#### Performance Issues

1. Enable caching in configuration
2. Check cache TTL settings
3. Monitor database queries

#### Cache Issues

1. Clear cache: `php artisan cache:clear`
2. Check cache configuration
3. Verify cache driver is working

### Debug Mode

Enable debug mode to see feature evaluation details:

```php
// In your .env file
FEATUREBOX_DEBUG=true
```

### Logging

The package logs feature evaluations when debug mode is enabled:

```php
// Check logs for feature evaluation details
tail -f storage/logs/laravel.log
```

## Support

For more help and support:

- [GitHub Issues](https://github.com/mohamedhekal/laravel-featurebox/issues)
- [GitHub Discussions](https://github.com/mohamedhekal/laravel-featurebox/discussions)
- [Documentation](https://github.com/mohamedhekal/laravel-featurebox#readme) 