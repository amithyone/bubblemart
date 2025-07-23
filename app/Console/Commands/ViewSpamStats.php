<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ViewSpamStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spam:stats {--days=7 : Number of days to analyze}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View spam protection statistics';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $this->info("📊 Spam Protection Statistics (Last {$days} days)");
        $this->newLine();

        // Total registrations
        $totalRegistrations = User::where('created_at', '>=', now()->subDays($days))->count();
        $this->info("📈 Total Registrations: {$totalRegistrations}");

        // Suspicious registrations
        $suspiciousRegistrations = User::where('created_at', '>=', now()->subDays($days))
            ->where('is_suspicious', true)
            ->count();
        $this->info("⚠️  Suspicious Registrations: {$suspiciousRegistrations}");

        // Unverified registrations
        $unverifiedRegistrations = User::where('created_at', '>=', now()->subDays($days))
            ->whereNull('email_verified_at')
            ->count();
        $this->info("📧 Unverified Registrations: {$unverifiedRegistrations}");

        // Top registration IPs
        $topIPs = User::where('created_at', '>=', now()->subDays($days))
            ->whereNotNull('registration_ip')
            ->select('registration_ip', DB::raw('count(*) as count'))
            ->groupBy('registration_ip')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        if ($topIPs->count() > 0) {
            $this->newLine();
            $this->info("🌐 Top Registration IPs:");
            foreach ($topIPs as $ip) {
                $this->line("   {$ip->registration_ip}: {$ip->count} registrations");
            }
        }

        // Recent blocked attempts
        $this->newLine();
        $this->info("🚫 Recent Blocked Attempts:");
        
        // Check cache for recent blocks
        $recentBlocks = 0;
        $keys = Cache::get('recent_registrations_*', []);
        foreach ($keys as $key) {
            $count = Cache::get($key, 0);
            if ($count > 5) {
                $recentBlocks += $count - 5;
            }
        }
        
        $this->line("   Rate-limited attempts: {$recentBlocks}");

        // Spam score distribution
        $this->newLine();
        $this->info("📊 Spam Score Distribution:");
        $scores = [
            'Low (0-2)' => User::where('created_at', '>=', now()->subDays($days))->where('is_suspicious', false)->count(),
            'Medium (3-5)' => User::where('created_at', '>=', now()->subDays($days))->where('is_suspicious', true)->count(),
        ];

        foreach ($scores as $range => $count) {
            $percentage = $totalRegistrations > 0 ? round(($count / $totalRegistrations) * 100, 1) : 0;
            $this->line("   {$range}: {$count} ({$percentage}%)");
        }

        $this->newLine();
        $this->info("✅ Spam protection system is active and monitoring registrations.");
    }
}
