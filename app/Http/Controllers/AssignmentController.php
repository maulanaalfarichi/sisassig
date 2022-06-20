<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers\Controller;

use App\Assignment;
use App\AssignmentUser;
use App\AssignmentAs;
use App\AssignmentStatus;

class AssignmentController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment_users = AssignmentUser::with(['user', 'assignmentAs'])
            ->where('assignment_id', $id)
            ->whereNotIn('status_id', [3, 4])
            ->get();
        return view('assignment.show', compact('assignment', 'assignment_as', 'assignment_status', 'assignment_users'));
    }
}
