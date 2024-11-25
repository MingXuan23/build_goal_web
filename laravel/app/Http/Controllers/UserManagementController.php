<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UserManagementController extends Controller
{
    //

    public function index(Request $request)
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

            $table->rawColumns(['action', 'email_status', 'active', 'ekyc_status', 'role_names']);

            return $table->make(true);
        }
        $role = DB::table('roles')->get();

        return view('admin.userManagement.index', [
            'roles' => $role,
            'datas' => $data
        ]);
    }

    public function viewAddUser(Request $request)
    {

        return view('admin.userManagement.addUser');
    }

    public function updateUser(Request $request, $id)
    {

        $validatedData = $request->validate([
            'icno' => 'required|digits:12|unique:users',
            'fullname' => 'required',
            'email' => 'required|email|unique:organization',
            'phoneno' => 'required',
            'password' => 'required|min:5',
            'cpassword' => 'required|min:5|same:password',
            'oname' => 'required',
            'oaddress' => 'required',
            'ostate' => [
                'required',
                Rule::in([
                    'pahang',
                    'perak',
                    'terengganu',
                    'perlis',
                    'selangor',
                    'negeri_sembilan',
                    'johor',
                    'kelantan',
                    'kedah',
                    'pulau_pinang',
                    'melaka',
                    'sabah',
                    'sarawak'
                ]),
            ],
            'otype' => 'required|exists:organization_type,id',
        ], [
            'otype.in' => 'The selected organization type is invalid. Please choose a valid organization type.',
            'ostate.in' => 'The selected state is invalid. Please choose a valid state.',
        ], [
            'icno' => 'IC Number',
            'fullname' => 'Full Name',
            'oemail' => 'Email',
            'phoneno' => 'Phone Number',
            'password' => 'Password',
            'cpassword' => 'Confirm Passowrd',
            'oname' => 'Organization Name',
            'oaddress' => 'Organization Address',
            'ostate' => 'Organization state',
            'otype' => 'Organization Type',
        ]);
        $data = DB::table('users')->where('id', $id)->update([
            'name' => $request->name
        ]);
        return back();
    }

    public function updateRole(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'roles' => 'required|array',
                'roles.*' => 'integer|exists:roles,id',
            ]);

            $roles = array_map('intval', $request->roles);

            $roleJson = json_encode($roles);

            $update = DB::table('users')
                ->where('id', $id)
                ->update(['role' => $roleJson]);
            DB::commit();

            return redirect()->route('viewUser')->with('success', 'Roles updated successfully!');
        } catch (Exception $th) {
            DB::rollBack();
            return redirect()->route('viewUser')->with('error', 'Failed to update roles!');
        }
    }


    public function updateEkycStatus(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'status' => 'required|in:1,0',
            ]);
            $update = DB::table('users')
                ->where('id', $id)
                ->update(['ekyc_status' => (int)$request->status]);
            DB::commit();

            return redirect()->route('viewUser')->with('success', 'e-kyc Status updated successfully!');
        } catch (Exception $th) {
            DB::rollBack();
            return redirect()->route('viewUser')->with('error', 'Failed to update e-kyc Status!');
        }
    }

    public function updateEmailStatus(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'status' => 'required|in:1,0',
            ]);
            $status = ($request->status == "0") ? "NOT VERIFY" : "VERIFY";
            $update = DB::table('users')
                ->where('id', $id)
                ->update(['email_status' => $status]);
            DB::commit();

            return redirect()->route('viewUser')->with('success', 'Email Status updated successfully!');
        } catch (Exception $th) {
            DB::rollBack();
            return redirect()->route('viewUser')->with('error', 'Failed to update Email Status!');
        }
    }

    public function updateAccountStatus(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'status' => 'required|in:1,0',
            ]);
            $update = DB::table('users')
                ->where('id', $id)
                ->update(['active' => (int)$request->status]);
            DB::commit();

            return redirect()->route('viewUser')->with('success', 'Account Status updated successfully!');
        } catch (Exception $th) {
            DB::rollBack();
            return redirect()->route('viewUser')->with('error', 'Failed to update Account Status!');
        }
    }
}
