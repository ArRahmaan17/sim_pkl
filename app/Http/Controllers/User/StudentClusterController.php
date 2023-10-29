<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cluster;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentClusterController extends Controller
{
    public function index()
    {
        return view('layouts.User.Cluster.index', [
            'users' => User::where('role', 'S')->get(),
            'clusters' => Cluster::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cluster_ic' => 'string'
        ]);
        DB::beginTransaction();
        try {
            User::find($request->id)->update([
                'cluster_id' => intval($request->cluster_id) != 0 ? intval($request->cluster_id) : null, 'updated_at' => now('Asia/Jakarta')
            ]);
            DB::commit();
            return Response()->json(['message' => 'Successfully Change Group'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return Response()->json(['message' => 'Failed change group'], 500);
        }
    }
}
