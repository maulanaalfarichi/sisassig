<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

use App\User;
use App\Role;
use App\Province;
use App\Regency;

class UserController extends Controller
{
    public function api()
    {
        $user = User::with(['roles'])->orderBy('created_at', 'DESC')->get();
        return Datatables::of($user)
            ->addIndexColumn()
            ->addColumn('roles', function($user) {
                return $user->roles->pluck('name')->implode(', ');
            })
            ->editColumn('active', function($user) {
                $result = ($user->active == 1) ? 'Ya' : 'Tidak';
                return '<span class="label label-success">' . $result . '</span>';
            })
            ->editColumn('created_at', function($user) {
                return \DateHelper::id_datetime($user->created_at);
            })
            ->addColumn('action', function($user) {
                return '<a href="' . url('admin/user/' . $user->id) . '" class="btn btn-default btn-sm btn-flat"><i class="fa fa-fw fa-eye"></i></a>'.
                    '<a href="' . url('admin/user/' . $user->id . '/edit') . '" class="btn btn-default btn-sm btn-flat"><i class="fa fa-fw fa-edit"></i></a>'.
                    '<a onclick="deleteData('.$user->id.')" class="btn btn-default btn-sm btn-flat"><i class="fa fa-fw fa-trash"></i></a>';
            })
            ->rawColumns(['active', 'action'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()->cant('user.show')) abort(403, 'Unauthorized action.');

        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Auth::user()->cant('user.create')) abort(403, 'Unauthorized action.');

        $user = new User;
        $roles = Role::all();
        $provinces = Province::all();

        return view('admin.user.create', compact('user', 'roles', 'provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::user()->cant('user.create')) abort(403, 'Unauthorized action.');

        $request->validate(User::rules('create'), [], User::attributes());

        $user = new User;
        $data = $request->all();
        $data['password'] = password_hash($request['password'], PASSWORD_DEFAULT);
        $data['photo'] = md5($data['name']) . rand(100, 999) . '.' . $request->photo->getClientOriginalExtension();
        $path = $request->photo->move(public_path('img'), $data['photo']);
        $user->fill($data);
        $user->save();

        $roles = !empty($request->get('roles')) ? $request->get('roles') : [];
        $user->syncRoles($roles);

        return redirect('admin/user')->with('success', '<b>Berhasil!</b> User berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (\Auth::user()->cant('user.show')) abort(403, 'Unauthorized action.');

        $user = User::with(['roles', 'birthplace', 'province', 'regency', 'district', 'village'])->findOrFail($id);
        $user->roles = $user->roles->pluck('name')->implode(', ');
        $user->age = \DateHelper::get_age($user->birth_date) . ' Tahun';
        $user->birth_date = \DateHelper::id_date($user->birth_date);
        $user->active = ($user->active == 1) ? 'Ya' : 'Tidak';

        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Auth::user()->cant('user.edit')) abort(403, 'Unauthorized action.');

        $user = User::findOrFail($id);
        $user->roles = $user->roles->pluck('id')->toArray();
        $roles = Role::all();
        $provinces = Province::all();

        return view('admin.user.edit', compact('user', 'roles', 'provinces'));
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
        if (\Auth::user()->cant('user.edit')) abort(403, 'Unauthorized action.');

        $request->validate(User::rules('edit'), [], User::attributes());

        $user = User::findOrFail($id);
        $data = $request->all();
        if (!empty($request['password'])) {
            $data['password'] = password_hash($request['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }
        if ($request->hasFile('photo')) {
            $data['photo'] = md5($data['name']) . rand(100, 999) . '.' . $request->photo->getClientOriginalExtension();
            $path = $request->photo->move(public_path('img'), $data['photo']);
        }
        $user->fill($data);
        $user->update();

        $roles = !empty($request->get('roles')) ? $request->get('roles') : [];
        $user->syncRoles($roles);

        return redirect('admin/user')->with('success', '<b>Berhasil!</b> User berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (\Auth::user()->cant('user.delete')) abort(403, 'Unauthorized action.');

        return User::destroy($id);
    }
}
