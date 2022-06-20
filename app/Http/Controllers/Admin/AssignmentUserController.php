<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

use App\AssignmentUser;
use App\AssignmentAs;
use App\AssignmentStatus;

class AssignmentUserController extends Controller
{
    public function api($id)
    {
        $assignment = AssignmentUser::with(['user' => function($query) {
                $query->withTrashed();
            }, 'assignmentAs', 'assignmentStatus'])
            ->where('assignment_id', $id);
        return Datatables::of($assignment)
            ->addIndexColumn()
            ->editColumn('created_at', function($assignment) {
                return \DateHelper::id_datetime($assignment->created_at);
            })
            ->addColumn('action', function($assignment) {
                return '<a onclick="showData(' . $assignment->id . ')" class="btn btn-default btn-sm btn-flat"><i class="fa fa-fw fa-eye"></i></a>'.
                    '<a onclick="editData(' . $assignment->id . ')" class="btn btn-default btn-sm btn-flat"><i class="fa fa-fw fa-edit"></i></a>'.
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        $request->validate(AssignmentUser::rules(), [], AssignmentUser::attributes());

        $assignmentUser = new AssignmentUser;
        $data = $request->all();
        $assignmentUser->fill($data);
        $assignmentUser->save();

        return $assignmentUser;
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

        $assignmentUser = AssignmentUser::findOrFail($id)
            ->with(['user', 'assignmentAs', 'assignmentStatus'])->first();

        return $assignmentUser;
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

        $assignmentUser = AssignmentUser::findOrFail($id);

        return $assignmentUser;
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

        $request->validate(AssignmentUser::rules(), [], AssignmentUser::attributes());

        $assignmentUser = AssignmentUser::findOrFail($id);
        $data = $request->all();
        $assignmentUser->fill($data);
        $assignmentUser->update();

        return $assignmentUser;
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

        return AssignmentUser::destroy($id);
    }
}
