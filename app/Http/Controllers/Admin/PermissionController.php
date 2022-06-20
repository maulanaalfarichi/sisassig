<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

use App\Permission;

class PermissionController extends Controller
{
    public function api()
    {
        $permission = Permission::orderBy('created_at', 'DESC')->get();
        return Datatables::of($permission)
            ->addIndexColumn()
            ->editColumn('created_at', function($permission) {
                return \DateHelper::id_datetime($permission->created_at);
            })
            ->addColumn('action', function($permission) {
                return '<a href="' . url('admin/permission/' . $permission->id . '/edit') . '" class="btn btn-default btn-sm btn-flat"><i class="fa fa-fw fa-edit"></i></a>'.
                    '<a onclick="deleteData('.$permission->id.')" class="btn btn-default btn-sm btn-flat"><i class="fa fa-fw fa-trash"></i></a>';
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
        if (\Auth::user()->cant('permission.show')) abort(403, 'Unauthorized action.');

        return view('admin.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Auth::user()->cant('permission.create')) abort(403, 'Unauthorized action.');

        $permission = new Permission;

        return view('admin.permission.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::user()->cant('permission.create')) abort(403, 'Unauthorized action.');

        $request->validate(Permission::rules('create'), [], Permission::attributes());

        $permission = new Permission;
        $data = $request->all();
        $permission->fill($data);
        $permission->save();

        return redirect('admin/permission')->with('success', '<b>Berhasil!</b> Permission berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404, 'Not found.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Auth::user()->cant('permission.edit')) abort(403, 'Unauthorized action.');

        $permission = Permission::findOrFail($id);

        return view('admin.permission.edit', compact('permission'));
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
        if (\Auth::user()->cant('permission.edit')) abort(403, 'Unauthorized action.');

        $request->validate(Permission::rules('edit'), [], Permission::attributes());

        $permission = Permission::findOrFail($id);
        $data = $request->all();
        $permission->fill($data);
        $permission->update();

        return redirect('admin/permission')->with('success', '<b>Berhasil!</b> Permission berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (\Auth::user()->cant('permission.delete')) abort(403, 'Unauthorized action.');

        return Permission::destroy($id);
    }
}
