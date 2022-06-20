<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

use App\Assignment;
use App\AssignmentUser;
use App\AssignmentAs;
use App\AssignmentStatus;

class AssignmentController extends Controller
{
    public function api()
    {
        $assignment = Assignment::orderBy('created_at', 'DESC')->get();
        return Datatables::of($assignment)
            ->addIndexColumn()
            ->editColumn('start_datetime', function($assignment) {
                return \DateHelper::id_datetime($assignment->start_datetime);
            })
            ->editColumn('end_datetime', function($assignment) {
                return \DateHelper::id_datetime($assignment->end_datetime);
            })
            ->addColumn('action', function($assignment) {
                return '<a href="' . url('admin/assignment/' . $assignment->id) . '" class="btn btn-default btn-sm btn-flat"><i class="fa fa-fw fa-eye"></i></a>'.
                    '<a href="' . url('admin/assignment/' . $assignment->id . '/edit') . '" class="btn btn-default btn-sm btn-flat"><i class="fa fa-fw fa-edit"></i></a>'.
                    '<a onclick="deleteData(' . $assignment->id . ')" class="btn btn-default btn-sm btn-flat"><i class="fa fa-fw fa-trash"></i></a>';
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
        if (\Auth::user()->cant('assignment.show', Assignment::class)) abort(403, 'Unauthorized action.');

        return view('admin.assignment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Route $route)
    {
        if (\Auth::user()->cant('assignment.create', Assignment::class)) abort(403, 'Unauthorized action.');

        $assignment = new Assignment;

        return view('admin.assignment.create', compact('assignment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::user()->cant('assignment.create', Assignment::class)) abort(403, 'Unauthorized action.');

        $request->validate(Assignment::rules(), [], Assignment::attributes());

        $assignment = new Assignment;
        $data = $request->all();
        $assignment->fill($data);
        $assignment->save();

        return redirect('admin/assignment')->with('success', '<b>Berhasil!</b> Penugasan berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (\Auth::user()->cant('assignment.show', Assignment::class)) abort(403, 'Unauthorized action.');

        $assignment = Assignment::findOrFail($id);
        $assignment_user = new AssignmentUser;
        $assignment_as = AssignmentAs::all();
        $assignment_status = AssignmentStatus::all();

        return view('admin.assignment.show', compact('assignment', 'assignment_user', 'assignment_as', 'assignment_status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Auth::user()->cant('assignment.edit', Assignment::class)) abort(403, 'Unauthorized action.');

        $assignment = Assignment::findOrFail($id);

        return view('admin.assignment.edit', compact('assignment'));
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
        if (\Auth::user()->cant('assignment.edit', Assignment::class)) abort(403, 'Unauthorized action.');

        $request->validate(Assignment::rules(), [], Assignment::attributes());

        $assignment = Assignment::findOrFail($id);
        $data = $request->all();
        $assignment->fill($data);
        $assignment->update();

        return redirect('admin/assignment')->with('success', '<b>Berhasil!</b> Penugasan berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (\Auth::user()->cant('assignment.delete', Assignment::class)) abort(403, 'Unauthorized action.');

        return Assignment::destroy($id);
    }
}
