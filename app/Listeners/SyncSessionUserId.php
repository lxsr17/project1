<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;

class SyncSessionUserId
{
    public function handle(Login $event): void
    {
        $sessionId = session()->getId();

        if ($sessionId) {
            // دعم guard المستخدم سواء زائر أو تاجر
            $userId = $event->user->id;

            DB::table('sessions')->where('id', $sessionId)->update([
                'user_id' => $userId,
            ]);
        }
    }
}
