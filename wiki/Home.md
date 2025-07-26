# Laravel FeatureBox Wiki

Welcome to the Laravel FeatureBox Wiki! This comprehensive guide will help you understand, install, and use the Laravel FeatureBox package effectively.

## 🚀 Quick Start

Laravel FeatureBox is a simple, flexible feature toggle system for Laravel applications. It allows you to control feature visibility across different environments, users, and conditions.

### Installation

```bash
composer require mohamedhekal/laravel-featurebox
php artisan vendor:publish --tag=featurebox-config
php artisan vendor:publish --tag=featurebox-migrations
php artisan migrate
```

### Basic Usage

```php
use FeatureBox\Facades\FeatureBox;

// Enable a feature
FeatureBox::enable('new_feature');

// Check if feature is enabled
if (FeatureBox::isEnabled('new_feature')) {
    // Feature is active
}
```

## 📚 Documentation Sections

### [Installation Guide](Installation-Guide)
Complete step-by-step installation instructions, including requirements, configuration, and troubleshooting.

### [API Reference](API-Reference)
Comprehensive documentation of all available methods and their usage.

### [Feature Conditions](Feature-Conditions)
Detailed guide on how to use different types of conditions for feature control.

### [Artisan Commands](Artisan-Commands)
Reference for all available command-line tools and their options.

### [Configuration](Configuration)
Complete configuration options and environment variables.

### [Examples](Examples)
Real-world examples and use cases for different scenarios.

### [Advanced Usage](Advanced-Usage)
Advanced patterns and techniques for complex feature management.

### [Troubleshooting](Troubleshooting)
Common issues and their solutions.

### [Performance](Performance)
Performance optimization tips and best practices.

### [Security](Security)
Security considerations and best practices.

## 🎯 Key Features

- **Simple & Lightweight**: Easy to install and use
- **Flexible Conditions**: Support for environments, user roles, dates, and custom conditions
- **High Performance**: Built-in caching support
- **Artisan Commands**: Manage features from the command line
- **Secure**: No external API calls, all logic is local
- **Database Storage**: Features stored in your database
- **Testable**: Comprehensive test suite included
- **Multi-language**: Documentation in English and Arabic

## 🔧 Requirements

- PHP >= 8.1
- Laravel >= 10.0
- MySQL/PostgreSQL/SQLite

## 📦 Package Structure

```
laravel-featurebox/
├── src/
│   ├── FeatureBox.php              # Main feature logic
│   ├── FeatureBoxServiceProvider.php
│   ├── Contracts/
│   │   └── FeatureBoxInterface.php
│   ├── Facades/
│   │   └── FeatureBox.php
│   └── Commands/
│       ├── EnableFeatureCommand.php
│       ├── DisableFeatureCommand.php
│       └── ListFeaturesCommand.php
├── config/
│   └── featurebox.php
├── database/
│   └── migrations/
├── tests/
└── docs/
```

## 🚀 Getting Started

1. **Install the package** (see [Installation Guide](Installation-Guide))
2. **Configure the package** (see [Configuration](Configuration))
3. **Enable your first feature** (see [Examples](Examples))
4. **Learn advanced usage** (see [Advanced Usage](Advanced-Usage))

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](../CONTRIBUTING.md) for details.

## 📞 Support

- **GitHub Issues**: [Report bugs](https://github.com/mohamedhekal/laravel-featurebox/issues)
- **GitHub Discussions**: [Ask questions](https://github.com/mohamedhekal/laravel-featurebox/discussions)
- **Email**: [mohamedhekal@gmail.com](mailto:mohamedhekal@gmail.com)

## 📄 License

This package is open-sourced under the [MIT license](../LICENSE).

---

**Developed by [Mohamed Hekal](https://github.com/mohamedhekal)** 