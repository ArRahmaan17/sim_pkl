<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendWaNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-wa-notification-command {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to send wa notification to student user (type ? single : many)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!in_array(Carbon::now()->dayOfWeek, [0, 1])) {
            if ($this->hasArgument('type')) {
                $type = $this->argument('type');
            } else {
                $type = 'many';
            }
            if ($type == 'single') {
                $phone_numbers = User::join('attendances as a', 'users.id', '!=', 'a.user_id')->where('role', 'S')->where(['role' => 'S'])->where('a.created_at', '>', now()->startOfDay())->where('a.created_at', '<', now()->endOfDay())->get();
                if ($phone_numbers->count() == 0) {
                    $phone_numbers =  User::where(['role' => 'S'])->get()->map(function ($user) {
                        return implode('', explode('(+62)', implode('', explode(' ', $user->phone_number))));
                    });
                }
                foreach ($phone_numbers as $key => $value) {
                    // Http::get(env('WA_SERVICES') . 'attendance-warning/' . $value);
                }
            } else {
                $phone_number = User::leftJoin('attendances as a', 'users.id', '!=', 'a.user_id')->where(['role' => 'S'])->where('a.created_at', '>', now()->startOfDay())->where('a.created_at', '<', now()->endOfDay())->get()->map(function ($user) {
                    return implode('', explode('(+62)', implode('', explode(' ', $user->phone_number))));
                });
                if ($phone_number->count() == 0) {
                    $phone_number =  User::where(['role' => 'S'])->get()->map(function ($user) {
                        return implode('', explode('(+62)', implode('', explode(' ', $user->phone_number))));
                    });
                }
                Http::post(env('WA_SERVICES') . 'attendance-warning', ['phone_number' => json_encode($phone_number)]);
            }
        }
    }
}
