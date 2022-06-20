<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

use App\Role;
use App\Permission;

class RoleController extends Controller
{
    public function api()
    {
        $role = Role::orderBy('created_at', 'DESC')->get();
        return Datatables::of($role)
            ->addIndexColumn()
            ->editColumn('created_at', function($role) {
                return \DateHelper::id_datetime($role->created_at);
            })
            ->addColumn('action', function($role) {
                return '<a href="' . url('admin/role/' . $role->id) . '" class="btn btn-default btn-sm btn-flat"><i class="fa fa-fw fa-eye"></i></a>'.
                    '<a href="' . url('admin/role/' . $role->id . '/edit') . '" class="btn btn-default btn-sm btn-flat"><i class="fa fa-fw fa-edit"></i></a>'.
                    '<a onclick="deleteData('.$role->id.')" class="btn btn-default btn-sm btn-flat"><i class="fa fa-fw fa-trash"></i></a>';
            })
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()->cant('role.show')) abort(403, 'Unauthorized action.');

        return view('admin.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Auth::user()->cant('role.create')) abort(403, 'Unauthorized action.');

        $role = new Role;
        $permissions = Permission::all();

        return view('admin.role.create', compact('role', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::user()->cant('role.create')) abort(403, 'Unauthorized action.');

        $request->validate(Role::rules('create'), [], Role::attributes());

        $role = new Role;
        $data = $request->all();
        $data['guard_name'] = config('auth.defaults')['guard'];
        $role->fill($data);
        $role->save();

        $permissions = !empty($request->get('permissions')) ? $request->get('permissions') : [];
        $role->syncPermissions($permissions);

        return redirect('admin/role')->with('success', '<b>Berhasil!</b> Role berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (\Auth::user()->cant('role.show')) abort(403, 'Unauthorized action.');

        $role = Role::with('permissions')->findOrFail($id);

        return view('admin.role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Auth::user()->cant('role.edit')) abort(403, 'Unauthorized action.');

        $role = Role::findOrFail($id);
        $role->permissions = $role->permissions->pluck('id')->toArray();
        $permissions = Permission::all();
        return view('admin.role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (\Auth::user()->cant('role.edit')) abort(403, 'Unauthorized action.');

        $request->validate(Role::rules('edit'), [], Role::attributes());

        $role = Role::findOrFail($id);
        $data = $request->all();
        $role->fill($data);
        $role->update();

        $permissions = !empty($request->get('permissions')) ? $request->get('permissions') : [];
        $role->syncPermissions($permissions);

        return redirect('admin/role')->with('success', '<b>Berhasil!</b> Role berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (\Auth::user()->cant('role.delete')) abort(403, 'Unauthorized action.');

        return Role::destroy($id);
    }
}
