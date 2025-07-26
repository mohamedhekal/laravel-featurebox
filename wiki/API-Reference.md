# API Reference

This page provides comprehensive documentation for all available methods in Laravel FeatureBox.

## 📚 Core Methods

### `FeatureBox::isEnabled(string $feature, array $context = []): bool`

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

**Behavior:**
- Returns `false` if feature doesn't exist
- Returns `false` if feature is disabled
- Evaluates conditions if present
- Uses caching for performance

### `FeatureBox::isDisabled(string $feature, array $context = []): bool`

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

### `FeatureBox::enable(string $feature, array $conditions = []): bool`

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

**Behavior:**
- Creates feature if it doesn't exist
- Updates existing feature if it exists
- Clears cache after modification
- Returns `false` on database errors

### `FeatureBox::disable(string $feature): bool`

Disable a feature.

**Parameters:**
- `$feature` (string): The feature name

**Returns:** `bool` - True if successful, false otherwise

**Example:**
```php
FeatureBox::disable('deprecated_feature');
```

**Behavior:**
- Updates feature status to disabled
- Clears cache after modification
- Returns `false` on database errors

### `FeatureBox::get(string $feature): ?array`

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

**Return Structure:**
```php
[
    'name' => string,
    'is_enabled' => bool,
    'conditions' => array,
    'created_at' => string,
    'updated_at' => string
]
```

### `FeatureBox::all(): array`

Get all features with their status.

**Returns:** `array` - Array of all features

**Example:**
```php
$features = FeatureBox::all();
// Returns array of all features
```

**Return Structure:**
```php
[
    [
        'name' => string,
        'is_enabled' => bool,
        'conditions' => array,
        'created_at' => string,
        'updated_at' => string
    ],
    // ... more features
]
```

## 🔧 Condition Types

### Environment Conditions

Control feature availability based on application environment.

```php
FeatureBox::enable('feature', [
    'environments' => ['production', 'staging']
]);
```

**Supported environments:**
- `local`
- `staging`
- `production`
- `testing`

### User Role Conditions

Control feature availability based on user roles.

```php
FeatureBox::enable('feature', [
    'user_roles' => ['admin', 'moderator']
]);
```

**Usage:**
- Requires `user_id` in context
- Checks against authenticated user's role
- Falls back to 'user' role if not specified

### User ID Conditions

Control feature availability for specific users.

```php
FeatureBox::enable('feature', [
    'user_ids' => [1, 2, 3, 4, 5]
]);
```

**Usage:**
- Requires `user_id` in context
- Exact match against user ID

### Date Range Conditions

Control feature availability based on date ranges.

```php
FeatureBox::enable('feature', [
    'start_date' => '2024-01-01',
    'end_date' => '2024-12-31'
]);
```

**Date Formats:**
- `Y-m-d` (e.g., '2024-01-01')
- `Y-m-d H:i:s` (e.g., '2024-01-01 12:00:00')

### Custom Conditions

Control feature availability based on custom criteria.

```php
FeatureBox::enable('feature', [
    'custom' => [
        'plan' => 'premium',
        'region' => 'US',
        'beta_user' => true
    ]
]);
```

**Usage:**
- Requires matching context keys
- Exact value matching
- Supports boolean, string, and numeric values

## 🔄 Complex Conditions

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

**Evaluation Logic:**
- All conditions must be satisfied (AND logic)
- Feature is enabled only if all conditions pass
- Missing context values cause condition to fail

## 🚀 Performance Considerations

### Caching

The package uses Laravel's cache system for performance:

```php
// Cache configuration
'cache' => [
    'enabled' => true,
    'ttl' => 300, // 5 minutes
],
```

**Cache Keys:**
- `featurebox.all` - All features
- `featurebox.{feature_name}` - Individual features

### Cache Management

```php
// Clear all feature cache
Cache::forget('featurebox.all');

// Clear specific feature cache
Cache::forget('featurebox.my_feature');
```

## 🛡️ Error Handling

### Database Errors

All methods handle database errors gracefully:

```php
// Returns false on database errors
$success = FeatureBox::enable('feature');

if (!$success) {
    // Handle error
}
```

### Invalid Input

Methods handle invalid input:

```php
// Empty feature name returns false
FeatureBox::isEnabled(''); // false

// Null feature returns false
FeatureBox::isEnabled(null); // false
```

### Cache Failures

Cache failures are handled gracefully:

```php
// Falls back to database if cache fails
$features = FeatureBox::all();
```

## 📝 Best Practices

### Feature Naming

Use descriptive, consistent naming:

```php
// Good
FeatureBox::enable('new_checkout_flow');
FeatureBox::enable('beta_dashboard');
FeatureBox::enable('dark_mode');

// Avoid
FeatureBox::enable('feature1');
FeatureBox::enable('test');
```

### Context Usage

Pass relevant context for condition evaluation:

```php
// Good
FeatureBox::isEnabled('premium_feature', [
    'user_id' => auth()->id(),
    'plan' => auth()->user()->plan,
    'region' => request()->ip()
]);

// Avoid
FeatureBox::isEnabled('premium_feature'); // No context
```

### Condition Design

Design conditions for clarity and maintainability:

```php
// Good - Clear and specific
FeatureBox::enable('beta_feature', [
    'environments' => ['staging'],
    'user_roles' => ['beta_tester'],
    'start_date' => '2024-01-01'
]);

// Avoid - Too complex
FeatureBox::enable('feature', [
    'custom' => [
        'complex_logic' => 'hard_to_maintain'
    ]
]);
```

## 🔍 Debugging

### Enable Debug Mode

Add to your `.env` file:

```env
FEATUREBOX_DEBUG=true
```

### Check Feature Status

```php
// Get detailed feature information
$feature = FeatureBox::get('my_feature');
dd($feature);

// Check all features
$features = FeatureBox::all();
dd($features);
```

### Monitor Cache

```php
// Check if cache is working
Cache::has('featurebox.all'); // true/false

// Clear cache manually
Cache::forget('featurebox.all');
```

## 📚 Related Documentation

- [Feature Conditions](Feature-Conditions) - Detailed condition guide
- [Examples](Examples) - Real-world usage examples
- [Advanced Usage](Advanced-Usage) - Advanced patterns
- [Performance](Performance) - Optimization tips 