# Security Policy

## Supported Versions

Use this section to tell people about which versions of your project are currently being supported with security updates.

| Version | Supported          |
| ------- | ------------------ |
| 1.x.x   | :white_check_mark: |
| < 1.0   | :x:                |

## Reporting a Vulnerability

If you discover a security vulnerability within Laravel FeatureBox, please send an email to [mohamedhekal@gmail.com](mailto:mohamedhekal@gmail.com). All security vulnerabilities will be promptly addressed.

### What to Include

When reporting a security vulnerability, please include:

1. **Description** of the vulnerability
2. **Steps to reproduce** the issue
3. **Potential impact** of the vulnerability
4. **Suggested fix** (if you have one)
5. **Your contact information** for follow-up

### Response Timeline

- **Initial Response**: Within 48 hours
- **Status Update**: Within 1 week
- **Fix Release**: As soon as possible (typically within 2 weeks)

### Disclosure Policy

1. **Private Disclosure**: Vulnerabilities are kept private until a fix is ready
2. **Coordinated Disclosure**: We work with reporters to coordinate public disclosure
3. **Credit**: Security researchers will be credited in the release notes (unless they prefer to remain anonymous)

### Security Best Practices

When using Laravel FeatureBox:

1. **Keep Updated**: Always use the latest version
2. **Review Permissions**: Ensure proper database permissions
3. **Validate Input**: Always validate feature names and conditions
4. **Monitor Logs**: Keep an eye on feature usage logs
5. **Regular Audits**: Periodically review enabled features

### Security Features

Laravel FeatureBox includes several security features:

- **Input Validation**: All inputs are validated and sanitized
- **SQL Injection Protection**: Uses Laravel's query builder
- **XSS Protection**: Output is properly escaped
- **Access Control**: Features can be restricted by user roles and environments
- **Audit Trail**: All changes are logged with timestamps

### Contact Information

- **Email**: [mohamedhekal@gmail.com](mailto:mohamedhekal@gmail.com)
- **GitHub Issues**: For non-security related issues
- **Discussions**: For general questions and feature requests

Thank you for helping keep Laravel FeatureBox secure! 🔒 