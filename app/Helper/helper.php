<?php

use Illuminate\Support\Facades\Storage;

function tasks_asset($path)
{
    return base64_encode(Storage::disk('task')->get($path));
}
function attendance_asset($path)
{
    return base64_encode(Storage::disk('attendance')->get($path));
}

function profile_asset($path)
{
    return base64_encode(Storage::disk('profile-picture')->get($path));
}
