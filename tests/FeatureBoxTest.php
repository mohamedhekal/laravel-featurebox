<?php

namespace MohamedHekal\LaravelFeatureBox\Tests;

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
}
