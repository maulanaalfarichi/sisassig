<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function api()
    {
        $activity = Activity::orderBy('created_at', 'DESC')->get();
        return Datatables::of($activity)
            ->addIndexColumn()
            ->editColumn('subject_id', function($activity) {
                return $activity->subject->id . ' - ' . $activity->subject->name;
            })
            ->editColumn('causer_id', function($activity) {
                return $activity->causer->id . ' - ' . $activity->causer->name;
            })
            ->editColumn('created_at', function($activity) {
                return \DateHelper::id_datetime($activity->created_at);
            })
            ->addColumn('action', function($activity) {
                return '<a href="' . url('admin/activity-log/' . $activity->id) . '" class="btn btn-default btn-sm btn-flat"><i class="fa fa-fw fa-eye"></i></a>';
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
        if (\Auth::user()->cant('activity-log.show', Activity::class)) abort(403, 'Unauthorized action.');

        return view('admin.activity-log.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (\Auth::user()->cant('activity-log.show', Activity::class)) abort(403, 'Unauthorized action.');

        $activity = Activity::join('users', 'users.id', '=', 'activity_log.causer_id')
            ->select('activity_log.*', 'users.name as user_name', 'users.email as user_email')
            ->findOrFail($id);

        return view('admin.activity-log.show', compact('activity'));
    }
}
