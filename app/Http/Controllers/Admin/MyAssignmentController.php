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

class MyAssignmentController extends Controller
{
    public function api()
    {
        $assignment_user = AssignmentUser::with(['assignment' => function($query) {
                $query->orderBy('created_at', 'DESC');
            }])
            ->where('user_id', \Auth::user()->id)
            ->get();
        return Datatables::of($assignment_user)
            ->addIndexColumn()
            ->editColumn('assignment.start_datetime', function($assignment_user) {
                return \DateHelper::id_datetime($assignment_user->assignment->start_datetime);
            })
            ->editColumn('assignment.end_datetime', function($assignment_user) {
                return \DateHelper::id_datetime($assignment_user->assignment->end_datetime);
            })
            ->addColumn('action', function($assignment_user) {
                return '<a href="' . url('admin/my-assignment/' . $assignment_user->assignment->id) . '" class="btn btn-default btn-sm btn-flat"><i class="fa fa-fw fa-eye"></i></a>';
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
        return view('admin.my-assignment.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment_user = new AssignmentUser;
        $assignment_as = AssignmentAs::all();
        $assignment_status = AssignmentStatus::all();

        return view('admin.my-assignment.show', compact('assignment', 'assignment_user', 'assignment_as', 'assignment_status'));
    }
}
