<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allMenus = Menu::with('child')->orderByRaw('ordered,position')->get();
        $routeCollection = Route::getRoutes()->getRoutesByName();
        // dd($routeCollection->getName());
        $routeCollection = collect($routeCollection)->filter(function ($route, $index) {
            if ($route->methods()[0] == 'GET') {
                return $route;
            }
        });
        return view('layouts.Masters.Menu.index', compact('allMenus', 'routeCollection'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'icon' => 'required',
                'link' => 'required',
                'access_to' => 'required|array',
            ],
            [
                'access_to.required' => 'The access menu field is required',
            ]
        );
        $data = $request->except('_token');
        if (count($request->access_to) > 1) {
            $data['access_to'] = "All";
        } else {
            $data['access_to'] = $request->access_to[0];
        }
        $data['created_at'] = now('Asia/Jakarta');
        DB::beginTransaction();
        try {
            Menu::insert($data);
            DB::commit();
            return Response()
                ->json(
                    [
                        'message' => 'Menu ' . $data['name'] . ' Successfully Created',
                        'records' => Menu::with('child')->orderByRaw('ordered,position')->get(),
                    ],
                    200
                );
        } catch (\Throwable $th) {
            DB::rollBack();
            return Response()
                ->json(
                    ['message' => 'Menu ' . $data['name'] . ' Failed Created'],
                    500
                );
        }
    }

    public function sort(Request $request)
    {
        $request->validate(['menus' => 'required']);
        $data_menus = [];
        foreach ($request->menus as $index => $menu) {
            if ($menu['parent'] == 0) {
                if (count($data_menus) == 0) {
                    $menu['ordered'] = 1;
                    $menu['updated_at'] = now('Asia/Jakarta');
                    unset($menu['child'], $menu['created_at']);
                    array_push($data_menus, $menu);
                } else {
                    $last_order = 1;
                    foreach ($data_menus as $key => $value) {
                        if (intval($value['parent']) == 0) {
                            $last_order = $value['ordered'] + 1;
                        }
                    }
                    $menu['ordered'] = $last_order;
                    $menu['updated_at'] = now('Asia/Jakarta');
                    unset($menu['child'], $menu['created_at']);
                    array_push($data_menus, $menu);
                }
            } else {
                if (count($data_menus) == 0) {
                    $menu['ordered'] = 1;
                    $menu['updated_at'] = now('Asia/Jakarta');
                    unset($menu['child'], $menu['created_at']);
                    array_push($data_menus, $menu);
                } else {
                    $last_order = 1;
                    foreach ($data_menus as $key => $value) {
                        if (intval($value['parent']) != 0 && intval($value['parent']) == intval($menu['parent'])) {
                            $last_order = $value['ordered'] + 1;
                        }
                    }
                    $menu['ordered'] = $last_order;
                    $menu['updated_at'] = now('Asia/Jakarta');
                    unset($menu['child'], $menu['created_at']);
                    array_push($data_menus, $menu);
                }
            }
        }
        DB::beginTransaction();
        try {
            foreach ($data_menus as $key => $menu) {
                Menu::where('id', $menu['id'])->update($menu);
            }
            DB::commit();
            return Response()->json([
                'message' => 'Successfully Ordering Your Menu',
                'records' => Menu::with('child')->orderByRaw('ordered,position')->get()
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Response()->json([
                'message' => 'Failed Ordering Your Menu', 'records' => Menu::all()
            ], 500);
        }
    }

    public function all()
    {
        $data = Menu::where('position', 'S')->get();
        if ($data == null) {
            return Response()->json([
                'message' => 'We Failed Found Your Data',
                'record' => []
            ]);
        } else {
            return Response()->json([
                'message' => 'We Found Your Data',
                'record' => $data
            ]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Menu::find($id);
        if ($data == null) {
            return Response()->json([
                'message' => 'We Failed Found Your Data',
                'record' => []
            ]);
        } else {
            return Response()->json([
                'message' => 'We Found Your Data',
                'record' => $data
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'icon' => 'required',
            'link' => 'required',
            'parent' => 'required',
            'position' => 'required',
            'access_to' => 'required',
        ]);
        $data = $request->except('_token', 'id');
        if (count($request->access_to) > 1) {
            $data['access_to'] = "All";
        } else {
            $data['access_to'] = $request->access_to[0];
        }
        $data['updated_at'] = now('Asia/Jakarta');
        DB::beginTransaction();
        try {
            Menu::find($id)->update($data);
            DB::commit();
            return Response()
                ->json(
                    [
                        'message' => 'Menu ' . $data['name'] . ' Updated Successfully',
                        'records' => Menu::all(),
                    ],
                    200
                );
        } catch (\Throwable $th) {
            DB::rollBack();
            return Response()
                ->json(
                    ['message' => 'Menu ' . $data['name'] . ' Failed to Updated'],
                    500
                );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            if (Menu::where('parent', $id)->count() > 0) {
                return Response()->json([
                    'message' => "Can't delete menu because it still has related children",
                ], 500);
            } else {
                Menu::find($id)->delete();
                DB::commit();
                return Response()->json(['message' => "Successfully Deleted Menu"], 200);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
            dd($th);
            return Response()->json([
                'message' => "Failed Delete Menu",
            ], 500);
        }
    }
}
