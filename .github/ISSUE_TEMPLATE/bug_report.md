---
name: Bug report
about: Create a report to help us improve
title: '[BUG] '
labels: 'bug'
assignees: 'mohamedhekal'

---

**Describe the bug**
A clear and concise description of what the bug is.

**To Reproduce**
Steps to reproduce the behavior:
1. Go to '...'
2. Click on '....'
3. Scroll down to '....'
4. See error

**Expected behavior**
A clear and concise description of what you expected to happen.

**Actual behavior**
A clear and concise description of what actually happened.

**Environment Information**
- Laravel Version: [e.g. 11.0]
- PHP Version: [e.g. 8.2]
- FeatureBox Version: [e.g. 1.0.0]
- Database: [e.g. MySQL 8.0]
- Operating System: [e.g. Ubuntu 22.04]

**Code Example**
```php
// Please provide a minimal code example that reproduces the issue
use FeatureBox\Facades\FeatureBox;

FeatureBox::enable('test_feature');
$result = FeatureBox::isEnabled('test_feature');
```

**Error Messages**
```
// Please paste any error messages or stack traces here
```

**Additional context**
Add any other context about the problem here, such as:
- Screenshots
- Log files
- Configuration files
- Related issues

**Checklist**
- [ ] I have searched existing issues to avoid duplicates
- [ ] I have provided all required information
- [ ] I have tested with the latest version
- [ ] I have included a minimal reproduction example 