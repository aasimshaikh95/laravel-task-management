<?php

use App\Jobs\SendTaskDueReminders;
use Illuminate\Support\Facades\Schedule;

// Send reminder emails for tasks due tomorrow, every day at 8am
Schedule::job(new SendTaskDueReminders)->dailyAt('08:00');
