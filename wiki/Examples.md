# Examples

This page provides real-world examples of how to use Laravel FeatureBox in different scenarios.

## 🚀 Quick Start Examples

### Basic Feature Toggle

```php
use FeatureBox\Facades\FeatureBox;

// Enable a feature
FeatureBox::enable('new_checkout');

// Check if feature is enabled
if (FeatureBox::isEnabled('new_checkout')) {
    return view('checkout.new');
} else {
    return view('checkout.classic');
}
```

### Feature with Conditions

```php
// Enable feature for production only
FeatureBox::enable('production_feature', [
    'environments' => ['production']
]);

// Check with context
if (FeatureBox::isEnabled('production_feature')) {
    // Feature is enabled in production
}
```

## 🛒 E-commerce Examples

### New Checkout Flow

```php
// Enable new checkout for premium users
FeatureBox::enable('new_checkout', [
    'user_roles' => ['premium', 'admin']
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

### Seasonal Promotions

```php
// Enable holiday sale
FeatureBox::enable('holiday_sale', [
    'start_date' => '2024-12-01',
    'end_date' => '2024-12-31'
]);

// In your pricing component
public function getPrice()
{
    if (FeatureBox::isEnabled('holiday_sale')) {
        return $this->price * 0.8; // 20% discount
    }
    
    return $this->price;
}
```

### Regional Features

```php
// Enable local payment methods for US users
FeatureBox::enable('local_payment', [
    'custom' => [
        'region' => 'US'
    ]
]);

// In your payment controller
public function getPaymentMethods()
{
    $region = $this->getUserRegion();
    
    if (FeatureBox::isEnabled('local_payment', [
        'region' => $region
    ])) {
        return $this->getLocalPaymentMethods();
    }
    
    return $this->getGlobalPaymentMethods();
}
```

## 🎯 Beta Testing Examples

### Gradual Rollout

```php
// Enable for 10% of users
FeatureBox::enable('gradual_rollout', [
    'custom' => [
        'rollout_percentage' => 10
    ]
]);

// In your application
public function shouldShowNewFeature()
{
    $user = auth()->user();
    $rolloutHash = crc32($user->id . 'gradual_rollout');
    $inRollout = ($rolloutHash % 100) < 10;
    
    return FeatureBox::isEnabled('gradual_rollout', [
        'rollout_percentage' => $inRollout ? 10 : 0
    ]);
}
```

### Beta Tester Program

```php
// Enable beta features for specific users
FeatureBox::enable('beta_dashboard', [
    'user_ids' => [1, 5, 10, 15, 20],
    'start_date' => '2024-01-01',
    'end_date' => '2024-03-31'
]);

// In your dashboard
public function getDashboardFeatures()
{
    $user = auth()->user();
    
    if (FeatureBox::isEnabled('beta_dashboard', [
        'user_id' => $user->id
    ])) {
        return $this->getBetaFeatures();
    }
    
    return $this->getStandardFeatures();
}
```

## 🎨 UI/UX Examples

### Dark Mode Toggle

```php
// Enable dark mode for users who opted in
FeatureBox::enable('dark_mode', [
    'custom' => [
        'theme_preference' => 'dark'
    ]
]);

// In your Blade template
@if(FeatureBox::isEnabled('dark_mode', ['theme_preference' => auth()->user()->theme_preference]))
    <link rel="stylesheet" href="/css/dark-mode.css">
@endif
```

### Feature Flags in Blade

```php
{{-- Show beta badge for beta users --}}
@if(FeatureBox::isEnabled('beta_features', ['user_id' => auth()->id()]))
    <div class="beta-badge">Beta User</div>
@endif

{{-- Show new navigation for admin users --}}
@if(FeatureBox::isEnabled('new_navigation', ['user_id' => auth()->id()]))
    @include('navigation.new')
@else
    @include('navigation.classic')
@endif
```

### Conditional Components

```php
// In your Vue/React component
class FeatureComponent
{
    public function render()
    {
        if (FeatureBox::isEnabled('new_component')) {
            return $this->renderNewComponent();
        }
        
        return $this->renderLegacyComponent();
    }
}
```

## 🔧 Development Examples

### Environment-Specific Features

```php
// Enable debug tools only in local environment
FeatureBox::enable('debug_panel', [
    'environments' => ['local']
]);

// In your development tools
public function getDebugTools()
{
    if (FeatureBox::isEnabled('debug_panel')) {
        return [
            'query_logger' => true,
            'performance_monitor' => true,
            'error_tracker' => true
        ];
    }
    
    return [];
}
```

### Feature Testing

```php
// In your tests
public function test_feature_toggle()
{
    // Enable feature for test
    FeatureBox::enable('test_feature');
    
    // Test that feature is enabled
    $this->assertTrue(FeatureBox::isEnabled('test_feature'));
    
    // Test with conditions
    FeatureBox::enable('conditional_feature', [
        'user_roles' => ['admin']
    ]);
    
    $this->assertTrue(FeatureBox::isEnabled('conditional_feature', [
        'user_id' => 1,
        'role' => 'admin'
    ]));
    
    $this->assertFalse(FeatureBox::isEnabled('conditional_feature', [
        'user_id' => 2,
        'role' => 'user'
    ]));
}
```

## 🏢 Enterprise Examples

### Role-Based Access

```php
// Enable admin features
FeatureBox::enable('user_management', [
    'user_roles' => ['admin', 'super_admin']
]);

FeatureBox::enable('analytics_dashboard', [
    'user_roles' => ['admin', 'analyst']
]);

// In your middleware
class FeatureMiddleware
{
    public function handle($request, Closure $next, $feature)
    {
        $user = auth()->user();
        
        if (!FeatureBox::isEnabled($feature, [
            'user_id' => $user->id,
            'role' => $user->role
        ])) {
            abort(403, 'Feature not available');
        }
        
        return $next($request);
    }
}

// In your routes
Route::middleware(['auth', 'feature:user_management'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
});
```

### Plan-Based Features

```php
// Enable premium features
FeatureBox::enable('advanced_analytics', [
    'custom' => [
        'plan' => 'premium'
    ]
]);

FeatureBox::enable('api_access', [
    'custom' => [
        'plan' => 'premium'
    ]
]);

// In your service
class AnalyticsService
{
    public function getAnalytics()
    {
        $user = auth()->user();
        
        if (FeatureBox::isEnabled('advanced_analytics', [
            'plan' => $user->plan
        ])) {
            return $this->getAdvancedAnalytics();
        }
        
        return $this->getBasicAnalytics();
    }
}
```

## 📱 Mobile App Examples

### Feature Rollout

```php
// Enable new mobile features
FeatureBox::enable('mobile_v2', [
    'custom' => [
        'app_version' => '2.0.0'
    ]
]);

// In your mobile API
public function getMobileFeatures()
{
    $appVersion = request()->header('X-App-Version');
    
    return [
        'new_ui' => FeatureBox::isEnabled('mobile_v2', [
            'app_version' => $appVersion
        ]),
        'push_notifications' => FeatureBox::isEnabled('push_notifications'),
        'offline_mode' => FeatureBox::isEnabled('offline_mode')
    ];
}
```

### A/B Testing

```php
// Enable A/B test variants
FeatureBox::enable('ab_test_variant_a', [
    'custom' => [
        'ab_test_group' => 'A'
    ]
]);

FeatureBox::enable('ab_test_variant_b', [
    'custom' => [
        'ab_test_group' => 'B'
    ]
]);

// In your application
public function getABTestVariant()
{
    $user = auth()->user();
    $testGroup = $this->assignABTestGroup($user->id);
    
    if (FeatureBox::isEnabled('ab_test_variant_a', [
        'ab_test_group' => $testGroup
    ])) {
        return 'A';
    }
    
    if (FeatureBox::isEnabled('ab_test_variant_b', [
        'ab_test_group' => $testGroup
    ])) {
        return 'B';
    }
    
    return 'control';
}
```

## 🎮 Gaming Examples

### Seasonal Events

```php
// Enable Christmas event
FeatureBox::enable('christmas_event', [
    'start_date' => '2024-12-01',
    'end_date' => '2024-12-31'
]);

// In your game logic
public function getActiveEvents()
{
    $events = [];
    
    if (FeatureBox::isEnabled('christmas_event')) {
        $events[] = [
            'name' => 'Christmas Event',
            'rewards' => ['snow_skin', 'holiday_emote'],
            'duration' => '2024-12-01 to 2024-12-31'
        ];
    }
    
    return $events;
}
```

### VIP Features

```php
// Enable VIP features
FeatureBox::enable('vip_benefits', [
    'user_roles' => ['vip', 'premium']
]);

// In your game service
public function getPlayerBenefits()
{
    $user = auth()->user();
    
    if (FeatureBox::isEnabled('vip_benefits', [
        'user_id' => $user->id,
        'role' => $user->role
    ])) {
        return [
            'double_xp' => true,
            'exclusive_skins' => true,
            'priority_queue' => true
        ];
    }
    
    return [
        'double_xp' => false,
        'exclusive_skins' => false,
        'priority_queue' => false
    ];
}
```

## 🔒 Security Examples

### Feature Access Control

```php
// Enable sensitive features for specific users
FeatureBox::enable('admin_panel', [
    'user_roles' => ['admin'],
    'environments' => ['production']
]);

// In your controller
public function adminPanel()
{
    $user = auth()->user();
    
    // Multiple security layers
    if (!$user->isAdmin()) {
        abort(403, 'Admin access required');
    }
    
    if (!FeatureBox::isEnabled('admin_panel', [
        'user_id' => $user->id,
        'role' => $user->role
    ])) {
        abort(403, 'Feature not available');
    }
    
    return view('admin.panel');
}
```

### Audit Logging

```php
// Enable audit logging for compliance
FeatureBox::enable('audit_logging', [
    'environments' => ['production'],
    'custom' => [
        'compliance_mode' => true
    ]
]);

// In your application
public function logAction($action, $data)
{
    if (FeatureBox::isEnabled('audit_logging', [
        'compliance_mode' => config('app.compliance_mode')
    ])) {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'data' => $data,
            'timestamp' => now()
        ]);
    }
}
```

## 📊 Analytics Examples

### Feature Usage Tracking

```php
// Track feature usage
public function trackFeatureUsage($feature)
{
    if (FeatureBox::isEnabled($feature)) {
        Analytics::track('feature_used', [
            'feature' => $feature,
            'user_id' => auth()->id(),
            'timestamp' => now()
        ]);
    }
}

// Usage in application
public function checkout()
{
    $this->trackFeatureUsage('new_checkout');
    
    if (FeatureBox::isEnabled('new_checkout')) {
        return $this->newCheckout();
    }
    
    return $this->classicCheckout();
}
```

### Performance Monitoring

```php
// Enable performance monitoring
FeatureBox::enable('performance_monitoring', [
    'environments' => ['production'],
    'custom' => [
        'monitoring_enabled' => true
    ]
]);

// In your application
public function measurePerformance($operation, callable $callback)
{
    $start = microtime(true);
    
    $result = $callback();
    
    if (FeatureBox::isEnabled('performance_monitoring', [
        'monitoring_enabled' => config('app.monitoring_enabled')
    ])) {
        $duration = microtime(true) - $start;
        
        PerformanceMonitor::record($operation, $duration);
    }
    
    return $result;
}
```

## 📚 Related Documentation

- [API Reference](API-Reference) - Complete API documentation
- [Feature Conditions](Feature-Conditions) - Detailed condition guide
- [Advanced Usage](Advanced-Usage) - Advanced patterns
- [Performance](Performance) - Optimization tips 