<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContentCreatorRouteController extends Controller
{
    //
    

    public function showDashboard(Request $request)
    {
     
        $proposedContents = DB::table('contents')
        ->where('user_id', Auth::user()->id)->count();
        $approvedContents = DB::table('contents')
            ->where('user_id', Auth::user()->id)
            ->where('reason_phrase', 'APPROVED')
            ->count();
        $rejectedContents = DB::table('contents')
            ->where('user_id', Auth::user()->id)
            ->where('reason_phrase', 'REJECTED')
            ->count();

        $pendingContents = DB::table('contents')
        ->where('user_id', Auth::user()->id)
        ->where('reason_phrase', 'PENDING')
        ->count();

        return view('contentcreator.dashboard.index', [
            'proposedContents' => $proposedContents,
            'approvedContents' => $approvedContents,
            'rejectedContents' => $rejectedContents,
            'pendingContents' => $pendingContents,
        ]);
    }
    public function showProfile(Request $request)
    {
        $data = DB::table('users as u')
        ->where('u.id', Auth::user()->id)
            ->join('roles as r', function ($join) {
                $join->whereRaw('JSON_CONTAINS(u.role, JSON_ARRAY(r.id))');
            })
            ->join('organization_user as ou', 'ou.user_id', 'u.id')
            ->join('organization as o', 'o.id', 'ou.organization_id')
            ->select(
                'u.*',
                'o.name as org_name',
                'o.desc as org_desc',
                'o.status as org_status',
                'o.logo as org_logo',
                'o.address as org_address',
                'o.state as org_state',
                'o.org_type',
                DB::raw('GROUP_CONCAT(r.role) as role_names')
            )
            ->groupBy(
                'u.id',
                'u.name',
                'u.password',
                'u.telno',
                'u.address',
                'u.state',
                'u.email',
                'u.status',
                'u.role',
                'u.active',
                'u.created_at',
                'u.Updated_at',
                'u.email_status',
                'u.verification_code',
                'u.icNo',
                'u.remember_token',
                'u.ekyc_status',
                'u.ekyc_time',
                'u.ekyc_signature',
                'o.name',
                'o.desc',
                'o.status',
                'o.logo',
                'o.address',
                'o.state',
                'o.org_type',
            )
            ->orderby('u.created_at', 'asc')
            ->get();
        return view('contentcreator.profile.index',[
            'datas' => $data
        ]);
    }
    public function showAddContentForm(Request $request)
    {
        $content_types = DB::table('content_types')->where('status', true)->get();
        $stateCitiesJson = file_get_contents(public_path('assets/json/states-cities.json'));
        $stateCities = json_decode($stateCitiesJson, true);
        $states = DB::table('states')->select('id', 'name')->get();
        return view('contentcreator.contentManagement.applyContent', compact('content_types', 'stateCities','states'));
    }

    public function showMicroLearning()
    {
        return view('contentcreator.contentManagement.microLearning');
    }

}
