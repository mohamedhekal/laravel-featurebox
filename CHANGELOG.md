# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Initial release of Laravel FeatureBox
- Feature toggle functionality with database storage
- JSON-based conditions support
- Environment-based conditions
- User role and ID-based conditions
- Date range conditions
- Custom conditions support
- Artisan commands for feature management
- Caching support for performance
- Comprehensive test suite
- MIT license

### Features
- `FeatureBox::isEnabled()` - Check if a feature is enabled
- `FeatureBox::isDisabled()` - Check if a feature is disabled
- `FeatureBox::enable()` - Enable a feature with optional conditions
- `FeatureBox::disable()` - Disable a feature
- `FeatureBox::all()` - Get all features
- `FeatureBox::get()` - Get a specific feature

### Commands
- `php artisan featurebox:enable` - Enable a feature
- `php artisan featurebox:disable` - Disable a feature
- `php artisan featurebox:list` - List all features

### Configuration
- Cache settings
- Default conditions
- Database table configuration
- Environment variables support 