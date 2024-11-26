<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    //

    public function showOrganizationProfile(){
        return view('organization.profile.index');
    }
}
