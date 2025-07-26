# Release Guide

This guide explains how to create releases for Laravel FeatureBox, both automatically and manually.

## Automatic Release (Recommended)

When you push a tag to the repository, GitHub Actions will automatically create a release:

```bash
# Create and push a new tag
git tag v1.0.0
git push origin v1.0.0
```

The automated workflow will:
1. Run tests
2. Check code style
3. Create a GitHub release
4. Upload release assets

## Manual Release (Fallback)

If the automated release fails, you can create a release manually:

### 1. Prepare the Release

```bash
# Ensure you're on the main branch
git checkout main
git pull origin main

# Run tests locally
composer test

# Check code style
composer format-check

# Create a new tag
git tag v1.0.0
git push origin v1.0.0
```

### 2. Create GitHub Release

1. Go to [GitHub Releases](https://github.com/mohamedhekal/laravel-featurebox/releases)
2. Click "Create a new release"
3. Select the tag you just created
4. Use this release title: `Release v1.0.0`
5. Use this release description:

```markdown
## What's Changed

This release includes all the latest features and improvements for Laravel FeatureBox.

### Features
- Feature toggle functionality with database storage
- JSON-based conditions support
- Environment-based conditions
- User role and ID-based conditions
- Date range conditions
- Custom conditions support
- Artisan commands for feature management
- Caching support for performance

### Documentation
- Comprehensive API documentation
- Multi-language support (English & Arabic)
- Advanced usage examples

### Testing
- 12 comprehensive tests with 100% pass rate
- Full test coverage for all functionality

### Performance
- Built-in caching with configurable TTL
- Optimized database queries
- Efficient condition evaluation

## Installation

```bash
composer require mohamedhekal/laravel-featurebox
```

## Quick Start

```bash
php artisan vendor:publish --tag=featurebox-config
php artisan vendor:publish --tag=featurebox-migrations
php artisan migrate
php artisan featurebox:enable new_feature
```

## Usage

```php
use FeatureBox\Facades\FeatureBox;

if (FeatureBox::isEnabled('new_feature')) {
    // New feature logic
}
```

For more information, see the [documentation](https://github.com/mohamedhekal/laravel-featurebox#readme).
```

6. Upload these files as release assets:
   - `composer.json`
   - `README.md`
   - `CHANGELOG.md`
   - `LICENSE`
   - `docs/API.md`
   - `docs/INSTALLATION.md`

### 3. Publish to Packagist

1. Go to [Packagist](https://packagist.org/packages/mohamedhekal/laravel-featurebox)
2. Click "Update Package"
3. The new version should appear automatically

## Release Checklist

Before creating a release, ensure:

- [ ] All tests pass (`composer test`)
- [ ] Code style is correct (`composer format-check`)
- [ ] Documentation is up to date
- [ ] CHANGELOG.md is updated
- [ ] Version number is correct
- [ ] No breaking changes (or they're documented)

## Versioning

We follow [Semantic Versioning](https://semver.org/):

- **MAJOR** version for incompatible API changes
- **MINOR** version for backwards-compatible functionality additions
- **PATCH** version for backwards-compatible bug fixes

## Troubleshooting

### Release Workflow Fails

If the automated release workflow fails:

1. Check the GitHub Actions logs for errors
2. Ensure the repository has proper permissions
3. Try the manual release process above
4. Check if the tag already exists

### Permission Issues

If you get permission errors:

1. Ensure you have write access to the repository
2. Check repository settings for Actions permissions
3. Verify the GITHUB_TOKEN has proper permissions

### Packagist Issues

If the package doesn't update on Packagist:

1. Manually update the package on Packagist
2. Check if the webhook is working
3. Verify the package name is correct

## Support

If you encounter issues with releases:

- Check [GitHub Issues](https://github.com/mohamedhekal/laravel-featurebox/issues)
- Ask in [GitHub Discussions](https://github.com/mohamedhekal/laravel-featurebox/discussions)
- Contact [mohamedhekal@gmail.com](mailto:mohamedhekal@gmail.com) 