<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\CreditHistory;
use Carbon\Carbon;

class ExpireCredits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'credits:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire user credits that have passed their expiration date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired credits...');

        // Find users with expired credits
        $usersWithExpiredCredits = User::where('credit', '>', 0)
            ->whereNotNull('credit_expires_at')
            ->where('credit_expires_at', '<', Carbon::now())
            ->get();

        if ($usersWithExpiredCredits->isEmpty()) {
            $this->info('No expired credits found.');
            return 0;
        }

        $expiredCount = 0;

        foreach ($usersWithExpiredCredits as $user) {
            $expiredCredits = $user->credit;
            $expirationDate = $user->credit_expires_at;

            // Reset user credits
            $user->update([
                'credit' => 0,
                'credit_expires_at' => null
            ]);

            // Create credit history record
            CreditHistory::create([
                'user_id' => $user->id,
                'amount' => '-' . $expiredCredits,
                'action' => 'Expired',
                'description' => "Credits expired on {$expirationDate->format('Y-m-d H:i:s')}. {$expiredCredits} credits have been reset to 0.",
            ]);

            $expiredCount++;
            $this->line("Expired {$expiredCredits} credits for user {$user->email} (ID: {$user->id})");
        }

        $this->info("Successfully expired credits for {$expiredCount} users.");
        return 0;
    }
}
