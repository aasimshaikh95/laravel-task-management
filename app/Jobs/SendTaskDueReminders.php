<?php

namespace App\Jobs;

use App\Mail\TaskDueReminderMail;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendTaskDueReminders implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public function handle(): void
    {
        Task::dueTomorrow()
            ->with('user')
            ->get()
            ->groupBy('user_id')
            ->each(function ($tasks) {
                $user = $tasks->first()->user;
                Mail::to($user)->send(new TaskDueReminderMail($user, $tasks));
            });
    }
}
