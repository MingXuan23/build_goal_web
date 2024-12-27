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
                if (($row->content_type_id == 1 || $row->content_type_id == 3 || $row->content_type_id == 5) && $row->reason_phrase === 'APPROVED') {
                    return '<div class="d-flex">
                        <button class="btn btn-icon btn-sm btn-info-transparent rounded-pill me-2 smart-card-btn" 
                                data-id="' . $row->id . '"
                                data-name="' . htmlspecialchars($row->name, ENT_QUOTES) . '"
                                data-bs-toggle="modal" 
                                data-bs-target="#smartCardModal">
                            <i class="bx bxs-credit-card"></i>
                        </button>
                    </div>';
                } else {
                    return '<div class="d-flex">
                        <span class="text-danger p-2 me-1 fw-bold">
                            <i class="bi bi-circle-fill"></i> NOT ELIGIBLE
                        </span>
                    </div>';
                }
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

    public function showNotification(Request $request)
    {
        $logs = DB::table('email_logs')
            ->select([
                'id',
                'email_type',
                'recipient_email',
                'from_email',
                'name',
                'status',
                'response_data',
                'created_at'
            ])
            ->where('recipient_email', Auth::user()->email)
            ->whereIn('email_type', ['NOTIFICATION USER', 'NOTIFICATION TO ALL USERS','APPLY CONTENT - APPROVED','APPLY CONTENT - PENDING','APPLY CONTENT - REJECTED'])
            ->orderBy('id', 'desc')
            ->get();
        if ($request->ajax()) {

            $table = DataTables::of($logs)->addIndexColumn();
            $table->addColumn('status', function ($row) {
                $statusClass = $row->status === 'SUCCESS' ? 'success' : 'danger';
                return '<span class="badge bg-' . $statusClass . ' p-2">' . $row->status . '</span>';
            });
            $table->addColumn('action', function ($row) {
                $button = '<div class="d-flex justify-content-center align-items-center">
                                <button class="btn btn-icon btn-sm btn-info-transparent rounded-pill me-2"
                                        data-bs-toggle="modal" data-bs-target="#modalView-' . $row->id . '">
                                        <i class="ri-eye-line fw-bold"></i>
                                    </button>
                            </div>
                    ';
                return $button;
            });


            $table->rawColumns(['status', 'action']);

            return $table->make(true);
        }


        return view('organization.notification.index', [
            'datas' => $logs
        ]);
    }

    public function showContentUserClickedViewedOrganization(Request $request)
    {
        $datas = DB::table('user_content as userContent')
            ->join('contents', 'userContent.content_id', '=', 'contents.id')
            ->where('contents.user_id', Auth::user()->id)
            ->join('users as contentOwner', 'contents.user_id', '=', 'contentOwner.id')
            ->join('users', 'userContent.user_id', '=', 'users.id') 
            ->join('content_types', 'contents.content_type_id', '=', 'content_types.id')
            ->join('interaction_type', 'userContent.interaction_type_id', '=', 'interaction_type.id')
            ->whereIn('userContent.interaction_type_id', [1,2])
            ->select(
                DB::raw('MAX(userContent.id) as id'),
                DB::raw('MAX(userContent.user_id) as user_id'),
                DB::raw('MAX(userContent.interaction_type_id) as interaction_type_id'),
                DB::raw('MAX(userContent.status) as status'),
                DB::raw('MAX(userContent.content_id) as content_id'),
                DB::raw('MAX(userContent.ip_address) as ip_address'),
                DB::raw('MAX(userContent.token) as token'),
                DB::raw('MAX(userContent.verification_code) as verification_code'),
                DB::raw('MAX(userContent.`desc`) as `desc`'),
                DB::raw('MAX(userContent.created_at) as user_content_created_at'),
                DB::raw('MAX(users.name) as user_name'), 
                DB::raw('MAX(users.email) as user_email'), 
                DB::raw('MAX(contentOwner.name) as content_owner_name'),
                DB::raw('MAX(contentOwner.email) as content_owner_email'), 
                DB::raw('MAX(contents.name) as name'),
                DB::raw('MAX(contents.link) as link'),
                DB::raw('MAX(contents.content) as content'),
                DB::raw('MAX(contents.enrollment_price) as enrollment_price'),
                DB::raw('MAX(contents.category_weight) as category_weight'),
                DB::raw('MAX(contents.content_type_id) as content_type_id'),
                DB::raw('MAX(contents.edit_from) as edit_from'),
                DB::raw('MAX(contents.place) as place'),
                DB::raw('MAX(contents.participant_limit) as participant_limit'),
                DB::raw('MAX(contents.state) as state'),
                DB::raw('MAX(contents.closed_at) as closed_at'),
                DB::raw('MAX(contents.reason_phrase) as reason_phrase'),
                DB::raw('MAX(contents.first_date) as first_date'),
                DB::raw('MAX(contents.org_id) as org_id'),
                DB::raw('MAX(contents.reject_reason) as reject_reason'),
                DB::raw('MAX(contents.image) as image'),
                DB::raw('MAX(contents.status) as content_status'),
                DB::raw('MAX(contents.created_at) as content_created_at'),
                DB::raw('MAX(interaction_type.type) as interaction_type'),
                DB::raw('MAX(content_types.type) as content_type'),
                DB::raw('COUNT(userContent.content_id) as total_interactions')
            )
            ->groupBy('userContent.content_id', 'userContent.interaction_type_id')
            ->orderBy('content_created_at', 'desc') 
            ->get();

        // $datass = DB::table('user_content as userContent')
        //     ->join('contents', 'userContent.content_id', '=', 'contents.id')
        //     ->join('users', 'userContent.user_id', '=', 'users.id')
        //     ->join('interaction_type', 'userContent.interaction_type_id', '=', 'interaction_type.id')
        //     ->select(
        //         'userContent.*',
        //         'users.name as user_name',
        //         'users.email as user_email',
        //         'contents.*',
        //         'contents.status as content_status',
        //         'contents.created_at as content_created_at',
        //         'interaction_type.type as interaction_type'
        //     )
        //     ->orderBy('contents.created_at', 'desc')
        //     ->get();

        // $combinedData = $datas->merge($datass);
        // dd($combinedData);



        if ($request->ajax()) {
            return DataTables::of($datas)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-icon btn-sm btn-info-transparent rounded-pill me-2"
                                data-bs-toggle="modal" data-bs-target="#modalView-' . $row->content_id . '"
                                data-content-id="' . $row->content_id . '"
                                data-interaction-type="' . $row->interaction_type_id . '">
                                <i class="ri-eye-line fw-bold"></i>
                            </button>';
                })
                
                ->addColumn('status', function ($row) {
                    if ($row->content_status == 1) {

                        $button =
                            '<div class="d-flex justify-content-between">
                            <button class="btn btn-sm bg-success text-light me-1 fw-bold">
                                 Active
                            </button>
                        </div>';
                    } else {
                        $button =

                            '<div class="d-flex align-items-between">
                            <button class="btn btn-sm bg-danger text-light me-1 fw-bold">
                                  Inactive
                            </span>
                        </div>';
                    }
                    return $button;
                })
                ->addColumn('totalInteractions', function ($row) {
                    $status = $row->content_status == 1 ? 'Active' : 'Inactive';
                    $bg = $row->content_status == 1 ? 'badge bg-success text-light me-1 fw-bold mt-2' : 'badge bg-danger text-light me-1 fw-bold mt-2';
                    $button =
                        '<div class="">
                            <button class="btn btn-sm bg-success-transparent text-primary me-1 fw-bold">
                                 ' . $row->total_interactions . '
                            </button>
                            <br>
                             <span>status: <span class="' . $bg . '">' . $status . '</span></span>
                        </div>';

                    return $button;
                })
                ->addColumn('interaction_type', function ($row) {
                    $button =
                        '<div class="">
                    
                            <button class="btn btn-sm bg-success-transparent text-primary me-1 fw-bold">
                                 ' . strtoupper($row->interaction_type) . '
                            </button>
                            
                           
                        </div>';

                    return $button;
                })
                ->addColumn('name', function ($row) {

                    $button =
                        '<span class="fw-bold">' . strtoupper($row->name) . ' </span>';

                    return $button;
                })
                ->rawColumns(['action', 'status', 'totalInteractions', 'interaction_type', 'name'])
                ->make(true);
        }
        return view('organization.contentActivity.index', [
            'datas' => $datas,
        ]);
    }
    public function showContentUserEnrolledOrganization(Request $request)
    {
        $datas = DB::table('user_content as userContent')
            ->join('contents', 'userContent.content_id', '=', 'contents.id')
            ->where('contents.user_id', Auth::user()->id)
            ->join('users as contentOwner', 'contents.user_id', '=', 'contentOwner.id')
            ->join('users', 'userContent.user_id', '=', 'users.id') 
            ->join('content_types', 'contents.content_type_id', '=', 'content_types.id')
            ->join('interaction_type', 'userContent.interaction_type_id', '=', 'interaction_type.id')
            ->whereIn('userContent.interaction_type_id', [3])
            ->select(
                DB::raw('MAX(userContent.id) as id'),
                DB::raw('MAX(userContent.user_id) as user_id'),
                DB::raw('MAX(userContent.interaction_type_id) as interaction_type_id'),
                DB::raw('MAX(userContent.status) as status'),
                DB::raw('MAX(userContent.content_id) as content_id'),
                DB::raw('MAX(userContent.ip_address) as ip_address'),
                DB::raw('MAX(userContent.token) as token'),
                DB::raw('MAX(userContent.verification_code) as verification_code'),
                DB::raw('MAX(userContent.`desc`) as `desc`'),
                DB::raw('MAX(userContent.created_at) as user_content_created_at'),
                DB::raw('MAX(users.name) as user_name'), 
                DB::raw('MAX(users.email) as user_email'), 
                DB::raw('MAX(contentOwner.name) as content_owner_name'),
                DB::raw('MAX(contentOwner.email) as content_owner_email'), 
                DB::raw('MAX(contents.name) as name'),
                DB::raw('MAX(contents.link) as link'),
                DB::raw('MAX(contents.content) as content'),
                DB::raw('MAX(contents.enrollment_price) as enrollment_price'),
                DB::raw('MAX(contents.category_weight) as category_weight'),
                DB::raw('MAX(contents.content_type_id) as content_type_id'),
                DB::raw('MAX(contents.edit_from) as edit_from'),
                DB::raw('MAX(contents.place) as place'),
                DB::raw('MAX(contents.participant_limit) as participant_limit'),
                DB::raw('MAX(contents.state) as state'),
                DB::raw('MAX(contents.closed_at) as closed_at'),
                DB::raw('MAX(contents.reason_phrase) as reason_phrase'),
                DB::raw('MAX(contents.first_date) as first_date'),
                DB::raw('MAX(contents.org_id) as org_id'),
                DB::raw('MAX(contents.reject_reason) as reject_reason'),
                DB::raw('MAX(contents.image) as image'),
                DB::raw('MAX(contents.status) as content_status'),
                DB::raw('MAX(contents.created_at) as content_created_at'),
                DB::raw('MAX(interaction_type.type) as interaction_type'),
                DB::raw('MAX(content_types.type) as content_type'),
                DB::raw('COUNT(userContent.content_id) as total_interactions')
            )
            ->groupBy('userContent.content_id', 'userContent.interaction_type_id')
            ->orderBy('content_created_at', 'desc') 
            ->get();

        // $datass = DB::table('user_content as userContent')
        //     ->join('contents', 'userContent.content_id', '=', 'contents.id')
        //     ->join('users', 'userContent.user_id', '=', 'users.id')
        //     ->join('interaction_type', 'userContent.interaction_type_id', '=', 'interaction_type.id')
        //     ->select(
        //         'userContent.*',
        //         'users.name as user_name',
        //         'users.email as user_email',
        //         'contents.*',
        //         'contents.status as content_status',
        //         'contents.created_at as content_created_at',
        //         'interaction_type.type as interaction_type'
        //     )
        //     ->orderBy('contents.created_at', 'desc')
        //     ->get();

        // $combinedData = $datas->merge($datass);
        // dd($combinedData);



        if ($request->ajax()) {
            return DataTables::of($datas)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-icon btn-sm btn-info-transparent rounded-pill me-2"
                                data-bs-toggle="modal" data-bs-target="#modalView-' . $row->content_id . '"
                                data-content-id="' . $row->content_id . '"
                                data-interaction-type="' . $row->interaction_type_id . '">
                                <i class="ri-eye-line fw-bold"></i>
                            </button>';
                })
                
                ->addColumn('status', function ($row) {
                    if ($row->content_status == 1) {

                        $button =
                            '<div class="d-flex justify-content-between">
                            <button class="btn btn-sm bg-success text-light me-1 fw-bold">
                                 Active
                            </button>
                        </div>';
                    } else {
                        $button =

                            '<div class="d-flex align-items-between">
                            <button class="btn btn-sm bg-danger text-light me-1 fw-bold">
                                  Inactive
                            </span>
                        </div>';
                    }
                    return $button;
                })
                ->addColumn('totalInteractions', function ($row) {
                    $status = $row->content_status == 1 ? 'Active' : 'Inactive';
                    $bg = $row->content_status == 1 ? 'badge bg-success text-light me-1 fw-bold mt-2' : 'badge bg-danger text-light me-1 fw-bold mt-2';
                    $button =
                        '<div class="">
                            <button class="btn btn-sm bg-success-transparent text-primary me-1 fw-bold">
                                 ' . $row->total_interactions . '
                            </button>
                            <br>
                             <span>status: <span class="' . $bg . '">' . $status . '</span></span>
                        </div>';

                    return $button;
                })
                ->addColumn('interaction_type', function ($row) {
                    $button =
                        '<div class="">
                    
                            <button class="btn btn-sm bg-success-transparent text-primary me-1 fw-bold">
                                 ' . strtoupper($row->interaction_type) . '
                            </button>
                            
                           
                        </div>';

                    return $button;
                })
                ->addColumn('name', function ($row) {

                    $button =
                        '<span class="fw-bold">' . strtoupper($row->name) . ' </span>';

                    return $button;
                })
                ->rawColumns(['action', 'status', 'totalInteractions', 'interaction_type', 'name'])
                ->make(true);
        }
        return view('organization.contentActivity.indexEnrolled', [
            'datas' => $datas,
        ]);
    }

    public function getContentDetailOrganization($content_id, $interaction_type)
    {
        $contentDetail = DB::table('user_content as userContent')
            ->join('contents', 'userContent.content_id', '=', 'contents.id')
            ->where('contents.user_id', Auth::user()->id)
            ->join('users', 'userContent.user_id', '=', 'users.id')
            ->join('interaction_type', 'userContent.interaction_type_id', '=', 'interaction_type.id')
            ->select(
                'userContent.*',
                'userContent.created_at	 as content_user_created_at',
                'users.name as user_name',
                'users.email as user_email',
                'contents.*',
                'contents.status as content_status',
                'contents.created_at as content_created_at',
                'interaction_type.type as interaction_type'
            )
            ->where('userContent.content_id', $content_id)
            ->where('userContent.interaction_type_id', $interaction_type)
            ->get();
    
        return response()->json($contentDetail);
    }

    public function showTransactionHistoryPromoteContentOrg(Request $request)
    {
        $datas = DB::table('content_promotion as cp')
            ->join('transactions as t', 'cp.transaction_id', '=', 't.id')
            ->join('users', 't.user_id', '=', 'users.id')
            ->join('contents', 'cp.content_id', '=', 'contents.id')
            ->join('content_types', 'contents.content_type_id', '=', 'content_types.id')
            ->where('t.user_id', Auth::user()->id)
            ->where('t.status', 'Success')
            ->select(
                'users.name as user_name',
                'users.email as user_email',
                'users.telno as user_phone',
                't.*',
                'users.name as user_name',
                'users.email as user_email',
                't.status as transaction_status',
                'contents.name as content_name',
                'content_types.type as content_type',
                'cp.target_audience as target_audience',
                'cp.estimate_reach as estimate_reach'
            )
            ->where('t.sellerOrderNo', 'like', '%PromoteContent%')
            ->get();

        // dd($datas);
        if ($request->ajax()) {

            $table = DataTables::of($datas)->addIndexColumn();

            $table->addColumn('status', function ($row) {
                if ($row->transaction_status == 'Success') {
                    $button = '<span class="badge bg-success p-2 fw-bold">SUCCESS</span>';
                } elseif ($row->transaction_status == 'Pending') {
                    $button = '<span class="badge bg-warning p-2 fw-bold">PENDING</span>';
                } else {
                    $button = '<span class="badge bg-danger p-2 fw-bold">FAILED</span>';
                }
                return $button;
            });
            $table->addColumn('action', function ($row) {
                if ($row->transaction_status == 'Success') {
                    $button = '<button class="btn btn-sm btn-primary-transparent me-2"
                                data-bs-toggle="modal" data-bs-target="#modalReceipt-' . $row->id . '">
                                View Receipt
                            </button>';
                } else {
                    $button = '-';
                }

                return $button;
            });
            $table->rawColumns(['status', 'action']);
            return $table->make(true);
        }
        return view('organization.transaction.index', [
            'datas' => $datas
        ]);
    }
    public function showTransactionHistoryXbugCardOrg(Request $request)
    {
        $datas = DB::table('content_card as cc')
            ->join('transactions as t', 'cc.transaction_id', '=', 't.id')
            ->join('users', 't.user_id', '=', 'users.id')
            ->join('content_promotion as cp', 'cp.transaction_id', '=', 't.id')
            ->join('contents', 'cc.content_id', '=', 'contents.id')
            ->join('content_types', 'contents.content_type_id', '=', 'content_types.id')
            ->where('t.user_id', Auth::user()->id)
            ->where('t.status', 'Success')
            ->select(
                'users.name as user_name',
                'users.email as user_email',
                'users.telno as user_phone',
                't.*',
                'users.name as user_name',
                'users.email as user_email',
                't.status as transaction_status',
                'contents.name as content_name',
                'content_types.type as content_type',
                'cc.startdate as startdate',
                'cc.enddate as enddate',
                'cp.number_of_card as number_of_card',
            )
            ->where('t.sellerOrderNo', 'like', '%XBugStand%')
            ->get();

        // dd($datas);
        
        if ($request->ajax()) {

            $table = DataTables::of($datas)->addIndexColumn();

            $table->addColumn('status', function ($row) {
                if ($row->transaction_status == 'Success') {
                    $button = '<span class="badge bg-success p-2 fw-bold">SUCCESS</span>';
                } elseif ($row->transaction_status == 'Pending') {
                    $button = '<span class="badge bg-warning p-2 fw-bold">PENDING</span>';
                } else {
                    $button = '<span class="badge bg-danger p-2 fw-bold">FAILED</span>';
                }
                return $button;
            });
            $table->addColumn('action', function ($row) {
                if ($row->transaction_status == 'Success') {
                    $button = '<button class="btn btn-sm btn-primary-transparent me-2"
                                data-bs-toggle="modal" data-bs-target="#modalReceipt-' . $row->id . '">
                                View Receipt
                            </button>';
                } else {
                    $button = '-';
                }

                return $button;
            });
            $table->rawColumns(['status', 'action']);
            return $table->make(true);
        }
        return view('organization.transaction.indexXbugCard', [
            'datas' => $datas
        ]);
    }
    public function showTransactionHistoryXbugAiOrg(Request $request)
    {
        $datas = DB::table('transactions as t')
            ->join('users', 't.user_id', '=', 'users.id')
            ->select(
                'users.name as user_name',
                'users.email as user_email',
                'users.telno as user_phone',
                't.*',
                'users.name as user_name',
                'users.email as user_email',
                't.status as transaction_status',
            )
            ->where('t.user_id', Auth::user()->id)
            ->where('t.sellerOrderNo', 'like', '%XBugGpt%')
            ->get();

        // dd($datas);
        
        if ($request->ajax()) {

            $table = DataTables::of($datas)->addIndexColumn();

            $table->addColumn('status', function ($row) {
                if ($row->transaction_status == 'Success') {
                    $button = '<span class="badge bg-success p-2 fw-bold">SUCCESS</span>';
                } elseif ($row->transaction_status == 'Pending') {
                    $button = '<span class="badge bg-warning p-2 fw-bold">PENDING</span>';
                } else {
                    $button = '<span class="badge bg-danger p-2 fw-bold">FAILED</span>';
                }
                return $button;
            });
            $table->addColumn('action', function ($row) {
                if ($row->transaction_status == 'Success') {
                    $button = '<button class="btn btn-sm btn-primary-transparent me-2"
                                data-bs-toggle="modal" data-bs-target="#modalReceipt-' . $row->id . '">
                                View Receipt
                            </button>';
                } else {
                    $button = '-';
                }

                return $button;
            });
            $table->rawColumns(['status', 'action']);
            return $table->make(true);
        }
        return view('organization.transaction.indexXbugAi', [
            'datas' => $datas
        ]);
    }
}
