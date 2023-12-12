<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SendAttendanceSuccessNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-attendance-success-notification {attendance-id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (env('WA_SERVICES_STATUS')) {
            sleep(10);
            $attendance = Attendance::find($this->argument('attendance-id'));
            $user = User::find($attendance->user_id);
            Http::attach(
                'file_attendance',
                Storage::disk('attendance')->get($attendance->photo),
                'photo.jpg'
            )->post(env('WA_SERVICES') . 'attendance-success/' . implode('', explode('(+62)', implode('', explode(' ', $user->phone_number)))) . '/' . $attendance->status);
        }
    }
}
