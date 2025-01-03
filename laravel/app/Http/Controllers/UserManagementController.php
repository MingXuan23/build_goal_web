<?php

namespace App\Http\Controllers;

use App\Mail\AdminRegistrationUserMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserManagementController extends Controller
{
    //

    public function updateUser(Request $request, $id)
    {

        // dd($id);
        DB::beginTransaction();
        try {

            $user = DB::table('users')->where('id', $id)->first();

            if (!$user) {
                return back()->with('error', 'User not found. Please make sure your user ID is correct.');
            }


            $existingIC = DB::table('users')
                ->where('icno', $request->icno)
                ->where('id', '!=', $id)
                ->first();

            if ($existingIC) {
                return back()->with('error', 'The IC Number already exists.');
            }


            $existingEmail = DB::table('users')
                ->where('email', $request->email)
                ->where('id', '!=', $id)
                ->first();

            if ($existingEmail) {
                return back()->with('error', 'The Email already exists.');
            }


            $validatedData = $request->validate([
                'icno' => 'required|digits:12',
                'fullname' => 'required',
                'email' => 'required|email',
                'phoneno' => 'required',
                'password' => 'nullable',
                'cpassword' => 'same:password|nullable',
                'oname' => 'nullable',
                'oaddress' => 'nullable',
                'ostate' => 'nullable|exists:states,name',
                'otype' => 'nullable|exists:organization_type,id',
            ], [
                'otype.in' => 'The selected organization type is invalid. Please choose a valid organization type.',
                'ostate.in' => 'The selected state is invalid. Please choose a valid state.',
            ], [
                'icno' => 'IC Number',
                'fullname' => 'Full Name',
                'email' => 'Email',
                'phoneno' => 'Phone Number',
                'password' => 'Password',
                'cpassword' => 'Confirm Password',
                'oname' => 'Organization Name',
                'oaddress' => 'Organization Address',
                'ostate' => 'Organization State',
                'otype' => 'Organization Type',
            ]);



            $newPassword = $user->password;
            if (!empty($request->password)) {
                $newPassword = bcrypt(($validatedData['password']));;
            }

            DB::table('users')->where('id', $id)->update([
                'icNo' => $validatedData['icno'],
                'name' => $validatedData['fullname'],
                'email' => $validatedData['email'],
                'telno' => $validatedData['phoneno'],
                'address' => $validatedData['oaddress'],
                'state' => $validatedData['ostate'],
                'password' => $newPassword,
                'updated_at' => now(),
            ]);

            $orgType = $validatedData['otype'] ?? null;


            $org_type_data = null;
            if ($orgType) {
                $org_type_data = DB::table('organization_type')
                    ->where('id', $orgType)
                    ->select('type')
                    ->first();
            }

            $name = $validatedData['oname'] ?? $validatedData['fullname'];
            $getOrganizationUser = DB::table('organization_user')->where('user_id', $id)->select('organization_id')->first();

            if ($getOrganizationUser) {;
                DB::table('organization')->where('id', $getOrganizationUser->organization_id)->update([
                    'name' => $name,
                    'address' => $validatedData['oaddress'],
                    'state' => $validatedData['ostate'],
                    'email' => $validatedData['email'],
                    'org_type' => $org_type_data ? $org_type_data->type : null, // If no type is found, set to null
                    'updated_at' => now(),
                ]);;
            }


            DB::commit();
            return back()->with('success', 'User updated successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'ERROR: ' . $e->getLine() . ' : ' . $e->getMessage());
        }
    }
    public function updateUserMobile(Request $request, $id)
    {

        DB::beginTransaction();
        try {

            $user = DB::table('users')->where('id', $id)->first();

            if (!$user) {
                return back()->with('error', 'User not found. Please make sure your user ID is correct.');
            }


            $existingIC = DB::table('users')
                ->where('icno', $request->icno)
                ->where('id', '!=', $id)
                ->first();

            if ($existingIC) {
                return back()->with('error', 'The IC Number already exists.');
            }


            $existingEmail = DB::table('users')
                ->where('email', $request->email)
                ->where('id', '!=', $id)
                ->first();

            if ($existingEmail) {
                return back()->with('error', 'The Email already exists.');
            }


            $validatedData = $request->validate([
                'icno' => 'required|digits:12',
                'fullname' => 'required',
                'email' => 'required|email',
                'phoneno' => 'required',
                'password' => 'nullable',
                'cpassword' => 'same:password|nullable',
                'address' => 'nullable',
                'state' => 'nullable',
            ], [
                'otype.in' => 'The selected organization type is invalid. Please choose a valid organization type.',
                'ostate.in' => 'The selected state is invalid. Please choose a valid state.',
            ], [
                'icno' => 'IC Number',
                'fullname' => 'Full Name',
                'email' => 'Email',
                'phoneno' => 'Phone Number',
                'password' => 'Password',
                'cpassword' => 'Confirm Password',
                'address' => 'Organization Address',
                'state' => 'Organization State',
            ]);



            $newPassword = $user->password;
            if (!empty($request->password)) {
                $newPassword = bcrypt(($validatedData['password']));;
            }

            DB::table('users')->where('id', $id)->update([
                'icNo' => $validatedData['icno'],
                'name' => $validatedData['fullname'],
                'email' => $validatedData['email'],
                'telno' => $validatedData['phoneno'],
                'address' => $validatedData['address'],
                'state' => $validatedData['state'],
                'password' => $newPassword,
                'updated_at' => now(),
            ]);


            DB::commit();
            return back()->with('success', 'User updated successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'ERROR: ' . $e->getLine() . ' : ' . $e->getMessage());
        }
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

            return redirect()->route('showUserAdmin')->with('success', 'Roles Updated Successfully!');
        } catch (Exception $th) {
            DB::rollBack();
            return redirect()->route('showUserAdmin')->with('error', 'Failed to update roles!');
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

            return redirect()->route('showUserAdmin')->with('success', 'e-kyc Status Updated Successfully!');
        } catch (Exception $th) {
            DB::rollBack();
            return redirect()->route('showUserAdmin')->with('error', 'Failed to update e-kyc Status!');
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

            return redirect()->route('showUserAdmin')->with('success', 'Email Status Updated Successfully!');
        } catch (Exception $th) {
            DB::rollBack();
            return redirect()->route('showUserAdmin')->with('error', 'Failed to update Email Status!');
        }
    }

    public function updateGptAccount(Request $request, $id)
    {

        DB::beginTransaction();
        try {
            $request->validate([
                'status' => 'required|in:1,0',
            ]);
            if ($request->status == 1) {
                $gpt_status = 1;
            } else {
                $gpt_status = 0;
            }
            $update = DB::table('users')
                ->where('id', $id)
                ->update(['is_gpt' => (int)$request->status, 'gpt_status' => $gpt_status]);
            DB::commit();

            return redirect()->route('showUserAdmin')->with('success', 'Gpt Account Updated Successfully!');
        } catch (Exception $th) {
            DB::rollBack();
            return redirect()->route('showUserAdmin')->with('error', 'Failed to update Email Status!');
        }
    }
    public function updateGptStatus(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'status' => 'required|in:1,0',
            ]);
            $update = DB::table('users')
                ->where('id', $id)
                ->update(['gpt_status' => (int)$request->status]);
            DB::commit();

            return redirect()->route('showUserAdmin')->with('success', 'Gpt Status Updated Successfully!');
        } catch (Exception $th) {
            DB::rollBack();
            return redirect()->route('showUserAdmin')->with('error', 'Failed to update Email Status!');
        }
    }
    public function updateEmailStatusMobile(Request $request, $id)
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

            return redirect()->route('showUserMobile')->with('success', 'Email Status Updated Successfully!');
        } catch (Exception $th) {
            DB::rollBack();
            return redirect()->route('showUserMobile')->with('error', 'Failed to update Email Status!');
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

            return redirect()->route('showUserAdmin')->with('success', 'Account Status Updated Successfully!');
        } catch (Exception $th) {
            DB::rollBack();
            return redirect()->route('showUserAdmin')->with('error', 'Failed to update Account Status!');
        }
    }
    public function updateAccountStatusMobile(Request $request, $id)
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

            return redirect()->route('showUserMobile')->with('success', 'Account Status Updated Successfully!');
        } catch (Exception $th) {
            DB::rollBack();
            return redirect()->route('showUserMobile')->with('error', 'Failed to update Account Status!');
        }
    }

    public function userDeleteAdmin(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            $user = DB::table('users')->where('id', $id)->first();

            if (!$user) {
                return back()->with('error', 'User not found,');
            }

            DB::table('users')->where('id', $id)->delete();
            DB::commit();

            return back()->with('success', 'User has been deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function addUserAdmin(Request $request)
    {
        // dd($request->all());

        $validatedData = $request->validate([
            'icNo' => 'required|digits:12|unique:users',
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'),
            ],
            'phone' => 'required',
            'password' => 'required|min:5',
            'cpassword' => 'required|min:5|same:password',
            'address' => 'required',
            'state' => 'required|exists:states,name',
        ], [], []);
        $passwordToSend = $validatedData['password'];
        $validatedData['password'] = bcrypt(($validatedData['password']));
        $validatedData['phone'] = '+6' . $validatedData['phone'];
        DB::beginTransaction();
        try {
            $user = DB::table('users')->insertGetId([
                'name' => $validatedData['name'],
                'password' => $validatedData['password'],
                'telno' => $validatedData['phone'],
                'icNo' => $validatedData['icNo'],
                'address' => $validatedData['address'],
                'state' => $validatedData['state'],
                'email' => $validatedData['email'],
                'status' => 'ACTIVE',
                'role' => json_encode([1]),
                'active' => 1,
                'is_gpt' => 0,
                'gpt_status' => 0,
                'email_status' => 'VERIFY',
                'ekyc_status' => 0,
                'verification_code' => '000000',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $org_type = DB::table('organization_type')
                ->where('id', 2)
                ->select('type')
                ->first();

            $organization = DB::table('organization')->insertGetId([
                'name' => $validatedData['name'],
                'address' => $validatedData['address'],
                'state' => $validatedData['state'],
                'email' => $validatedData['email'],
                'org_type' => $org_type->type,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('organization_user')->insert([
                'user_id' => $user,
                'organization_id' => $organization,
                'role_id' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            DB::commit();
            $email_status = DB::table('email_status')->where('name', 'NOTIFICATION-REGISTER-USER-ADMIN')->first();
            if ($email_status && $email_status->status == 1) {
                $register_type = "Admin";
                $logData = [
                    'email_type' => 'REGISTER ADMIN - ADMIN',
                    'recipient_email' => $validatedData['email'],
                    'from_email' => 'admin@xbug.online',
                    'name' => $validatedData['name'],
                    'status' => 'SUCCESS',
                    'response_data' => 'PASSWORD HAS BEEN SEND',
                    'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                    'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                ];
                DB::table('email_logs')->insert($logData);

                Mail::mailer('smtp')->to($validatedData['email'])->send(new AdminRegistrationUserMail($validatedData['name'], $register_type, $passwordToSend,$validatedData['email']));
            }
            return back()->with('success', 'Admin user has been created Successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function addUserOgranization(Request $request)
    {
        $validatedData = $request->validate([
            'icno' => 'required|digits:12|unique:users',
            'fullname' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'),
            ],
            'phone' => 'required',
            'password' => 'required|min:5',
            'cpassword' => 'required|min:5|same:password',
            'oname' => 'required',
            'oaddress' => 'required',
            'ostate' => 'required|exists:states,name',
            'otype' => 'required|exists:organization_type,id',
        ], [
            'otype.in' => 'The selected organization type is invalid. Please choose a valid organization type.',
            'ostate.in' => 'The selected state is invalid. Please choose a valid state.',
        ], [
            'icno' => 'IC Number',
            'fullname' => 'Full Name',
            'email' => 'Email',
            'phoneno' => 'Phone Number',
            'password' => 'Password',
            'cpassword' => 'Confirm Passowrd',
            'oname' => 'Organization Name',
            'oaddress' => 'Organization Address',
            'ostate' => 'Organization state',
            'otype' => 'Organization Type',
        ]);
        $passwordToSend = $validatedData['password'];
        $validatedData['password'] = bcrypt(($validatedData['password']));
        $validatedData['phone'] = '+6' . $validatedData['phone'];

        DB::beginTransaction();
        try {

            $user = DB::table('users')->insertGetId([
                'name' => $validatedData['fullname'],
                'password' => $validatedData['password'],
                'telno' => $validatedData['phone'],
                'icNo' => $validatedData['icno'],
                'address' => $validatedData['oaddress'],
                'state' => $validatedData['ostate'],
                'email' => $validatedData['email'],
                'status' => 'ACTIVE',
                'role' => json_encode([2]),
                'active' => 1,
                'email_status' => 'VERIFY',
                'is_gpt' => 0,
                'gpt_status' => 0,
                'ekyc_status' => 0,
                'verification_code' => '000000',
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            $validatedData['otype'] = (int) $validatedData['otype'];
            $org_type = DB::table('organization_type')
                ->where('id', $validatedData['otype'])
                ->select('type')
                ->first();

            $organization = DB::table('organization')->insertGetId([
                'name' => $validatedData['oname'],
                'address' => $validatedData['oaddress'],
                'state' => $validatedData['ostate'],
                'email' => $validatedData['email'],
                'org_type' => $org_type->type,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('organization_user')->insert([
                'user_id' => $user,
                'organization_id' => $organization,
                'role_id' => 2,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            DB::commit();
            $email_status = DB::table('email_status')->where('name', 'NOTIFICATION-REGISTER-USER-ADMIN')->first();
            if ($email_status && $email_status->status == 1) {
                $register_type = "Organization";
                $logData = [
                    'email_type' => 'REGISTER ORGANIZATION - ADMIN',
                    'recipient_email' => $validatedData['email'],
                    'from_email' => 'admin@xbug.online',
                    'name' => $validatedData['fullname'],
                    'status' => 'SUCCESS',
                    'response_data' => 'PASSWORD HAS BEEN SEND',
                    'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                    'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                ];
                DB::table('email_logs')->insert($logData);
                Mail::mailer('smtp')->to($validatedData['email'])->send(new AdminRegistrationUserMail($validatedData['fullname'], $register_type, $passwordToSend,$validatedData['email']));
            }
            return back()->with('success', 'Organization user has been created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function addUserMobile(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'icNo' => 'required|digits:12|unique:users',
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'),
            ],
            'phone' => 'required',
            'password' => 'required|min:5',
            'cpassword' => 'required|min:5|same:password',
            'address' => 'required',
            'state' => 'required|exists:states,name',
        ], [], []);
        $passwordToSend = $validatedData['password'];

        $validatedData['password'] = bcrypt(($validatedData['password']));
        $validatedData['phone'] = '+6' . $validatedData['phone'];
        DB::beginTransaction();
        try {

            $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $user = DB::table('users')->insertGetId([
                'name' => $validatedData['name'],
                'password' => $validatedData['password'],
                'telno' => $validatedData['phone'],
                'icNo' => $validatedData['icNo'],
                'address' => $validatedData['address'],
                'state' => $validatedData['state'],
                'email' => $validatedData['email'],
                'status' => 'ACTIVE',
                'role' => json_encode([5]),
                'active' => 1,
                'is_gpt' => 0,
                'gpt_status' => 0,
                'email_status' => 'VERIFY',
                'ekyc_status' => 0,
                'verification_code' => '000000',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            $email_status = DB::table('email_status')->where('name', 'NOTIFICATION-REGISTER-USER-ADMIN')->first();
            if ($email_status && $email_status->status == 1) {
                $register_type = "Mobile User";
                $logData = [
                    'email_type' => 'REGISTER MOBILE - ADMIN',
                    'recipient_email' => $validatedData['email'],
                    'from_email' => 'admin@xbug.online',
                    'name' => $validatedData['name'],
                    'status' => 'SUCCESS',
                    'response_data' => 'PASSWORD HAS BEEN SEND',
                    'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                    'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                ];
                DB::table('email_logs')->insert($logData);
                Mail::mailer('smtp')->to($validatedData['email'])->send(new AdminRegistrationUserMail($validatedData['name'], $register_type, $passwordToSend,$validatedData['email']));
            }
            return back()->with('success', 'Mobile user has been created Successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
