<?php

namespace MohamedHekal\LaravelFeatureBox\Commands;

use Illuminate\Console\Command;
use MohamedHekal\LaravelFeatureBox\Contracts\FeatureBoxInterface;

class EnableFeatureCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'featurebox:enable {feature} {--conditions=}';

    /**
     * The console command description.
     */
    protected $description = 'Enable a feature with optional conditions';

    /**
     * Execute the console command.
     */
    public function handle(FeatureBoxInterface $featureBox): int
    {
        $feature = $this->argument('feature');
        $conditions = [];

        if ($this->option('conditions')) {
            $conditions = json_decode($this->option('conditions'), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->error('Invalid JSON format for conditions');

                return 1;
            }
        }

        if ($featureBox->enable($feature, $conditions)) {
            $this->info("Feature '{$feature}' has been enabled successfully!");

            if (! empty($conditions)) {
                $this->line('Conditions: '.json_encode($conditions, JSON_PRETTY_PRINT));
            }

            return 0;
        }

        $this->error("Failed to enable feature '{$feature}'");

        return 1;
    }
}
