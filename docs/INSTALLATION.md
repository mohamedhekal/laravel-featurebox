# Installation Guide

## Requirements

Before installing Laravel FeatureBox, make sure your system meets the following requirements:

- **PHP**: >= 8.1
- **Laravel**: >= 10.0
- **Database**: MySQL, PostgreSQL, or SQLite
- **Composer**: Latest version

## Quick Installation

### 1. Install via Composer

```bash
composer require mohamedhekal/laravel-featurebox
```

### 2. Publish Configuration and Migrations

```bash
php artisan vendor:publish --tag=featurebox-config
php artisan vendor:publish --tag=featurebox-migrations
```

### 3. Run Migrations

```bash
php artisan migrate
```

### 4. Verify Installation

```bash
php artisan featurebox:list
```

## Detailed Installation Steps

### Step 1: Install the Package

The package is available on Packagist and can be installed using Composer:

```bash
composer require mohamedhekal/laravel-featurebox
```

This will:
- Download the package
- Install dependencies
- Register the service provider automatically (Laravel auto-discovery)

### Step 2: Publish Configuration

Publish the configuration file to customize the package settings:

```bash
php artisan vendor:publish --tag=featurebox-config
```

This creates `config/featurebox.php` with the following default configuration:

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

### Step 3: Publish Migrations

Publish the database migrations to create the required tables:

```bash
php artisan vendor:publish --tag=featurebox-migrations
```

This creates a migration file in `database/migrations/` that will create the `features` table.

### Step 4: Run Migrations

Execute the migrations to create the database table:

```bash
php artisan migrate
```

The migration creates a `features` table with the following structure:

```sql
CREATE TABLE features (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL,
    is_enabled BOOLEAN DEFAULT FALSE,
    conditions JSON NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### Step 5: Verify Installation

Test that the package is working correctly:

```bash
# List all features (should be empty initially)
php artisan featurebox:list

# Enable a test feature
php artisan featurebox:enable test_feature

# Check if the feature is enabled
php artisan featurebox:list
```

## Configuration

### Environment Variables

Add these variables to your `.env` file to customize the package behavior:

```env
# Cache settings
FEATUREBOX_CACHE_ENABLED=true
FEATUREBOX_CACHE_TTL=300

# Database table name
FEATUREBOX_TABLE=features
```

### Cache Configuration

The package uses Laravel's cache system for performance. You can configure caching in `config/featurebox.php`:

```php
'cache' => [
    'enabled' => env('FEATUREBOX_CACHE_ENABLED', true),
    'ttl' => env('FEATUREBOX_CACHE_TTL', 300), // 5 minutes
],
```

### Database Configuration

The package uses your Laravel database configuration. Make sure your database connection is properly configured in `config/database.php`.

## Manual Installation (Advanced)

If you prefer to install the package manually or need to customize the installation:

### 1. Download the Package

```bash
git clone https://github.com/mohamedhekal/laravel-featurebox.git
cd laravel-featurebox
composer install
```

### 2. Add to Composer Autoload

Add the package to your `composer.json`:

```json
{
    "require": {
        "mohamedhekal/laravel-featurebox": "dev-main"
    },
    "repositories": [
        {
            "type": "path",
            "url": "./laravel-featurebox"
        }
    ]
}
```

### 3. Register Service Provider

Add the service provider to `config/app.php`:

```php
'providers' => [
    // ...
    MohamedHekal\LaravelFeatureBox\FeatureBoxServiceProvider::class,
],

'aliases' => [
    // ...
    'FeatureBox' => MohamedHekal\LaravelFeatureBox\Facades\FeatureBox::class,
],
```

### 4. Copy Configuration and Migrations

Copy the configuration and migration files manually:

```bash
cp laravel-featurebox/config/featurebox.php config/
cp laravel-featurebox/database/migrations/* database/migrations/
```

## Upgrading

### From Previous Versions

When upgrading the package:

1. **Update the package:**
   ```bash
   composer update mohamedhekal/laravel-featurebox
   ```

2. **Publish new configuration (if any):**
   ```bash
   php artisan vendor:publish --tag=featurebox-config --force
   ```

3. **Run new migrations:**
   ```bash
   php artisan migrate
   ```

4. **Clear cache:**
   ```bash
   php artisan cache:clear
   ```

## Troubleshooting

### Common Installation Issues

#### 1. Composer Memory Limit

If you encounter memory issues during installation:

```bash
COMPOSER_MEMORY_LIMIT=-1 composer require mohamedhekal/laravel-featurebox
```

#### 2. Permission Issues

If you get permission errors:

```bash
sudo chown -R $USER:$USER .
chmod -R 755 storage bootstrap/cache
```

#### 3. Migration Errors

If migrations fail:

```bash
# Check migration status
php artisan migrate:status

# Rollback and re-run
php artisan migrate:rollback
php artisan migrate
```

#### 4. Service Provider Not Found

If the service provider is not auto-discovered:

1. Check if Laravel auto-discovery is enabled
2. Manually register the service provider in `config/app.php`
3. Clear configuration cache: `php artisan config:clear`

#### 5. Facade Not Found

If the Facade is not working:

1. Check if the alias is registered in `config/app.php`
2. Clear application cache: `php artisan cache:clear`
3. Clear configuration cache: `php artisan config:clear`

### Verification Commands

Use these commands to verify the installation:

```bash
# Check if package is installed
composer show mohamedhekal/laravel-featurebox

# Check if service provider is registered
php artisan config:show app.providers | grep FeatureBox

# Check if facade is working
php artisan tinker
>>> FeatureBox::all()
>>> exit

# Check if commands are available
php artisan list | grep featurebox
```

## Next Steps

After successful installation:

1. **Read the [API Documentation](API.md)** to learn how to use the package
2. **Check the [Examples](../examples/)** for usage patterns
3. **Configure caching** for better performance
4. **Set up your first features** using Artisan commands

## Support

If you encounter any issues during installation:

- Check the [Troubleshooting](#troubleshooting) section above
- Search [GitHub Issues](https://github.com/mohamedhekal/laravel-featurebox/issues)
- Ask questions in [GitHub Discussions](https://github.com/mohamedhekal/laravel-featurebox/discussions)
- Contact support at [mohamedhekal@gmail.com](mailto:mohamedhekal@gmail.com) 