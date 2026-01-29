<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Cluster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ClusterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layouts.Masters.Cluster.index', ['clusters' => Cluster::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|alpha_num|min:4',
            'description' => 'required|min:10',
        ]);
        DB::beginTransaction();
        try {
            $data = $request->except('_token');
            $data['created_at'] = now('Asia/Jakarta');
            Cluster::insert($data);
            DB::commit();

            return Response()->json([
                'message' => 'Successfully create new student cluster',
            ], 200);
        } catch (Throwable $e) {
            DB::rollBack();

            return Response()->json(['message' => 'Failed create new student cluster'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = Cluster::findOrFail($id);
            $response = ['message' => 'We found your data', 'data' => $data];
            $status = 200;

            return Response()->json($response, $status);
        } catch (\Throwable $th) {
            $status = 404;
            $response = ['message' => 'We cant found your data', 'data' => []];

            return Response()->json($response, $status);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $data = $request->except('_token');
            $data['updated_at'] = now('Asia/Jakarta');
            Cluster::find($id)->update($data);
            DB::commit();

            return Response()->json([
                'message' => 'Successfully update student cluster',
            ], 200);
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();

            return Response()->json([
                'message' => 'Failed update student cluster',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $cluster = Cluster::with('users')->findOrFail($id);
            if (count($cluster->users) > 0) {
                return Response()->json(['message' => "Can't delete menu because it still has related children"], 500);
            }
            $cluster->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if ($th->getCode() == 0) {
                return Response()->json(['message' => "We can't found your data"], 404);
            }
        }
    }
}
