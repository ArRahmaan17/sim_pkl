<?php

use Illuminate\Support\Facades\Storage;

function tasks_asset($path)
{
    return base64_encode(Storage::disk('task')->get($path));
}
