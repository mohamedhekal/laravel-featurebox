<?php

/**
 * Laravel FeatureBox - Basic Usage Examples
 * 
 * This file demonstrates how to use the FeatureBox package in your Laravel application.
 */

use FeatureBox\Facades\FeatureBox;

// Example 1: Basic feature toggle
if (FeatureBox::isEnabled('new_dashboard')) {
    echo "Showing new dashboard\n";
} else {
    echo "Showing classic dashboard\n";
}

// Example 2: Enable a feature
FeatureBox::enable('beta_feature');

// Example 3: Enable with conditions
FeatureBox::enable('premium_feature', [
    'environments' => ['production'],
    'user_roles' => ['premium', 'admin'],
    'start_date' => '2025-01-01'
]);

// Example 4: Check with context
$user = auth()->user();
if (FeatureBox::isEnabled('personalized_content', [
    'user_id' => $user->id,
    'role' => $user->role,
    'plan' => $user->subscription_plan
])) {
    echo "Showing personalized content\n";
}

// Example 5: Disable a feature
FeatureBox::disable('old_feature');

// Example 6: List all features
$features = FeatureBox::all();
foreach ($features as $feature) {
    echo "Feature: {$feature['name']} - " .
        ($feature['is_enabled'] ? 'Enabled' : 'Disabled') . "\n";
}

// Example 7: Get specific feature
$feature = FeatureBox::get('new_checkout');
if ($feature) {
    echo "Feature conditions: " . json_encode($feature['conditions']) . "\n";
}

// Example 8: Blade template usage (in your view)
/*
@if(FeatureBox::isEnabled('dark_mode'))
    <link rel="stylesheet" href="/css/dark-mode.css">
@endif

@if(FeatureBox::isEnabled('new_navigation'))
    @include('partials.new-navigation')
@else
    @include('partials.classic-navigation')
@endif
*/

// Example 9: Controller usage
/*
public function checkout()
{
    if (FeatureBox::isEnabled('new_checkout')) {
        return view('checkout.new');
    }
    
    return view('checkout.classic');
}
*/

// Example 10: Conditional logic with multiple features
if (
    FeatureBox::isEnabled('advanced_analytics') &&
    FeatureBox::isEnabled('real_time_updates')
) {
    echo "Showing advanced dashboard with real-time updates\n";
}
