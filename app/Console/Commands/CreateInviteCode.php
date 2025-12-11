<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateInviteCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-invite-code {count=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Invite Code';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = (int) $this->argument('count');

        for ($i = 0; $i < $count; $i++) {
            $this->generateInviteCode();
        }
    }

    private function generateInviteCode()
    {
        $code = strtoupper(Str::random(10));

        while (DB::table('invite_codes')->where('code', $code)->exists()) {
            $code = strtoupper(Str::random(10));
        }

        DB::table('invite_codes')->insert([
            'code' => $code,
            'expires_at' => now()->addDays(1), // Default expiration of 1 days
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
