# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2024-01-01

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
- Comprehensive test suite with 100% coverage
- MIT license
- Multi-language documentation (English & Arabic)
- GitHub Actions CI/CD pipeline
- Code coverage reporting with Codecov
- Comprehensive API documentation
- Error handling and validation
- Performance optimizations

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

### Testing
- Unit tests for all core functionality
- Integration tests for database operations
- Cache testing
- Condition evaluation testing
- Error handling tests

### Documentation
- Comprehensive README with examples
- API reference documentation
- Installation and usage guides
- Contributing guidelines
- Security policy
- Code of conduct

### CI/CD
- GitHub Actions workflows
- Multi-version testing (Laravel 10 & 11, PHP 8.1-8.3)
- Code style checking with Laravel Pint
- Automated testing
- Code coverage reporting

### Performance
- Built-in caching with configurable TTL
- Optimized database queries
- Efficient condition evaluation
- Memory usage optimization 