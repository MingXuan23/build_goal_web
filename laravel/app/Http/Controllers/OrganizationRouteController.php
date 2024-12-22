<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class OrganizationRouteController extends Controller
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

        return view('organization.dashboard.index', [
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
        return view('organization.profile.index', [
            'datas' => $data
        ]);
    }

    public function showContent(Request $request)
    {
        $user = Auth::user();
        $stateCitiesJson = file_get_contents(public_path('assets/json/states-cities.json'));
        $stateCities = json_decode($stateCitiesJson, true);
        // $user->id;

        $user_data = DB::table('contents as contents')->where('contents.user_id', $user->id)
            ->join('content_types', 'contents.content_type_id', '=', 'content_types.id')
            ->select(
                'contents.id',
                'contents.name',
                'contents.created_at',
                'contents.link',
                'contents.status',
                'contents.user_id',
                'contents.enrollment_price',
                'contents.place',
                'contents.reason_phrase',
                'contents.reject_reason',
                'contents.participant_limit',
                'contents.content_type_id',
                'content_types.type',
            )
            ->orderBy('contents.created_at', 'desc')
            ->get();
        $packages = DB::table('package')->where('status', true)->get();
        if ($request->ajax()) {
            $table = DataTables::of($user_data)->addIndexColumn();

            $table->addColumn('action', function ($row) {
                if ($row->reason_phrase == 'APPROVED') {
                    $button = 
                    '<div class="d-flex">
                        <button class="btn btn-icon btn-sm btn-success-transparent rounded-pill me-2 view-content" 
                                data-id="' . $row->id . '" 
                                data-name="' . htmlspecialchars($row->name, ENT_QUOTES) . '" 
                                data-base-price="100" 
                                data-base-state="2" 
                                data-bs-toggle="modal" 
                                data-bs-target="#dynamicModal">
                            <i class="bi bi-arrow-right-circle-fill"></i>
                        </button>';
                
                if ($row->content_type_id == 1 || $row->content_type_id == 3 || $row->content_type_id == 5) {
                    $button .= '<button class="btn btn-icon btn-sm btn-info-transparent rounded-pill me-2" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalAddCard-' . $row->id . '">
                                    <i class="bx bxs-credit-card"></i>
                                </button>';
                }
                
                $button .= '</div>';
                
                } elseif ($row->reason_phrase == 'PENDING') {
                    $button =
                        '<div class="d-flex justify-content-between">
                            <span class="text-warning p-2 me-1 fw-bold">
                                <i class="bi bi-circle-fill"></i> PENDING
                            </span>
                        </div>';
                } else {
                    $button =
                        '<div class="d-flex">
                            <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill me-2"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#reject-' . $row->id . '">
                                <i class="ri-eye-line fw-bold"></i>
                            </button>
                        </div>';
                }
                return $button;
            });
            

            $table->addColumn('status', function ($row) {
                if ($row->reason_phrase == 'APPROVED') {

                    $button =
                        '<div class="d-flex">
                        <span class=" text-success p-2 me-1 fw-bold">
                             <i class="bi bi-circle-fill"></i> APPROVED
                        </span>
                    </div>';
                } elseif ($row->reason_phrase == 'PENDING') {
                    $button =
                        '<div class="d-flex">
                         <span class=" text-warning p-2 me-1 fw-bold">
                             <i class="bi bi-circle-fill"></i> IN REVIEW
                        </span>
                    </div>';
                } else {
                    $button =
                        '<div class="d-flex">
                          <span class=" text-danger p-2 me-1 fw-bold">
                             <i class="bi bi-circle-fill"></i> REJECTED
                        </span>
                    </div>';
                }
                return $button;
            });

            
            $table->addColumn('card', function ($row) {
                if ($row->content_type_id == 1 || $row->content_type_id == 3 || $row->content_type_id == 5) {

                    $button =
                        '<div class="d-flex">
                        <span class=" text-success p-2 me-1 fw-bold">
                             <i class="bi bi-circle-fill"></i> ELIGIBLE
                        </span>
                    </div>';
                } else {
                    $button =
                        '<div class="d-flex">
                         <span class=" text-danger p-2 me-1 fw-bold">
                             <i class="bi bi-circle-fill"></i> NOT ELIGIBLE
                        </span>
                    </div>';
                }
                return $button;
            });

            $table->rawColumns(['status', 'action','card']);
            return $table->make(true);
        }

        $states = DB::table('states')->select('id', 'name')->get();
        return view('organization.contentManagement.index', [
            'content_data' => $user_data,
            'stateCities' => $stateCities,
            'packages' => $packages,
            'states' => $states
        ]);
    }

    public function showAddContent(Request $request)
    {
        $content_types = DB::table('content_types')->where('status', true)->get();
        $stateCitiesJson = file_get_contents(public_path('assets/json/states-cities.json'));
        $stateCities = json_decode($stateCitiesJson, true);
        $states = DB::table('states')->select('id', 'name')->get();
        return view('organization.contentManagement.applyContent', compact('content_types', 'stateCities','states'));
    }

    public function showMicroLearningForm()
    {
        return view('organization.contentManagement.microLearning');
    }

    
}
