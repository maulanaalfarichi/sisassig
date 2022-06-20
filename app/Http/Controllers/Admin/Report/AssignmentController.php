<?php

namespace App\Http\Controllers\Admin\Report;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers\Controller;

use App\Assignment;
use App\AssignmentUser;
use App\AssignmentAs;
use App\AssignmentStatus;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        if (\Auth::user()->cant('assignment.show', Assignment::class)) abort(403, 'Unauthorized action.');

        $start = $request->input('start', '');
        $end = $request->input('end', '');

        return view('admin.report.assignment.index', compact('start', 'end'));
    }

    public function print(Request $request)
    {
        if (\Auth::user()->cant('assignment.show', Assignment::class)) abort(403, 'Unauthorized action.');

        $start = $request->input('start', '');
        $end = $request->input('end', '');

        $assignments = Assignment::with(['assignmentUser' => function($query) {
                $query->with(['user' => function($query) {
                    $query->withTrashed();
                }]);
            }])
            ->whereBetween('start_datetime', [$start, $end])
            ->get();

        return view('admin.report.assignment.print', compact('assignments', 'start', 'end'));
    }

    public function letterIndex($id)
    {
        if (\Auth::user()->cant('assignment.show', Assignment::class)) abort(403, 'Unauthorized action.');

        $assignment = Assignment::findOrFail($id);

        return view('admin.report.assignment.letter-index', compact('assignment', 'id'));
    }

    public function letterPrint($id)
    {
        if (\Auth::user()->cant('assignment.show', Assignment::class)) abort(403, 'Unauthorized action.');

        $assignment = Assignment::with(['assignmentUser' => function($query) {
                $query->with(['user' => function($query) {
                    $query->withTrashed();
                }]);
            }])
            ->findOrFail($id);

        return view('admin.report.assignment.letter-print', compact('assignment', 'id'));
    }
}
