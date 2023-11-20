<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;

class UpdateStatusTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-status-task-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updating Status Task';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Task::where([
            'status' => 'Pending',
            'start_date' => now('Asia/Jakarta')->format('Y-m-d')
        ])->update(['status' => 'Progress']);
        Task::where([
            'status' => 'Progress',
            'deadline_date' => now('Asia/Jakarta')->format('Y-m-d')
        ])->update(['status' => 'End']);
    }
}
