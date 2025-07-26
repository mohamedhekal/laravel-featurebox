<?php

namespace MohamedHekal\LaravelFeatureBox\Commands;

use Illuminate\Console\Command;
use MohamedHekal\LaravelFeatureBox\Contracts\FeatureBoxInterface;

class ListFeaturesCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'featurebox:list';

    /**
     * The console command description.
     */
    protected $description = 'List all features with their status';

    /**
     * Execute the console command.
     */
    public function handle(FeatureBoxInterface $featureBox): int
    {
        $features = $featureBox->all();

        if (empty($features)) {
            $this->info('No features found.');
            return 0;
        }

        $this->info('Feature List:');
        $this->newLine();

        $headers = ['Name', 'Status', 'Conditions', 'Updated At'];
        $rows = [];

        foreach ($features as $feature) {
            $status = $feature['is_enabled'] ? '✅ Enabled' : '❌ Disabled';
            $conditions = empty($feature['conditions']) ? 'None' : json_encode($feature['conditions']);
            $updatedAt = $feature['updated_at'] ? date('Y-m-d H:i:s', strtotime($feature['updated_at'])) : 'N/A';

            $rows[] = [
                $feature['name'],
                $status,
                $conditions,
                $updatedAt,
            ];
        }

        $this->table($headers, $rows);
        return 0;
    }
}
