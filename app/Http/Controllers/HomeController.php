<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers\Controller;

use App\Assignment;
use App\AssignmentUser;
use App\AssignmentAs;
use App\AssignmentStatus;

class HomeController extends Controller
{
    public function index()
    {
        $assignments = Assignment::orderBy('start_datetime', 'DESC')
        	->paginate(3);

        return view('home.index', compact('assignments'));
    }
}
