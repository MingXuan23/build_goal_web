<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffRouteController extends Controller
{
    //
    public function showDashboard(Request $request)
    {
        return view('staff.dashboard.index');
    }
    public function showProfile(Request $request)
    {
        return view('staff.profile.index');
    }
}
