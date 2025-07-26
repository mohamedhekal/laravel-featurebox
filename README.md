# Laravel FeatureBox

> A simple, flexible feature toggle system for Laravel — control the visibility of features across environments, users, and conditions.

---

## 🚀 Introduction

**Laravel FeatureBox** is a lightweight Laravel package that helps you manage feature flags in your application.

Whether you're rolling out features gradually, testing beta features for specific users, or disabling features in production — FeatureBox gives you full control.

Inspired by tools like LaunchDarkly, but made for Laravel.

---

## 📦 Installation

Install via Composer:

```bash
composer require mohamedhekal/laravel-featurebox
```

Then publish the config and migration files:

```bash
php artisan vendor:publish --tag=featurebox-config
php artisan vendor:publish --tag=featurebox-migrations
php artisan migrate
```

---

## ⚙️ Usage

Enable or disable features from the database or using Artisan commands.

### Basic Usage

```php
use FeatureBox\Facades\FeatureBox;

if (FeatureBox::isEnabled('new_checkout')) {
    // Show new checkout flow
} else {
    // Show classic checkout
}
```

### With Context

You can pass context to evaluate conditions:

```php
FeatureBox::isEnabled('new_checkout', [
    'user_id' => auth()->id(),
    'role'    => auth()->user()->role,
]);
```

### In Blade Templates

```php
@if(FeatureBox::isEnabled('dark_mode'))
    <link rel="stylesheet" href="/css/dark-mode.css">
@endif
```

### In Controllers

```php
public function checkout()
{
    if (FeatureBox::isEnabled('new_checkout')) {
        return view('checkout.new');
    }
    
    return view('checkout.classic');
}
```

---

## 🧠 Feature Conditions

Each feature can include optional conditions like:

* ✅ Environments (`local`, `staging`, `production`)
* 👤 User roles or specific user IDs
* 📅 Start/end dates
* 🔧 Custom JSON conditions

### Example Conditions

```json
{
  "environments": ["staging", "production"],
  "user_roles": ["admin", "beta"],
  "user_ids": [1, 2, 3],
  "start_date": "2025-01-01",
  "end_date": "2025-12-31",
  "custom": {
    "plan": "premium",
    "region": "US"
  }
}
```

Conditions will be evaluated dynamically before enabling any feature.

---

## 🧪 Artisan Commands

### Enable a Feature

```bash
# Enable without conditions
php artisan featurebox:enable new_checkout

# Enable with conditions
php artisan featurebox:enable new_checkout --conditions='{"environments":["production"],"user_roles":["admin"]}'
```

### Disable a Feature

```bash
php artisan featurebox:disable new_checkout
```

### List All Features

```bash
php artisan featurebox:list
```

---

## 🔧 Configuration

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

---

## 📊 Database Schema

The package creates a `features` table with the following structure:

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

---

## 🔐 Security

All logic is scoped locally; no external API calls or tracking.
You can optionally cache the features for performance using Laravel's cache system.

---

## 🧪 Testing

```bash
composer test
```

### Example Test

```php
use FeatureBox\Facades\FeatureBox;

public function test_feature_can_be_enabled()
{
    FeatureBox::enable('test_feature');
    
    $this->assertTrue(FeatureBox::isEnabled('test_feature'));
}
```

---

## ✅ Roadmap

* [x] Feature toggle logic
* [x] JSON-based conditions
* [x] Artisan commands
* [x] Caching support
* [ ] Web UI dashboard
* [ ] A/B testing support
* [ ] Redis driver
* [ ] Feature analytics

---

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 📄 License

This package is open-sourced under the [MIT license](LICENSE).

---

## 🧑‍💻 Developed by [Mohamed Hekal](https://github.com/mohamedhekal)

Feel free to submit issues, ideas, or pull requests.

---

## 📚 Examples

### E-commerce Example

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

### Beta Testing Example

```php
// Enable beta features for specific users
FeatureBox::enable('beta_dashboard', [
    'user_ids' => [1, 5, 10, 15],
    'start_date' => '2025-01-01',
    'end_date' => '2025-03-31'
]);
```

### Environment-Specific Features

```php
// Enable debug features only in local environment
FeatureBox::enable('debug_panel', [
    'environments' => ['local']
]);
``` 