<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function attendance_history(int $user_id)
    {
        return self::where('user_id', $user_id)->where('created_at', '>', now('Asia/Jakarta')->startOfDay())->where('created_at', '<', now('Asia/Jakarta')->endOfDay())->count();
    }
}
