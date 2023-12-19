<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Materi extends Controller
{
    public function index()
    {
        $learning_materials = DB::table('learning_materials')->get();
        return view('layouts.User.Learning-Materials.index', compact('learning_materials'));
    }
    public function download($id)
    {
        $learning_materials = DB::table('learning_materials')->where('id', $id)->first();
        return Storage::disk('learning-materials')->download($learning_materials->filename);
        // return Response::download(Storage::disk('learning-materials')->get($learning_materials->filename), $learning_materials->filename, [
        // 'Content-Length: ' . filesize(Storage::disk('learning-materials')->get($learning_materials->filename))
        // ]);
    }
}
