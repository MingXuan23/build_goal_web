<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


class AdminRouteController extends Controller
{
    //
    public function showUser(Request $request)
    {
        $data = DB::table('users as u')
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
        ->whereRaw('NOT (JSON_LENGTH(u.role) = 1 AND JSON_CONTAINS(u.role, JSON_ARRAY(4)))')  // Exclude [5] only
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
            'u.updated_at',
            'u.email_status',
            'u.verification_code',
            'u.icNo',
            'u.remember_token',
            'u.ekyc_status',
            'u.ekyc_time',
            'u.ekyc_signature',
            'u.is_gpt',
            'u.gpt_status',
            'o.name',
            'o.desc',
            'o.status',
            'o.logo',
            'o.address',
            'o.state',
            'o.org_type'
        )
        ->orderBy('u.created_at', 'asc')
        ->get();
    

        if ($request->ajax()) {
            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('action', function ($row) {
                $button = '<div class="d-flex justify-content-end"><button class="btn btn-icon btn-sm btn-info-transparent rounded-pill me-2"
                                        data-bs-toggle="modal" data-bs-target="#modalView-' . $row->id . '">
                                        <i class="ri-eye-line fw-bold"></i>
                                    </button>
                                    <button class="btn btn-icon btn-sm btn-warning-transparent rounded-pill"
                                        data-bs-toggle="modal" data-bs-target="#modalUpdate-' . $row->id . '">
                                        <i class="ri-edit-line fw-bold"></i>
                                    </button>
                                    </div>
                                    ';
                return $button;
            });

            $table->addColumn('email_status', function ($row) {
                $statusClass = ($row->email_status !== 'NOT VERIFY') ? 'success' : 'danger';
                $button = '<div class="d-flex justify-content-between">
                                <span class=" text-' . $statusClass . ' p-2 me-1 fw-bold">
                                    <i class="bi bi-circle-fill"></i> ' . $row->email_status . '
                                </span>
                                <button class="btn btn-icon btn-sm btn-warning-transparent rounded-pill " data-bs-toggle="modal" data-bs-target="#modalEmailStatus-' . $row->id . '">
                                    <i class="ri-edit-line fw-bold"></i>
                                </button>
                            </div>
                                    ';
                return $button;
            });
            $table->addColumn('active', function ($row) {
                $messageActive = ($row->active === 1 ? 'ACTIVE' : 'DISABLE');
                $statusClass = ($row->active === 1) ? 'success' : 'danger';
                $button = '
                            <div class="d-flex justify-content-between">
                            <span class=" text-' . $statusClass . ' p-2 me-1 fw-bold">
                                <i class="bi bi-circle-fill"></i> ' . $messageActive . '
                            </span>
                            <button class="btn btn-icon btn-sm btn-warning-transparent rounded-pill " data-bs-toggle="modal" data-bs-target="#modalActive-' . $row->id . '">
                                <i class="ri-edit-line fw-bold"></i>
                            </button>
                        </div>
                                    ';
                return $button;
            });

            $table->addColumn('ekyc_status', function ($row) {
                $messageActive = ($row->ekyc_status === 1 ? 'VERIFY' : 'NOT VERIFY');
                $statusClass = ($row->ekyc_status === 1) ? 'success' : 'danger';
                $button = '
                
                <div class="d-flex justify-content-between">
                            <span class=" text-' . $statusClass . ' p-2 me-1 fw-bold">
                                <i class="bi bi-circle-fill"></i> ' . $messageActive . '
                            </span>
                            <button class="btn btn-icon btn-sm btn-warning-transparent rounded-pill " data-bs-toggle="modal" data-bs-target="#modalEkyc-' . $row->id . '">
                                <i class="ri-edit-line fw-bold"></i>
                            </button>
                        </div>
                

                                    ';
                return $button;
            });
            $table->addColumn('role_names', function ($row) {
                $button = '

                <div class="d-flex justify-content-between"><span class="badge bg-info-transparent p-2 me-1 fw-bold">' .
                    Str::upper($row->role_names) . '</span><button class="btn btn-icon btn-sm btn-warning-transparent rounded-pill "
                        data-bs-toggle="modal" data-bs-target="#modalRoleNames-' . $row->id . '">
                        <i class="ri-edit-line fw-bold"></i>
                    </button>
                </div> 
                        
                                    ';
                return $button;
            });

            $table->addColumn('gpt_account', function ($row) {
                $messageActive = ($row->is_gpt === 1 ? 'YES' : 'NO');
                $statusClass = ($row->is_gpt === 1) ? 'success' : 'danger';
                $button = '
                            <div class="d-flex justify-content-between">
                            <span class=" text-' . $statusClass . ' p-2 me-1 fw-bold">
                                <i class="bi bi-circle-fill"></i> ' . $messageActive . '
                            </span>
                            <button class="btn btn-icon btn-sm btn-warning-transparent rounded-pill " data-bs-toggle="modal" data-bs-target="#modalGptAccount-' . $row->id . '">
                                <i class="ri-edit-line fw-bold"></i>
                            </button>
                        </div>
                                    ';
                return $button;
            });

            $table->addColumn('gpt_status', function ($row) {
                $messageActive = ($row->gpt_status === 1 ? 'ACTIVE' : 'BLOCK');
                $statusClass = ($row->gpt_status === 1) ? 'success' : 'danger';
                $button = '';

                if ($row->is_gpt === 1) {
                    $button = '<div class="d-flex justify-content-between">
                                    <span class="text-' . $statusClass . ' p-2 me-1 fw-bold">
                                        <i class="bi bi-circle-fill"></i> ' . $messageActive . '
                                    </span>
                                    <button class="btn btn-icon btn-sm btn-warning-transparent rounded-pill" data-bs-toggle="modal" data-bs-target="#modalGptStatus-' . $row->id . '">
                                        <i class="ri-edit-line fw-bold"></i>
                                    </button>
                                </div>';
                }
                else{
                    $button = '<div class="d-flex justify-content-between">
                                    <span class="text-danger p-2 me-1 fw-bold">
                                        <i class="bi bi-circle-fill"></i> -
                                    </span>
                                </div>';
                    }
                
                return $button;
            });

            $table->rawColumns(['action', 'email_status', 'active', 'ekyc_status', 'role_names','gpt_account','gpt_status']);

            return $table->make(true);
        }

        $role = DB::table('roles')->get();
        $state = DB::table('states')->select('id', 'name')->get();

        return view('admin.userManagement.index', [
            'roles' => $role,
            'datas' => $data,
            'states' => $state
        ]);
    }
    public function showUserMobile(Request $request)
    {
        $data = DB::table('users')
        ->whereRaw('JSON_LENGTH(role) = 1 AND JSON_CONTAINS(role, JSON_ARRAY(5))')  // Ensure role is [5] only
        ->orderBy('created_at', 'asc')
        ->get();

        if ($request->ajax()) {
            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('action', function ($row) {
                $button = '<div class="d-flex justify-content-end"><button class="btn btn-icon btn-sm btn-info-transparent rounded-pill me-2"
                                        data-bs-toggle="modal" data-bs-target="#modalView-' . $row->id . '">
                                        <i class="ri-eye-line fw-bold"></i>
                                    </button>
                                    <button class="btn btn-icon btn-sm btn-warning-transparent rounded-pill"
                                        data-bs-toggle="modal" data-bs-target="#modalUpdate-' . $row->id . '">
                                        <i class="ri-edit-line fw-bold"></i>
                                    </button>
                                    </div>
                                    ';
                return $button;
            });

            $table->addColumn('email_status', function ($row) {
                $statusClass = ($row->email_status !== 'NOT VERIFY') ? 'success' : 'danger';
                $button = '<div class="d-flex justify-content-between">
                                <span class=" text-' . $statusClass . ' p-2 me-1 fw-bold">
                                    <i class="bi bi-circle-fill"></i> ' . $row->email_status . '
                                </span>
                                <button class="btn btn-icon btn-sm btn-warning-transparent rounded-pill " data-bs-toggle="modal" data-bs-target="#modalEmailStatus-' . $row->id . '">
                                    <i class="ri-edit-line fw-bold"></i>
                                </button>
                            </div>
                                    ';
                return $button;
            });
            $table->addColumn('active', function ($row) {
                $messageActive = ($row->active === 1 ? 'ACTIVE' : 'DISABLE');
                $statusClass = ($row->active === 1) ? 'success' : 'danger';
                $button = '
                            <div class="d-flex justify-content-between">
                            <span class=" text-' . $statusClass . ' p-2 me-1 fw-bold">
                                <i class="bi bi-circle-fill"></i> ' . $messageActive . '
                            </span>
                            <button class="btn btn-icon btn-sm btn-warning-transparent rounded-pill " data-bs-toggle="modal" data-bs-target="#modalActive-' . $row->id . '">
                                <i class="ri-edit-line fw-bold"></i>
                            </button>
                        </div>
                                    ';
                return $button;
            });
            $table->addColumn('role_names', function ($row) {
                $button = '

                <div class="d-flex justify-content-between"><span class="badge bg-info-transparent p-2 me-1 fw-bold">Mobile User</span>
                </div> 
                        
                                    ';
                return $button;
            });

            $table->rawColumns(['action', 'email_status', 'active','role_names']);

            return $table->make(true);
        }
        $role = DB::table('roles')->get();
        $state = DB::table('states')->select('id', 'name')->get();

        return view('admin.userManagement.mobile', [
            'roles' => $role,
            'datas' => $data,
            'states' => $state
        ]);
    }

    public function showAddUser(Request $request)
    {

        return view('admin.userManagement.addUser');
    }
    public function showDashboard(Request $request)
    {
        //Total Users and Active Users
        $totalUsers = DB::table('users')->count();
        $activeUsers = DB::table('users')->where('active', 1)->count();

        //Registration Statistic
        $yearData = DB::table('users')
        ->select(DB::raw('YEAR(created_at) as year'), DB::raw('COUNT(*) as count'))
        ->groupBy('year')
        ->orderBy('year', 'asc')
        ->pluck('count', 'year');

        $monthData = DB::table('users')
        ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
        ->whereYear('created_at', now()->year)
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->pluck('count', 'month');

        $weekData = DB::table('users')
        ->select(DB::raw('DAYNAME(created_at) as day'), DB::raw('COUNT(*) as count'))
        ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
        ->groupBy('day')
        ->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
        ->pluck('count', 'day');

        //EKYC Status
        $ekycVerified = DB::table('users')->where('eKYC_status', 1)->count();
        $ekycNotVerified = DB::table('users')->where('eKYC_status', 0)->count();
    
        //Verified Email
        $emailVerified = DB::table('users')->where('email_status', 'VERIFY')->count();

        //Total Users Based on roles
        $userCounts = DB::table('users as u')
        ->join('roles as r', function ($join) {
            $join->whereRaw('JSON_CONTAINS(u.role, JSON_ARRAY(r.id))');
        })
        ->select(
            'r.role as role_name', // Get the role name
            DB::raw('COUNT(u.id) as user_count') // Count users per role
        )
        ->groupBy('r.role') // Group by role name
        ->orderBy('role_name', 'asc') // Optional: Order alphabetically
        ->get();

        //Content Summary
        $contentCounts = DB::table('contents')
        ->select('reason_phrase', DB::raw('COUNT(*) as count'))
        ->groupBy('reason_phrase')
        ->get();
        $totalContents = DB::table('contents')->count();
        $approvedCount = $contentCounts->where('reason_phrase', 'APPROVED')->first()->count ?? 0;
        $rejectedCount = $contentCounts->where('reason_phrase', 'REJECTED')->first()->count ?? 0;
        $pendingCount = $contentCounts->where('reason_phrase', 'PENDING')->first()->count ?? 0;

        return view('admin.dashboard.index', compact(
        'userCounts',
        'totalContents', 
        'approvedCount', 
        'rejectedCount', 
        'pendingCount',
        'ekycVerified', 
        'ekycNotVerified',
        'emailVerified',
        'activeUsers',
        'totalUsers',
        'yearData',
        'monthData',
        'weekData'
    ));
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
            'u.ekyc_signature',
            'u.ekyc_time',
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
        return view('admin.profile.index',[
            'datas' => $data
        ]);
    }

    public function showContentAdmin(Request $request)
    {
        $stateCitiesJson = file_get_contents(public_path('assets/json/states-cities.json'));
        $stateCities = json_decode($stateCitiesJson, true);
        $datas = DB::table('contents as contents')
            ->join('content_types', 'contents.content_type_id', '=', 'content_types.id')
            ->join('organization_user', 'contents.user_id', '=', 'organization_user.user_id')
            ->join('organization', 'organization_user.organization_id', '=', 'organization.id')
            ->select(
                'contents.id',
                'contents.name',
                'contents.desc',
                'contents.created_at',
                'contents.link',
                'contents.status',
                'contents.user_id',
                'contents.enrollment_price',
                'contents.place',
                'contents.state',
                'contents.reason_phrase',
                'contents.reject_reason',
                'contents.participant_limit',
                'content_types.type as content_type_name',
                'organization.name as organization_name'  // This is the organization name we will display
            )
            ->orderBy('contents.created_at', 'desc')
            ->get();

        if ($request->ajax()) {
            return DataTables::of($datas)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-primary-transparent" data-bs-toggle="modal" data-bs-target="#modalView-' . $row->id . '">View Details</button>';
                })
                ->addColumn('approve', function ($row) {
                    if ($row->reason_phrase == 'APPROVED') {

                        $button =
                            '<div class="d-flex justify-content-between">
                            <span class=" text-success p-2 me-1 fw-bold">
                                 <i class="bi bi-circle-fill"></i> APPROVED
                            </span>
                        </div>';
                    } elseif ($row->reason_phrase == 'REJECTED') {
                        $button =

                            '<div class="d-flex align-items-center">
                            <span class=" text-danger p-2 me-1 fw-bold">
                                 <i class="bi bi-circle-fill"></i> REJECTED
                            </span>
                             <button class="ms-1 btn btn-icon btn-sm btn-danger-transparent rounded-pill me-2"
                                        data-bs-toggle="modal" data-bs-target="#viewRejectModal-' . $row->id . '">
                                         <i class="ri-eye-line fw-bold"></i>
                                </button>
                        </div>';
                    } else {
                        $button =

                            '<div class="d-flex align-items-center">
                                 <span class=" text-warning p-2 me-1 fw-bold">
                                 <i class="bi bi-circle-fill"></i> PENDING
                            </span>
                                <button class="ms-1 btn btn-icon btn-sm btn-warning-transparent rounded-pill me-2"
                                        data-bs-toggle="modal" data-bs-target="#approveRejectModal-' . $row->id . '">
                                         <i class="ri-edit-line fw-bold"></i>
                                </button>
                                </div>';
                    }
                    return $button;
                })
                ->addColumn('user_id', function ($row) {
                    return $row->organization_name;  // Use organization_name instead of user_id
                })
                ->rawColumns(['action', 'approve'])
                ->make(true);
        }
        $states = DB::table('states')->select('id', 'name')->get();
        return view('admin.contentManagement.index', [
            'content_data' => $datas,
            'stateCities' => $stateCities,
            'states' => $states
        ]);
    }

    public function showEmailLogs(Request $request){
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
        ->whereNotIn('email_type', ['NOTIFICATION USER', 'NOTIFICATION TO ALL USERS']) // Mengecualikan 'NOTIFICATION USER' dan 'NOTIFICATION TO ALL USERS'
        ->orderBy('id', 'desc') // Mengurutkan berdasarkan id secara menurun
        ->get();
    
        if ($request->ajax()) {

            return DataTables::of($logs)
                ->addIndexColumn()
                ->editColumn('status', function ($log) {
                    $statusClass = $log->status === 'SUCCESS' ? 'success' : 'danger';
                    return '<span class="badge bg-' . $statusClass . ' p-2">' . $log->status . '</span>';
                })
                // ->editColumn('created_at', function ($log) {
                //     return date('d-m-Y H:i:s', strtotime($log->created_at));
                // })
                ->rawColumns(['status'])
                ->make(true);
        }

        return view('admin.emailLogs.index');
    }

    public function showPackage(Request $request){

        $data = DB::table('package')
        ->orderby('id', 'asc')
        ->get();

    if ($request->ajax()) {
        $table = DataTables::of($data)->addIndexColumn();

        $table->addColumn('action', function ($row) {
            $button = '<div class="d-flex justify-content-end"><button class="btn btn-icon btn-sm btn-info-transparent rounded-pill me-2"
                                    data-bs-toggle="modal" data-bs-target="#modalView-' . $row->id . '">
                                    <i class="ri-eye-line fw-bold"></i>
                                </button>
                                <button class="btn btn-icon btn-sm btn-warning-transparent rounded-pill"
                                    data-bs-toggle="modal" data-bs-target="#modalUpdate-' . $row->id . '">
                                    <i class="ri-edit-line fw-bold"></i>
                                </button>
                                </div>
                                ';
            return $button;
        });

  
        $table->addColumn('active', function ($row) {
            $messageActive = ($row->status === 1 ? 'ACTIVE' : 'DISABLE');
            $statusClass = ($row->status === 1) ? 'success' : 'danger';
            $button = '
                        <div class="d-flex justify-content-between">
                        <span class=" text-' . $statusClass . ' p-2 me-1 fw-bold">
                            <i class="bi bi-circle-fill"></i> ' . $messageActive . '
                        </span>
                        <button class="btn btn-icon btn-sm btn-warning-transparent rounded-pill " data-bs-toggle="modal" data-bs-target="#modalActive-' . $row->id . '">
                            <i class="ri-edit-line fw-bold"></i>
                        </button>
                    </div>
                                ';
            return $button;
         });


        $table->rawColumns(['action', 'active',]);

        return $table->make(true);
    }
    $role = DB::table('roles')->get();
    $state = DB::table('states')->select('id', 'name')->get();
        return view('admin.setting.view-package', [
            'datas' => $data,
        ]);
    }


    
}
