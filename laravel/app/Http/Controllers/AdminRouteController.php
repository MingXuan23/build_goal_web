<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;

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
            ->whereRaw('NOT (JSON_LENGTH(u.role) = 1 AND JSON_CONTAINS(u.role, JSON_ARRAY(5)))')  // Exclude [5] only
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
                } else {
                    $button = '<div class="d-flex justify-content-between">
                                    <span class="text-danger p-2 me-1 fw-bold">
                                        <i class="bi bi-circle-fill"></i> -
                                    </span>
                                </div>';
                }

                return $button;
            });

            $table->rawColumns(['action', 'email_status', 'active', 'ekyc_status', 'role_names', 'gpt_account', 'gpt_status']);

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

            $table->rawColumns(['action', 'email_status', 'active', 'role_names']);

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

        // Yearly Transactions
        $yearlyTransactions = DB::table('transactions')
        ->selectRaw('YEAR(created_at) as year, COUNT(*) as count, SUM(amount) as total_amount')
        ->where('status', 'SUCCESS')
        ->groupBy('year')
        ->pluck('total_amount', 'year');

        $yearlyTransactionCounts = DB::table('transactions')
            ->selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->where('status', 'SUCCESS')
            ->groupBy('year')
            ->pluck('count', 'year');

        // Monthly Transactions
        $monthlyTransactions = DB::table('transactions')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count, SUM(amount) as total_amount')
            ->whereYear('created_at', now()->year)
            ->where('status', 'SUCCESS')
            ->groupBy('month')
            ->pluck('total_amount', 'month');

        $monthlyTransactionCounts = DB::table('transactions')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->where('status', 'SUCCESS')
            ->groupBy('month')
            ->pluck('count', 'month');

        // Weekly Transactions
        $weeklyTransactions = DB::table('transactions')
            ->selectRaw('DAYNAME(created_at) as day, COUNT(*) as count, SUM(amount) as total_amount')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('status', 'SUCCESS')
            ->groupBy('day')
            ->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->pluck('total_amount', 'day');

        $weeklyTransactionCounts = DB::table('transactions')
            ->selectRaw('DAYNAME(created_at) as day, COUNT(*) as count')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('status', 'SUCCESS')
            ->groupBy('day')
            ->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->pluck('count', 'day');

        // Daily Transactions
        $dailyTransactions = DB::table('transactions')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(amount) as total_amount')
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->where('status', 'SUCCESS')
            ->groupBy('date')
            ->pluck('total_amount', 'date');

        $dailyTransactionCounts = DB::table('transactions')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->where('status', 'SUCCESS')
            ->groupBy('date')
            ->pluck('count', 'date');

        $totalYearlyAmount = $yearlyTransactions->sum();
        $totalMonthlyAmount = $monthlyTransactions->sum();
        $totalWeeklyAmount = $weeklyTransactions->sum();
        $totalDailyAmount = $dailyTransactions->sum();

        $totalYearlyTransactions = $yearlyTransactionCounts->sum();
        $totalMonthlyTransactions = $monthlyTransactionCounts->sum();
        $totalWeeklyTransactions = $weeklyTransactionCounts->sum();
        $totalDailyTransactions = $dailyTransactionCounts->sum();

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
            'weekData',
            'yearlyTransactions',
            'monthlyTransactions',
            'weeklyTransactions',
            'dailyTransactions',
            'totalYearlyAmount',
            'totalMonthlyAmount',
            'totalWeeklyAmount',
            'totalDailyAmount',
            'totalYearlyTransactions',
            'totalMonthlyTransactions',
            'totalWeeklyTransactions',
            'totalDailyTransactions'
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
                'is_gpt',
                'gpt_status',
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
            $states = DB::table('states')->select('id', 'name')->get();
        return view('admin.profile.index', [
            'datas' => $data,
            'states' => $states
        ]);
    }

    public function showContentAdmin(Request $request)
    {
        // $stateCitiesJson = file_get_contents(public_path('assets/json/states-cities.json'));
        // $stateCities = json_decode($stateCitiesJson, true);
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
            // 'stateCities' => $stateCities,
            'states' => $states
        ]);
    }

    public function showEmailLogs(Request $request)
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

    public function showPackage(Request $request)
    {
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

    public function showxBugStandAdmin(Request $request)
    {
        $datas = DB::table('contents as c')
            ->join('content_promotion as cp', 'c.id', '=', 'cp.content_id')
            ->join('transactions as t', 't.id', '=', 'cp.transaction_id')
            ->where('t.status', "Success")
            ->where('c.status', 1)
            ->where('cp.status', 1)
            ->select(
                'c.id',
                'c.name',
                't.created_at',
                't.amount',
                't.id as transaction_id',
                'cp.number_of_card',
                'cp.status as promotion_status',
                // DB::raw('(SELECT COUNT(*) FROM content_card WHERE content_id = c.id) as total_cards'),
                DB::raw('(SELECT COUNT(*) FROM content_card WHERE content_id = c.id AND status = 1 AND verification_code IS NOT NULL) as assigned_cards')
            )
            ->orderBy('t.created_at', 'desc');

        if ($request->ajax()) {
            return DataTables::of($datas)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-info btn-sm view-cards" data-content-id="' . $row->id . '">View Cards</button>';
                })
                ->addColumn('receipt', function ($row) {
                    return route('xbug-stand.receipt', $row->transaction_id);
                })
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('Y-m-d H:i:s');
                })
                ->editColumn('number_of_card', function ($row) {
                    return $row->assigned_cards  . '/' . $row->number_of_card;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.contentManagement.xbug_stand', ['content_data' => $datas->get()]);
    }

    public function getContentCards($contentId)
    {
        $cards = DB::table('content_card')
            ->where('content_id', $contentId)
            ->where('status', 1)
            ->orderBy('created_at')
            ->get();

        return response()->json(['cards' => $cards]);
    }

    public function saveContentCards(Request $request)
    {

        $contentId = $request->input('content_id');


        $cards = $request->input('cards');

        if (empty($cards) || count($cards) == 0) {
            return response()->json(['error' => "Require at least 1 card"], 400); // Send error message with 400 status
        }

        // Retrieve all card IDs for the current content
        $existingCardIds = DB::table('content_card')->where('content_id', $contentId)->where('status', 1)->pluck('id')->toArray();
        $firstTransactionId = DB::table('content_card')
            ->where('content_id', $contentId)
            ->where('status', 1)
            ->whereNotNull('transaction_id')
            ->first()->transaction_id;

        // Track the IDs of cards that are included in the request
        $updatedCardIds = [];

        foreach ($cards as $card) {
            $updatedCardIds[] = $card['id'] ?? null; // Track card IDs from the request
            $existCardId = DB::table('content_card')->where('card_id', $card['card_id'])->where('id', '<>', $card['id'])->where('status', 1)->exists();
            $existCode = DB::table('content_card')->where('verification_code', $card['verification_code'])->where('id', '<>', $card['id'])->where('status', 1)->exists();

            if ($existCardId && $card['card_id'] != null) {
                return response()->json(['error' => "The card ID {$card['card_id']} already exists."], 400); // Send error message with 400 status
            } else if ($existCode && $card['card_id'] != null) {
                return response()->json(['error' => "The verification code {$card['verification_code']} already exists."], 400);
            }

            if (isset($card['id']) && $card['id']) {
                // Update existing card
                DB::table('content_card')->where('id', $card['id'])->update([
                    'startdate' => $card['start_date'] . ' ' . $card['start_time'],
                    'enddate' => $card['end_date'] . ' ' . $card['end_time'],
                    'verification_code' => $card['verification_code'],
                    'card_id' => $card['card_id'],
                    'tracking_id' =>$card['tracking_id']
                ]);
            } else {
                // Create new card
                DB::table('content_card')->insert([
                    'content_id' => $contentId,
                    'startdate' => $card['start_date'] . ' ' . $card['start_time'],
                    'enddate' => $card['end_date'] . ' ' . $card['end_time'],
                    'verification_code' => $card['verification_code'],
                    'card_id' => $card['card_id'],
                    'transaction_id' => $firstTransactionId,
                    'tracking_id' =>$card['tracking_id']

                ]);
            }
        }

        // Now handle the cards that were deleted (not in the updated request)
        $deletedCardIds = array_diff($existingCardIds, $updatedCardIds);

        // Mark deleted cards as null (status set to null)
        DB::table('content_card')->whereIn('id', $deletedCardIds)->update([
            'status' => 0
        ]);

        return response()->json(['message' => 'Cards saved successfully.']);
    }

    public function showContentUserClickedViewed(Request $request)
    {

        // $dataContentActive = DB::table('content_promotion')
        //     ->leftJoin('user_content', 'content_promotion.content_id', '=', 'user_content.content_id')
        //     ->join('transactions', 'content_promotion.transaction_id', '=', 'transactions.id')
        //     ->join('users', 'transactions.user_id', '=', 'users.id')
        //     ->join('contents', 'content_promotion.content_id', '=', 'contents.id')
        //     ->join('content_types', 'contents.content_type_id', '=', 'content_types.id')
        //     ->join('users as contentOwner', 'contents.user_id', '=', 'contentOwner.id')
        //     // ->join('interaction_type', 'user_content.interaction_type_id', '=', 'interaction_type.id')
        //     ->where('transactions.status', "Success")
        //     // ->where('transactions.sellerOrderNo', 'like', '%PromoteContent%')
        //     ->whereNotNull('content_promotion.views')
        //     ->whereNotNull('content_promotion.clicks')
        //     // ->whereIn('user_content.interaction_type_id', [1, 2])
        //     ->select('contents.name as content_name', 'content_types.type as content_type_name', 'users.name as user_name', 'transactions.updated_at as transaction_updated_at')->get();

        $dataContentActive = DB::table('content_promotion')
            ->leftJoin('user_content', 'content_promotion.content_id', '=', 'user_content.content_id')
            ->join('transactions', 'content_promotion.transaction_id', '=', 'transactions.id')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->join('contents', 'content_promotion.content_id', '=', 'contents.id')
            ->join('content_types', 'contents.content_type_id', '=', 'content_types.id')
            ->join('users as contentOwner', 'contents.user_id', '=', 'contentOwner.id')
            ->where('transactions.status', "Success")
            ->whereNotNull('content_promotion.views')
            ->whereNotNull('content_promotion.clicks')
            ->select(
                'contents.id as content_id',
                'contents.name as content_name',
                'content_types.type as content_type_name',
                'users.name as user_name',
                DB::raw('MAX(transactions.updated_at) as transaction_updated_at'), // Ambil data terakhir untuk transaksi
                DB::raw('COUNT(content_promotion.id) as total_promotions') // Contoh agregasi (opsional)
            )
            ->groupBy('contents.id', 'contents.name', 'content_types.type', 'users.name') // Grouping berdasarkan content.id dan kolom lainnya
            ->get();


        // dd($dataContentActive);

        $datas = DB::table('user_content as userContent')
            // ->join('contents', 'userContent.content_id', '=', 'contents.id')
            // ->join('users as contentOwner', 'contents.user_id', '=', 'contentOwner.id')
            // ->join('users', 'userContent.user_id', '=', 'users.id')
            // ->join('content_types', 'contents.content_type_id', '=', 'content_types.id')
            // ->join('interaction_type', 'userContent.interaction_type_id', '=', 'interaction_type.id')
            // ->whereIn('userContent.interaction_type_id', [1, 2])
            ->join('contents', 'userContent.content_id', '=', 'contents.id')
            ->join('users as contentOwner', 'contents.user_id', '=', 'contentOwner.id')
            ->join('users', 'userContent.user_id', '=', 'users.id')
            ->join('content_types', 'contents.content_type_id', '=', 'content_types.id')
            ->join('interaction_type', 'userContent.interaction_type_id', '=', 'interaction_type.id')
            ->join('content_promotion as cp', 'contents.id', '=', 'cp.content_id')
            ->join('transactions', 'cp.transaction_id', '=', 'transactions.id')
            ->whereIn('userContent.interaction_type_id', [1, 2])
            ->whereNotNull('cp.views')
            ->whereNotNull('cp.clicks')
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
        return view('admin.contentUser.index', [
            'datas' => $datas,
            'dataContentActive' => $dataContentActive
        ]);
    }
    public function showContentUserEnrolled(Request $request)
    {

        // $dataContentActive = DB::table('content_promotion')
        //     ->leftJoin('user_content', 'content_promotion.content_id', '=', 'user_content.content_id')
        //     ->join('transactions', 'content_promotion.transaction_id', '=', 'transactions.id')
        //     ->join('users', 'transactions.user_id', '=', 'users.id')
        //     ->join('contents', 'content_promotion.content_id', '=', 'contents.id')
        //     ->join('content_types', 'contents.content_type_id', '=', 'content_types.id')
        //     ->join('users as contentOwner', 'contents.user_id', '=', 'contentOwner.id')
        //     // ->join('interaction_type', 'user_content.interaction_type_id', '=', 'interaction_type.id')
        //     ->where('transactions.status', "Success")
        //     // ->where('transactions.sellerOrderNo', 'like', '%XBugStand%')
        //     ->whereNotNull('content_promotion.enrollment')
        //     // ->whereIn('user_content.interaction_type_id', [1, 2])
        //     ->select('contents.name as content_name', 'content_types.type as content_type_name', 'users.name as user_name', 'transactions.updated_at as transaction_updated_at')->get();

        $dataContentActive = DB::table('content_promotion')
            ->leftJoin('user_content', 'content_promotion.content_id', '=', 'user_content.content_id')
            ->join('transactions', 'content_promotion.transaction_id', '=', 'transactions.id')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->join('contents', 'content_promotion.content_id', '=', 'contents.id')
            ->join('content_types', 'contents.content_type_id', '=', 'content_types.id')
            ->join('users as contentOwner', 'contents.user_id', '=', 'contentOwner.id')
            ->where('transactions.status', "Success")
            ->whereNotNull('content_promotion.enrollment')
            ->select(
                'contents.id as content_id', // Tambahkan content_id
                'contents.name as content_name',
                'content_types.type as content_type_name',
                'users.name as user_name',
                DB::raw('MAX(transactions.updated_at) as transaction_updated_at'), // Tanggal terakhir transaksi
                DB::raw('COUNT(content_promotion.id) as total_promotions') // Total promosi
            )
            ->groupBy('contents.id', 'contents.name', 'content_types.type', 'users.name') // Group berdasarkan content_id
            ->get();

        // dd($dataContentActive);

        $datas = DB::table('user_content as userContent')
            ->join('contents', 'userContent.content_id', '=', 'contents.id')
            ->join('users as contentOwner', 'contents.user_id', '=', 'contentOwner.id')
            ->join('users', 'userContent.user_id', '=', 'users.id')
            ->join('content_types', 'contents.content_type_id', '=', 'content_types.id')
            ->join('interaction_type', 'userContent.interaction_type_id', '=', 'interaction_type.id')
            ->join('content_promotion as cp', 'contents.id', '=', 'cp.content_id')
            ->join('transactions', 'cp.transaction_id', '=', 'transactions.id')
            ->whereIn('userContent.interaction_type_id', [3])
            ->whereNotNull('cp.enrollment')
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
// dd($datas);


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
        return view('admin.contentUser.indexEnrolled', [
            'datas' => $datas,
            'dataContentActive' => $dataContentActive
        ]);
    }

    public function getContentDetail($content_id, $interaction_type)
    {
        // Ambil data berdasarkan content_id dan interaction_type
        $contentDetail = DB::table('user_content as userContent')
            ->join('contents', 'userContent.content_id', '=', 'contents.id')
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

        // Kembalikan data sebagai response JSON atau dalam format lain
        return response()->json($contentDetail);
    }

    public function emailStatus(Request $request)
    {
        $data = DB::table('email_status')->get();
        if ($request->ajax()) {
            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('active', function ($row) {
                $messageActive = ($row->status === 1 ? 'ACTIVE' : 'INACTIVE');
                $statusClass = ($row->status === 1) ? 'success' : 'danger';
                $button = '
                        <div class="d-flex justify-content-start">
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
            $table->addColumn('email_name', function ($row) {
                $button = '<span class="btn btn-sm btn-success-transparent p-2">' . $row->email . '</span>';
                return $button;
            });

            $table->rawColumns(['active', 'email_name']);

            return $table->make(true);
        }

        return view('admin.setting.emailStatus', [
            'datas' => $data
        ]);
    }
    public function emailStatusUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'status' => 'required|in:1,0',
            ]);
            $update = DB::table('email_status')
                ->where('id', $id)
                ->update(['status' => (int)$request->status]);
            DB::commit();

            return redirect()->route('emailStatus')->with('success', 'Email Status Updated Successfully!');
        } catch (Exception $th) {
            DB::rollBack();
            return redirect()->route('emailStatus')->with('error', 'Failed to update Email Status!');
        }
    }

    public function showTransactionHistoryPromoteContent(Request $request)
    {
        $datas = DB::table('content_promotion as cp')
            ->join('transactions as t', 'cp.transaction_id', '=', 't.id')
            ->join('users', 't.user_id', '=', 'users.id')
            ->join('contents', 'cp.content_id', '=', 'contents.id')
            ->join('content_types', 'contents.content_type_id', '=', 'content_types.id')
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
        return view('admin.transaction.index', [
            'datas' => $datas
        ]);
    }
    public function showTransactionHistoryXbugCard(Request $request)
    {
        $datas = DB::table('content_card as cc')
            ->join('transactions as t', 'cc.transaction_id', '=', 't.id')
            ->join('users', 't.user_id', '=', 'users.id')
            ->join('content_promotion as cp', 'cp.transaction_id', '=', 't.id')
            ->join('contents', 'cc.content_id', '=', 'contents.id')
            ->join('content_types', 'contents.content_type_id', '=', 'content_types.id')
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
        return view('admin.transaction.indexXbugCard', [
            'datas' => $datas
        ]);
    }
    public function showTransactionHistoryXbugAi(Request $request)
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
        return view('admin.transaction.indexXbugAi', [
            'datas' => $datas
        ]);
    }
}
