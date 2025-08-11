<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanInviteCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-invite-code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up expired or unused invite codes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        DB::table('invite_codes')
            ->where('is_used', false)
            ->where('expires_at', '<', now())
            ->delete();
    }
}
