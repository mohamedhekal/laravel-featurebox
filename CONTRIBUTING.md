# Contributing to Laravel FeatureBox

Thank you for your interest in contributing to Laravel FeatureBox! This document provides guidelines and information for contributors.

## 🚀 Getting Started

1. **Fork the repository** on GitHub
2. **Clone your fork** locally
3. **Install dependencies**:
   ```bash
   composer install
   ```

## 🧪 Testing

Before submitting any changes, please ensure all tests pass:

```bash
composer test
```

### Running Tests

```bash
# Run all tests
composer test

# Run tests with coverage
composer test-coverage

# Run specific test file
./vendor/bin/phpunit tests/FeatureBoxTest.php
```

## 📝 Code Style

This project follows PSR-12 coding standards. Please ensure your code is properly formatted:

```bash
composer format
```

## 🔧 Development Setup

### Local Development

1. Clone the repository
2. Install dependencies: `composer install`
3. Copy configuration: `cp config/featurebox.php.example config/featurebox.php`
4. Run tests: `composer test`

### Testing in a Laravel Application

To test the package in a real Laravel application:

1. In your Laravel app, add this to `composer.json`:
   ```json
   {
       "repositories": [
           {
               "type": "path",
               "url": "../laravel-featurebox"
           }
       ]
   }
   ```

2. Install the package:
   ```bash
   composer require mohamedhekal/laravel-featurebox:dev-master
   ```

## 📋 Pull Request Guidelines

### Before Submitting

- [ ] All tests pass
- [ ] Code follows PSR-12 standards
- [ ] Documentation is updated
- [ ] Changelog is updated (if applicable)

### Commit Messages

Please use conventional commit messages:

- `feat:` for new features
- `fix:` for bug fixes
- `docs:` for documentation changes
- `test:` for adding or updating tests
- `refactor:` for code refactoring
- `style:` for formatting changes

Example:
```
feat: add support for custom conditions

- Add custom JSON conditions support
- Update documentation with examples
- Add tests for custom conditions
```

### Pull Request Title

Use a clear, descriptive title that explains what the PR does.

## 🐛 Reporting Bugs

When reporting bugs, please include:

1. **Laravel version**
2. **PHP version**
3. **Package version**
4. **Steps to reproduce**
5. **Expected behavior**
6. **Actual behavior**
7. **Error messages** (if any)

## 💡 Feature Requests

When suggesting new features:

1. **Describe the feature** clearly
2. **Explain the use case** and why it's needed
3. **Provide examples** of how it would be used
4. **Consider implementation** details if possible

## 📚 Documentation

When contributing documentation:

- Keep it clear and concise
- Include code examples
- Update both English and Arabic versions
- Test all code examples

## 🔒 Security

If you discover a security vulnerability, please:

1. **Don't open a public issue**
2. **Email** the maintainer directly
3. **Wait for acknowledgment** before disclosing publicly

## 🤝 Code of Conduct

- Be respectful and inclusive
- Focus on the code, not the person
- Help others learn and grow
- Be patient with newcomers

## 📞 Getting Help

If you need help contributing:

1. Check existing issues and PRs
2. Ask questions in issues
3. Join discussions in PRs
4. Contact the maintainer directly

## 🎉 Recognition

Contributors will be recognized in:

- The README file
- Release notes
- The changelog

Thank you for contributing to Laravel FeatureBox! 🚀 