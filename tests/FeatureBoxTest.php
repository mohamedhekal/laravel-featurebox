<?php

namespace MohamedHekal\LaravelFeatureBox\Tests;

use Illuminate\Support\Facades\DB;
use MohamedHekal\LaravelFeatureBox\Facades\FeatureBox;

class FeatureBoxTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Run migrations
        $this->artisan('migrate');
    }

    /** @test */
    public function it_can_enable_a_feature()
    {
        FeatureBox::enable('test_feature');

        $this->assertTrue(FeatureBox::isEnabled('test_feature'));
    }

    /** @test */
    public function it_can_disable_a_feature()
    {
        FeatureBox::enable('test_feature');
        FeatureBox::disable('test_feature');

        $this->assertFalse(FeatureBox::isEnabled('test_feature'));
    }

    /** @test */
    public function it_returns_false_for_nonexistent_features()
    {
        $this->assertFalse(FeatureBox::isEnabled('nonexistent_feature'));
    }

    /** @test */
    public function it_can_enable_feature_with_conditions()
    {
        $conditions = [
            'environments' => ['testing'],
            'user_roles' => ['admin'],
        ];

        FeatureBox::enable('test_feature', $conditions);

        $feature = FeatureBox::get('test_feature');
        $this->assertEquals($conditions, $feature['conditions']);
    }

    /** @test */
    public function it_can_list_all_features()
    {
        FeatureBox::enable('feature1');
        FeatureBox::enable('feature2');

        $features = FeatureBox::all();

        $this->assertCount(2, $features);
        $this->assertTrue(collect($features)->pluck('name')->contains('feature1'));
        $this->assertTrue(collect($features)->pluck('name')->contains('feature2'));
    }

    /** @test */
    public function it_can_get_specific_feature()
    {
        FeatureBox::enable('test_feature');

        $feature = FeatureBox::get('test_feature');

        $this->assertNotNull($feature);
        $this->assertEquals('test_feature', $feature['name']);
        $this->assertTrue($feature['is_enabled']);
    }

    /** @test */
    public function it_returns_null_for_nonexistent_feature_when_getting()
    {
        $feature = FeatureBox::get('nonexistent_feature');

        $this->assertNull($feature);
    }

    /** @test */
    public function it_can_check_if_feature_is_disabled()
    {
        $this->assertTrue(FeatureBox::isDisabled('nonexistent_feature'));

        FeatureBox::enable('test_feature');
        $this->assertFalse(FeatureBox::isDisabled('test_feature'));

        FeatureBox::disable('test_feature');
        $this->assertTrue(FeatureBox::isDisabled('test_feature'));
    }

    /** @test */
    public function it_handles_environment_conditions()
    {
        $conditions = [
            'environments' => ['testing'],
        ];

        FeatureBox::enable('env_feature', $conditions);

        // Should be enabled in testing environment
        $this->assertTrue(FeatureBox::isEnabled('env_feature'));

        // Test with different environment
        app()['env'] = 'production';
        $this->assertFalse(FeatureBox::isEnabled('env_feature'));
    }

    /** @test */
    public function it_handles_date_conditions()
    {
        $conditions = [
            'start_date' => '2020-01-01',
            'end_date' => '2030-12-31',
        ];

        FeatureBox::enable('date_feature', $conditions);

        // Should be enabled within date range
        $this->assertTrue(FeatureBox::isEnabled('date_feature'));

        // Test with future date
        $conditions = [
            'start_date' => '2030-01-01',
        ];

        FeatureBox::enable('future_feature', $conditions);
        $this->assertFalse(FeatureBox::isEnabled('future_feature'));
    }

    /** @test */
    public function it_handles_custom_conditions()
    {
        $conditions = [
            'custom' => [
                'plan' => 'premium',
                'region' => 'US',
            ],
        ];

        FeatureBox::enable('custom_feature', $conditions);

        // Should be enabled with matching context
        $this->assertTrue(FeatureBox::isEnabled('custom_feature', [
            'plan' => 'premium',
            'region' => 'US',
        ]));

        // Should be disabled with non-matching context
        $this->assertFalse(FeatureBox::isEnabled('custom_feature', [
            'plan' => 'basic',
            'region' => 'US',
        ]));
    }

    /** @test */
    public function it_caches_features_for_performance()
    {
        FeatureBox::enable('cached_feature');

        // First call should hit database
        $this->assertTrue(FeatureBox::isEnabled('cached_feature'));

        // Second call should use cache
        $this->assertTrue(FeatureBox::isEnabled('cached_feature'));

        // Verify cache is working by checking database calls
        DB::enableQueryLog();
        FeatureBox::isEnabled('cached_feature');
        $this->assertEmpty(DB::getQueryLog());
    }
}
