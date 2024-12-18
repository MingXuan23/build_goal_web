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

    public function updateUser(Request $request, $id)
    {
        
        // dd($id);
        DB::beginTransaction();
        try {

            $user = DB::table('users')->where('id', $id)->first();

            if (!$user) {
                return back()->with('error','User not found. Please make sure your user ID is correct.');
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
            
            if ($getOrganizationUser) {
               ;
                DB::table('organization')->where('id', $getOrganizationUser->organization_id)->update([
                    'name' => $name,
                    'address' => $validatedData['oaddress'],
                    'state' => $validatedData['ostate'],
                    'email' => $validatedData['email'],
                    'org_type' => $org_type_data ? $org_type_data->type : null, // If no type is found, set to null
                    'updated_at' => now(),
                ]);
              ;
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
                return back()->with('error','User not found. Please make sure your user ID is correct.');
            }


            // $existingIC = DB::table('users')
            //     ->where('icno', $request->icno)
            //     ->where('id', '!=', $id)
            //     ->first();

            // if ($existingIC) {
            //     return back()->with('error', 'The IC Number already exists.');
            // }


            // $existingEmail = DB::table('users')
            //     ->where('email', $request->email)
            //     ->where('id', '!=', $id)
            //     ->first();

            // if ($existingEmail) {
            //     return back()->with('error', 'The Email already exists.');
            // }

           
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

    public function userDeleteAdmin(Request $request,$id){
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
}
