# Feature Conditions

Feature conditions allow you to control when a feature is enabled based on various criteria. This guide covers all available condition types and how to use them effectively.

## 🎯 Overview

Conditions are optional rules that determine when a feature should be enabled. They are evaluated dynamically when checking if a feature is enabled.

```php
// Enable feature with conditions
FeatureBox::enable('new_feature', [
    'environments' => ['production'],
    'user_roles' => ['admin']
]);

// Check with context
FeatureBox::isEnabled('new_feature', [
    'user_id' => auth()->id(),
    'role' => auth()->user()->role
]);
```

## 🌍 Environment Conditions

Control feature availability based on the application environment.

### Basic Usage

```php
FeatureBox::enable('debug_panel', [
    'environments' => ['local', 'staging']
]);
```

### Supported Environments

- `local` - Local development environment
- `staging` - Staging/testing environment
- `production` - Production environment
- `testing` - Testing environment

### Examples

```php
// Only in production
FeatureBox::enable('production_feature', [
    'environments' => ['production']
]);

// In staging and production
FeatureBox::enable('beta_feature', [
    'environments' => ['staging', 'production']
]);

// Only in local development
FeatureBox::enable('debug_tools', [
    'environments' => ['local']
]);
```

## 👥 User Role Conditions

Control feature availability based on user roles.

### Basic Usage

```php
FeatureBox::enable('admin_panel', [
    'user_roles' => ['admin', 'super_admin']
]);
```

### Context Requirements

User role conditions require `user_id` in the context:

```php
// Check with user context
FeatureBox::isEnabled('admin_panel', [
    'user_id' => auth()->id()
]);
```

### Role Detection

The package automatically detects the user's role:

```php
// In your User model
class User extends Authenticatable
{
    public function getRoleAttribute()
    {
        return $this->role_type ?? 'user';
    }
}
```

### Examples

```php
// Admin only features
FeatureBox::enable('user_management', [
    'user_roles' => ['admin']
]);

// Premium user features
FeatureBox::enable('premium_dashboard', [
    'user_roles' => ['premium', 'admin']
]);

// Beta tester features
FeatureBox::enable('beta_features', [
    'user_roles' => ['beta_tester', 'admin']
]);
```

## 🆔 User ID Conditions

Control feature availability for specific users.

### Basic Usage

```php
FeatureBox::enable('beta_testing', [
    'user_ids' => [1, 5, 10, 15, 20]
]);
```

### Context Requirements

User ID conditions require `user_id` in the context:

```php
FeatureBox::isEnabled('beta_testing', [
    'user_id' => auth()->id()
]);
```

### Examples

```php
// Specific beta testers
FeatureBox::enable('new_ui', [
    'user_ids' => [1, 2, 3, 4, 5]
]);

// Early adopters
FeatureBox::enable('early_access', [
    'user_ids' => [10, 25, 50, 100]
]);
```

## 📅 Date Range Conditions

Control feature availability based on date ranges.

### Start Date

Enable feature from a specific date:

```php
FeatureBox::enable('summer_campaign', [
    'start_date' => '2024-06-01'
]);
```

### End Date

Disable feature after a specific date:

```php
FeatureBox::enable('holiday_sale', [
    'end_date' => '2024-12-31'
]);
```

### Date Range

Enable feature within a specific date range:

```php
FeatureBox::enable('limited_time_feature', [
    'start_date' => '2024-01-01',
    'end_date' => '2024-03-31'
]);
```

### Date Formats

Supported date formats:

```php
// Date only
'start_date' => '2024-01-01'

// Date and time
'start_date' => '2024-01-01 12:00:00'

// ISO format
'start_date' => '2024-01-01T12:00:00Z'
```

### Examples

```php
// Seasonal features
FeatureBox::enable('christmas_theme', [
    'start_date' => '2024-12-01',
    'end_date' => '2024-12-31'
]);

// Time-limited promotions
FeatureBox::enable('flash_sale', [
    'start_date' => '2024-01-15 09:00:00',
    'end_date' => '2024-01-15 17:00:00'
]);

// Future features
FeatureBox::enable('future_feature', [
    'start_date' => '2024-06-01'
]);
```

## 🔧 Custom Conditions

Control feature availability based on custom criteria.

### Basic Usage

```php
FeatureBox::enable('premium_feature', [
    'custom' => [
        'plan' => 'premium',
        'region' => 'US'
    ]
]);
```

### Context Requirements

Custom conditions require matching keys in the context:

```php
FeatureBox::isEnabled('premium_feature', [
    'plan' => auth()->user()->plan,
    'region' => request()->ip()
]);
```

### Supported Data Types

- **Strings**: Exact match
- **Numbers**: Exact match
- **Booleans**: Exact match
- **Arrays**: Not supported (use multiple conditions)

### Examples

```php
// Plan-based features
FeatureBox::enable('advanced_analytics', [
    'custom' => [
        'plan' => 'premium'
    ]
]);

// Region-based features
FeatureBox::enable('local_payment', [
    'custom' => [
        'region' => 'US',
        'country' => 'United States'
    ]
]);

// Feature flags
FeatureBox::enable('experimental_feature', [
    'custom' => [
        'beta_enabled' => true,
        'user_type' => 'power_user'
    ]
]);
```

## 🔄 Complex Conditions

Combine multiple condition types for sophisticated feature control.

### Multiple Condition Types

```php
FeatureBox::enable('advanced_feature', [
    'environments' => ['production'],
    'user_roles' => ['admin', 'premium'],
    'start_date' => '2024-01-01',
    'custom' => [
        'plan' => 'premium'
    ]
]);
```

### Evaluation Logic

- **AND Logic**: All conditions must be satisfied
- **Order**: Conditions are evaluated in order
- **Early Exit**: Feature is disabled if any condition fails

### Examples

```php
// Production-only admin feature
FeatureBox::enable('production_admin_tool', [
    'environments' => ['production'],
    'user_roles' => ['admin']
]);

// Premium user beta feature
FeatureBox::enable('premium_beta', [
    'user_roles' => ['premium'],
    'custom' => [
        'beta_access' => true
    ],
    'start_date' => '2024-01-01'
]);

// Regional premium feature
FeatureBox::enable('regional_premium', [
    'environments' => ['production'],
    'user_roles' => ['premium'],
    'custom' => [
        'region' => 'EU'
    ]
]);
```

## 🎯 Gradual Rollout

Implement gradual feature rollouts using custom conditions.

### Percentage-Based Rollout

```php
// Enable for 10% of users
FeatureBox::enable('gradual_rollout', [
    'custom' => [
        'rollout_percentage' => 10
    ]
]);
```

### Implementation

```php
// In your application
$user = auth()->user();
$rolloutHash = crc32($user->id . 'gradual_rollout');
$inRollout = ($rolloutHash % 100) < 10;

if (FeatureBox::isEnabled('gradual_rollout', [
    'rollout_percentage' => $inRollout ? 10 : 0
])) {
    // New feature
}
```

### User-Based Rollout

```php
// Enable for specific user segments
FeatureBox::enable('user_segment_feature', [
    'custom' => [
        'user_segment' => 'early_adopters'
    ]
]);
```

## 🚀 Performance Considerations

### Condition Evaluation

- Conditions are evaluated on each `isEnabled()` call
- Use caching to improve performance
- Keep conditions simple and efficient

### Caching

```php
// Cache configuration
'cache' => [
    'enabled' => true,
    'ttl' => 300, // 5 minutes
],
```

### Best Practices

```php
// Good - Simple conditions
FeatureBox::enable('feature', [
    'environments' => ['production'],
    'user_roles' => ['admin']
]);

// Avoid - Complex conditions
FeatureBox::enable('feature', [
    'custom' => [
        'complex_calculation' => 'expensive_operation'
    ]
]);
```

## 🛡️ Security Considerations

### Input Validation

Always validate context data:

```php
// Validate user input
$context = [
    'user_id' => (int) request()->input('user_id'),
    'role' => (string) request()->input('role')
];

FeatureBox::isEnabled('feature', $context);
```

### Access Control

Don't rely solely on feature flags for security:

```php
// Good - Multiple security layers
if (FeatureBox::isEnabled('admin_feature') && auth()->user()->isAdmin()) {
    // Feature is enabled AND user is admin
}

// Avoid - Only feature flag
if (FeatureBox::isEnabled('admin_feature')) {
    // Only feature flag check
}
```

## 🔍 Debugging Conditions

### Enable Debug Mode

```env
FEATUREBOX_DEBUG=true
```

### Check Condition Evaluation

```php
// Get feature details
$feature = FeatureBox::get('my_feature');
dd($feature['conditions']);

// Test with specific context
$enabled = FeatureBox::isEnabled('my_feature', [
    'user_id' => 123,
    'role' => 'admin'
]);
dd($enabled);
```

### Common Issues

1. **Missing Context**: Ensure required context keys are provided
2. **Type Mismatches**: Ensure context values match condition types
3. **Date Format**: Use correct date format for date conditions
4. **Environment Names**: Use exact environment names

## 📚 Related Documentation

- [API Reference](API-Reference) - Complete API documentation
- [Examples](Examples) - Real-world condition examples
- [Advanced Usage](Advanced-Usage) - Advanced condition patterns
- [Performance](Performance) - Optimization tips 