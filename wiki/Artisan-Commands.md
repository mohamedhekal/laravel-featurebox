# Artisan Commands

Laravel FeatureBox provides several Artisan commands to manage features from the command line. This guide covers all available commands and their usage.

## 📋 Available Commands

### List All Commands

To see all available FeatureBox commands:

```bash
php artisan list featurebox
```

This will show:
- `featurebox:enable` - Enable a feature
- `featurebox:disable` - Disable a feature
- `featurebox:list` - List all features

## 🚀 Enable Feature Command

### Basic Usage

Enable a feature without conditions:

```bash
php artisan featurebox:enable new_feature
```

### With Conditions

Enable a feature with conditions:

```bash
php artisan featurebox:enable new_feature --conditions='{"environments":["production"],"user_roles":["admin"]}'
```

### Command Options

| Option | Description | Example |
|--------|-------------|---------|
| `--conditions` | JSON string of conditions | `--conditions='{"environments":["production"]}'` |

### Examples

#### Environment-Based Feature

```bash
# Enable for production only
php artisan featurebox:enable production_feature --conditions='{"environments":["production"]}'

# Enable for staging and production
php artisan featurebox:enable beta_feature --conditions='{"environments":["staging","production"]}'
```

#### User Role-Based Feature

```bash
# Enable for admin users only
php artisan featurebox:enable admin_panel --conditions='{"user_roles":["admin"]}'

# Enable for premium and admin users
php artisan featurebox:enable premium_feature --conditions='{"user_roles":["premium","admin"]}'
```

#### User ID-Based Feature

```bash
# Enable for specific users
php artisan featurebox:enable beta_testing --conditions='{"user_ids":[1,2,3,4,5]}'
```

#### Date-Based Feature

```bash
# Enable from specific date
php artisan featurebox:enable future_feature --conditions='{"start_date":"2024-06-01"}'

# Enable within date range
php artisan featurebox:enable seasonal_feature --conditions='{"start_date":"2024-12-01","end_date":"2024-12-31"}'
```

#### Custom Conditions

```bash
# Enable with custom conditions
php artisan featurebox:enable premium_feature --conditions='{"custom":{"plan":"premium","region":"US"}}'
```

#### Complex Conditions

```bash
# Enable with multiple condition types
php artisan featurebox:enable advanced_feature --conditions='{"environments":["production"],"user_roles":["admin"],"start_date":"2024-01-01","custom":{"plan":"premium"}}'
```

## 🛑 Disable Feature Command

### Basic Usage

Disable a feature:

```bash
php artisan featurebox:disable old_feature
```

### Examples

```bash
# Disable a feature
php artisan featurebox:disable deprecated_feature

# Disable multiple features
php artisan featurebox:disable feature1
php artisan featurebox:disable feature2
```

## 📋 List Features Command

### Basic Usage

List all features:

```bash
php artisan featurebox:list
```

### Output Format

The command displays features in a table format:

```
+----------------+------------+-------------------------+-------------------------+
| Name           | Status     | Created At              | Updated At              |
+----------------+------------+-------------------------+-------------------------+
| new_feature    | Enabled    | 2024-01-01 12:00:00     | 2024-01-01 12:00:00     |
| old_feature    | Disabled   | 2024-01-01 10:00:00     | 2024-01-01 11:00:00     |
+----------------+------------+-------------------------+-------------------------+
```

### Examples

```bash
# List all features
php artisan featurebox:list

# Check if specific feature exists
php artisan featurebox:list | grep my_feature
```

## 🔧 Advanced Usage

### Using in Scripts

You can use these commands in deployment scripts:

```bash
#!/bin/bash

# Enable features for production deployment
php artisan featurebox:enable new_checkout --conditions='{"environments":["production"]}'
php artisan featurebox:enable beta_dashboard --conditions='{"user_roles":["beta_tester"]}'

# Disable old features
php artisan featurebox:disable old_checkout
```

### Using in CI/CD

Add commands to your CI/CD pipeline:

```yaml
# In your CI/CD configuration
- name: Enable production features
  run: |
    php artisan featurebox:enable production_feature --conditions='{"environments":["production"]}'
    php artisan featurebox:enable admin_tool --conditions='{"user_roles":["admin"]}'
```

### Using in Seeders

Use commands in database seeders:

```php
// In a seeder
public function run()
{
    // Enable default features
    Artisan::call('featurebox:enable', [
        'feature' => 'default_feature'
    ]);
    
    // Enable features with conditions
    Artisan::call('featurebox:enable', [
        'feature' => 'admin_feature',
        '--conditions' => '{"user_roles":["admin"]}'
    ]);
}
```

## 🎯 Condition Examples

### Environment Conditions

```bash
# Production only
php artisan featurebox:enable prod_feature --conditions='{"environments":["production"]}'

# Staging and production
php artisan featurebox:enable beta_feature --conditions='{"environments":["staging","production"]}'

# Local development
php artisan featurebox:enable debug_feature --conditions='{"environments":["local"]}'
```

### User Role Conditions

```bash
# Admin only
php artisan featurebox:enable admin_panel --conditions='{"user_roles":["admin"]}'

# Premium users
php artisan featurebox:enable premium_feature --conditions='{"user_roles":["premium","admin"]}'

# Beta testers
php artisan featurebox:enable beta_features --conditions='{"user_roles":["beta_tester"]}'
```

### User ID Conditions

```bash
# Specific users
php artisan featurebox:enable early_access --conditions='{"user_ids":[1,5,10,15]}'

# Beta testers
php artisan featurebox:enable beta_testing --conditions='{"user_ids":[1,2,3,4,5,6,7,8,9,10]}'
```

### Date Conditions

```bash
# Future feature
php artisan featurebox:enable future_feature --conditions='{"start_date":"2024-06-01"}'

# Seasonal feature
php artisan featurebox:enable christmas_theme --conditions='{"start_date":"2024-12-01","end_date":"2024-12-31"}'

# Time-limited feature
php artisan featurebox:enable flash_sale --conditions='{"start_date":"2024-01-15 09:00:00","end_date":"2024-01-15 17:00:00"}'
```

### Custom Conditions

```bash
# Plan-based feature
php artisan featurebox:enable premium_analytics --conditions='{"custom":{"plan":"premium"}}'

# Region-based feature
php artisan featurebox:enable local_payment --conditions='{"custom":{"region":"US","country":"United States"}}'

# Feature flag
php artisan featurebox:enable experimental_feature --conditions='{"custom":{"beta_enabled":true}}'
```

### Complex Conditions

```bash
# Production admin feature
php artisan featurebox:enable production_admin_tool --conditions='{"environments":["production"],"user_roles":["admin"]}'

# Premium beta feature
php artisan featurebox:enable premium_beta --conditions='{"user_roles":["premium"],"custom":{"beta_access":true},"start_date":"2024-01-01"}'

# Regional premium feature
php artisan featurebox:enable regional_premium --conditions='{"environments":["production"],"user_roles":["premium"],"custom":{"region":"EU"}}'
```

## 🚨 Error Handling

### Common Errors

#### Invalid JSON

```bash
# Error: Invalid JSON in conditions
php artisan featurebox:enable feature --conditions='{invalid json}'
```

**Solution**: Ensure valid JSON format:

```bash
php artisan featurebox:enable feature --conditions='{"environments":["production"]}'
```

#### Feature Already Exists

```bash
# Error: Feature already exists
php artisan featurebox:enable existing_feature
```

**Solution**: The command will update the existing feature.

#### Database Connection

```bash
# Error: Database connection failed
php artisan featurebox:enable feature
```

**Solution**: Check your database configuration and connection.

### Debugging

#### Enable Verbose Output

```bash
# Add -v flag for verbose output
php artisan featurebox:enable feature -v
```

#### Check Feature Status

```bash
# Check if feature exists
php artisan featurebox:list | grep feature_name
```

#### Validate Conditions

```bash
# Test JSON validity
echo '{"environments":["production"]}' | php -r "echo json_decode(file_get_contents('php://stdin')) ? 'Valid' : 'Invalid';"
```

## 📝 Best Practices

### Command Organization

#### Use Descriptive Names

```bash
# Good
php artisan featurebox:enable new_checkout_flow
php artisan featurebox:enable beta_dashboard
php artisan featurebox:enable dark_mode

# Avoid
php artisan featurebox:enable feature1
php artisan featurebox:enable test
```

#### Document Commands

Keep a record of commands used:

```bash
# commands.log
php artisan featurebox:enable new_checkout --conditions='{"environments":["production"]}'
php artisan featurebox:enable beta_dashboard --conditions='{"user_roles":["beta_tester"]}'
php artisan featurebox:disable old_checkout
```

### Condition Management

#### Use Consistent Formatting

```bash
# Consistent JSON formatting
php artisan featurebox:enable feature --conditions='{"environments":["production"],"user_roles":["admin"]}'
```

#### Validate Conditions

Test conditions before applying:

```bash
# Test condition syntax
php -r "json_decode('{\"environments\":[\"production\"]}') ? print('Valid') : print('Invalid');"
```

### Automation

#### Create Helper Scripts

```bash
#!/bin/bash
# enable-production-features.sh

echo "Enabling production features..."

php artisan featurebox:enable new_checkout --conditions='{"environments":["production"]}'
php artisan featurebox:enable admin_panel --conditions='{"user_roles":["admin"]}'
php artisan featurebox:enable premium_features --conditions='{"user_roles":["premium"]}'

echo "Production features enabled!"
```

#### Use in Deployment

```bash
# In deployment script
php artisan migrate
php artisan featurebox:enable production_feature --conditions='{"environments":["production"]}'
php artisan cache:clear
```

## 📚 Related Documentation

- [API Reference](API-Reference) - Programmatic feature management
- [Feature Conditions](Feature-Conditions) - Detailed condition guide
- [Examples](Examples) - Real-world usage examples
- [Advanced Usage](Advanced-Usage) - Advanced patterns 