<?php

namespace MohamedHekal\LaravelFeatureBox\Commands;

use Illuminate\Console\Command;
use MohamedHekal\LaravelFeatureBox\Contracts\FeatureBoxInterface;

class DisableFeatureCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'featurebox:disable {feature}';

    /**
     * The console command description.
     */
    protected $description = 'Disable a feature';

    /**
     * Execute the console command.
     */
    public function handle(FeatureBoxInterface $featureBox): int
    {
        $feature = $this->argument('feature');

        if ($featureBox->disable($feature)) {
            $this->info("Feature '{$feature}' has been disabled successfully!");

            return 0;
        }

        $this->error("Failed to disable feature '{$feature}'");

        return 1;
    }
}
