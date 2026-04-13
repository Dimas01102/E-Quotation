<?php

use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes (Scheduler)
|--------------------------------------------------------------------------
*/

// ── Auto-close batch yang sudah lewat deadline ─────────────────────────
// Berjalan setiap hari jam 00:05 (malam)
Schedule::command('batches:close-expired')
    ->dailyAt('00:05')
    ->withoutOverlapping()
    ->runInBackground();

// ── Kirim reminder H-3 dan H-1 ke supplier yang belum submit ──────────
// Berjalan setiap hari jam 08:00 pagi
Schedule::command('batches:send-reminders')
    ->dailyAt('08:00')
    ->withoutOverlapping()
    ->runInBackground();