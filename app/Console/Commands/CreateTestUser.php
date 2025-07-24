<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\TestUserSeeder;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:test-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test user with wallet and addresses for payment testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating test user for payment testing...');
        
        $seeder = new TestUserSeeder();
        $seeder->run();
        
        $this->info('Test user created successfully!');
        $this->info('You can now login with:');
        $this->info('Email: test2@example.com');
        $this->info('Password: password');
        $this->info('');
        $this->info('This user has:');
        $this->info('- ₦100,000 wallet balance');
        $this->info('- US address for testing US-only products');
        $this->info('- International address for testing international products');
        
        return Command::SUCCESS;
    }
}
