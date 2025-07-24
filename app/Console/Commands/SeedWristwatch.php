<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\WristwatchVariationSeeder;

class SeedWristwatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:wristwatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with a wristwatch product and its variations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🕐 Creating wristwatch product with variations...');
        
        $seeder = new WristwatchVariationSeeder();
        $seeder->run();
        
        $this->info('✅ Wristwatch seeder completed successfully!');
        $this->info('');
        $this->info('📦 Product created: Premium Classic Wristwatch');
        $this->info('🎨 Color variations: Black, Silver (+$15), Gold (+$25)');
        $this->info('📏 Size variations: 38mm (-$5), 42mm (base), 45mm (+$8)');
        $this->info('🏪 Store: Luxury Timepieces');
        $this->info('📂 Category: Wristwatches');
        $this->info('');
        $this->info('You can now test the variation system on the product details page!');
    }
}
