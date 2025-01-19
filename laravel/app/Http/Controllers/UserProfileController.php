<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    //
    public function updateProfilePersonalDetailAdmin(Request $request)
    {

        DB::beginTransaction();
        try {
            // $existingIC = DB::table('users')
            //     ->where('icNo', $request->icNo)
            //     ->where('id', '!=', Auth::user()->id)
            //     ->first();

            // if ($existingIC) {
            //     return back()->withErrors(['icNo' => 'The IC Number already exists.'])->withInput();
            // }

            // $existingEmail = DB::table('users')
            //     ->where('email', $request->email)
            //     ->where('id', '!=', Auth::user()->id)
            //     ->first();

            // if ($existingEmail) {
            //     return back()->withErrors(['email' => 'The Email already exists.'])->withInput();
            // }


            $validatedData = $request->validate([
                // 'icNo' => 'required|digits:12',
                // 'name' => 'required',
                'email' => 'required|email',
                'telno' => 'required',
                'address' => 'required',
                'state' => 'required|exists:states,name',

            ], [
                'ostate.in' => 'The selected state is invalid. Please choose a valid state.',
            ], [
                'icNo' => 'IC Number',
                'name' => 'Full Name',
                'email' => 'Email',
                'telno' => 'Phone Number',
                'address' => 'Address',
                'state' => 'State',
            ]);

            DB::table('users')->where('id', Auth::user()->id)->update([
                // 'icNo' => $validatedData['icNo'],
                // 'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'telno' => $validatedData['telno'],
                'address' => $validatedData['address'],
                'state' => $validatedData['state'],
            ]);

            // Update data ke tabel `organizations`
            DB::table('organization as o')
                ->join('organization_user as ou', 'o.id', 'ou.organization_id')
                ->where('user_id', Auth::user()->id)->update([
                    'address' => $validatedData['address'],
                    'state' => $validatedData['state'],
                    'email' => $validatedData['email'],

                ]);

            DB::commit();

            return back()->with('success', 'Your Profile Detail has been updated!')->withFragment('your');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            // return message error validation dengan menggunakan withErrors and pass withFragment
            return back()->withErrors($e->errors())->withInput()->withFragment('your');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    }

    public function updatePasswordAdmin(Request $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => 'required|min:5',
                'cpassword' => 'required|min:5|same:password',
            ], [], [
                'current_password' => 'Current Password',
                'password' => 'Password',
                'cpassword' => 'Confirm Password',
            ]);
            

            if (!Hash::check($request->current_password, Auth::user()->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput()->withFragment('change-password');
            }

            $newPassword = bcrypt($request->password);

            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['password' => $newPassword]);

            DB::commit();
            return back()->with('success', 'Your Password has been updated!')->withFragment('change-password');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            // return message error validation dengan menggunakan withErrors and pass withFragment
            return back()->withErrors($e->errors())->withInput()->withFragment('change-password');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    }

    public function updateProfilePersonalDetailStaff(Request $request)
    {
        // dd($request->all());

        DB::beginTransaction();
        try {
            $existingIC = DB::table('users')
                ->where('icNo', $request->icNo)
                ->where('id', '!=', Auth::user()->id)
                ->first();

            if ($existingIC) {
                return back()->withErrors(['icNo' => 'The IC Number already exists.'])->withInput();
            }

            $existingEmail = DB::table('users')
                ->where('email', $request->email)
                ->where('id', '!=', Auth::user()->id)
                ->first();

            if ($existingEmail) {
                return back()->withErrors(['email' => 'The Email already exists.'])->withInput();
            }


            $validatedData = $request->validate([
                'icNo' => 'required|digits:12',
                'name' => 'required',
                'email' => 'required|email',
                'telno' => 'required',
                'address' => 'required',
                'state' => [
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

            ], [
                'ostate.in' => 'The selected state is invalid. Please choose a valid state.',
            ], [
                'icNo' => 'IC Number',
                'name' => 'Full Name',
                'email' => 'Email',
                'telno' => 'Phone Number',
                'address' => 'Address',
                'state' => 'State',
            ]);

            DB::table('users')->where('id', Auth::user()->id)->update([
                'icNo' => $validatedData['icNo'],
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'telno' => $validatedData['telno'],
                'address' => $validatedData['address'],
                'state' => $validatedData['state'],
            ]);

            // Update data ke tabel `organizations`
            DB::table('organization as o')
                ->join('organization_user as ou', 'o.id', 'ou.user_id')
                ->where('user_id', Auth::user()->id)->update([
                    'address' => $validatedData['address'],
                    'state' => $validatedData['state'],
                    'email' => $validatedData['email'],

                ]);

            DB::commit();

            return back()->with('success', 'Your Profile Detail has been updated!')->withFragment('your');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            // return message error validation dengan menggunakan withErrors and pass withFragment
            return back()->withErrors($e->errors())->withInput()->withFragment('your');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    }

    public function updatePasswordStaff(Request $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:5',
                'cpassword' => 'required|min:5|same:password',
            ], [], [
                'current_password' => 'Current Password',
                'password' => 'Password',
                'cpassword' => 'Confirm Password',
            ]);

            if (!Hash::check($request->current_password, Auth::user()->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput()->withFragment('change-password');
            }

            $newPassword = bcrypt($request->password);

            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['password' => $newPassword]);

            DB::commit();

            return back()->with('success', 'Your Password has been updated!')->withFragment('change-password');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            // return message error validation dengan menggunakan withErrors and pass withFragment
            return back()->withErrors($e->errors())->withInput()->withFragment('change-password');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    }

    public function updateProfilePersonalDetailContentCreator(Request $request)
    {
        DB::beginTransaction();
        try {
            $existingIC = DB::table('users')
                ->where('icNo', $request->icNo)
                ->where('id', '!=', Auth::user()->id)
                ->first();

            if ($existingIC) {
                return back()->withErrors(['icNo' => 'The IC Number already exists.'])->withInput();
            }

            $existingEmail = DB::table('users')
                ->where('email', $request->email)
                ->where('id', '!=', Auth::user()->id)
                ->first();

            if ($existingEmail) {
                return back()->withErrors(['email' => 'The Email already exists.'])->withInput();
            }


            $validatedData = $request->validate([
                'icNo' => 'required|digits:12',
                'name' => 'required',
                'email' => 'required|email',
                'telno' => 'required',
                'address' => 'required',
                'state' => [
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

            ], [
                'ostate.in' => 'The selected state is invalid. Please choose a valid state.',
            ], [
                'icNo' => 'IC Number',
                'name' => 'Full Name',
                'email' => 'Email',
                'telno' => 'Phone Number',
                'address' => 'Address',
                'state' => 'State',
            ]);

            DB::table('users')->where('id', Auth::user()->id)->update([
                'icNo' => $validatedData['icNo'],
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'telno' => $validatedData['telno'],
                'address' => $validatedData['address'],
                'state' => $validatedData['state'],
            ]);

            // Update data ke tabel `organizations`
            DB::table('organization as o')
                ->join('organization_user as ou', 'o.id', 'ou.user_id')
                ->where('user_id', Auth::user()->id)->update([
                    'address' => $validatedData['address'],
                    'state' => $validatedData['state'],
                    'email' => $validatedData['email'],

                ]);

            DB::commit();

            return back()->with('success', 'Your Profile Detail has been updated!')->withFragment('your');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            // return message error validation dengan menggunakan withErrors and pass withFragment
            return back()->withErrors($e->errors())->withInput()->withFragment('your');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    }

    public function updatePasswordContentCreator(Request $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:5',
                'cpassword' => 'required|min:5|same:password',
            ], [], [
                'current_password' => 'Current Password',
                'password' => 'Password',
                'cpassword' => 'Confirm Password',
            ]);

            if (!Hash::check($request->current_password, Auth::user()->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput()->withFragment('change-password');
            }

            $newPassword = bcrypt($request->password);

            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['password' => $newPassword]);

            DB::commit();

            return back()->with('success', 'Your Password has been updated!')->withFragment('change-password');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            // return message error validation dengan menggunakan withErrors and pass withFragment
            return back()->withErrors($e->errors())->withInput()->withFragment('change-password');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    }
    public function updateProfilePersonalDetailOrganization(Request $request)
    {
        DB::beginTransaction();
        try {
            $existingIC = DB::table('users')
                ->where('icNo', $request->icNo)
                ->where('id', '!=', Auth::user()->id)
                ->first();

            if ($existingIC) {
                return back()->withErrors(['icNo' => 'The IC Number already exists.'])->withInput();
            }

            $existingEmail = DB::table('users')
                ->where('email', $request->email)
                ->where('id', '!=', Auth::user()->id)
                ->first();

            if ($existingEmail) {
                return back()->withErrors(['email' => 'The Email already exists.'])->withInput();
            }


            $validatedData = $request->validate([
                // 'icNo' => 'required|digits:12',
                'name' => 'required',
                'email' => 'required|email',
                'telno' => 'required',
            ], [], [
                // 'icNo' => 'IC Number',
                'name' => 'Full Name',
                'email' => 'Email',
                'telno' => 'Phone Number',
            ]);

            DB::table('users')->where('id', Auth::user()->id)->update([
                // 'icNo' => $validatedData['icNo'],
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'telno' => $validatedData['telno'],
            ]);

            // $data = DB::table('organization as o')
            // ->join('organization_user as ou', 'o.id', '=','ou.organization_id')
            // ->where('ou.user_id', Auth::user()->id)->get();

            // dd($data);

            // Update data ke tabel `organizations`
            DB::table('organization as o')
                ->join('organization_user as ou', 'o.id', '=', 'ou.organization_id')
                ->where('ou.user_id', Auth::user()->id)->update([
                    'email' => $validatedData['email'],

                ]);

            DB::commit();

            return back()->with('success', 'Your Profile Detail has been updated!')->withFragment('your');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            // return message error validation dengan menggunakan withErrors and pass withFragment
            return back()->withErrors($e->errors())->withInput()->withFragment('your');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    }

    public function updateProfileOrganizationDetail(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            // $existingIC = DB::table('users')
            //     ->where('icNo', $request->icNo)
            //     ->where('id', '!=', Auth::user()->id)
            //     ->first();

            // if ($existingIC) {
            //     return back()->withErrors(['icNo' => 'The IC Number already exists.'])->withInput();
            // }

            // $existingEmail = DB::table('users')
            //     ->where('email', $request->email)
            //     ->where('id', '!=', Auth::user()->id)
            //     ->first();

            // if ($existingEmail) {
            //     return back()->withErrors(['email' => 'The Email already exists.'])->withInput();
            // }


            $validatedData = $request->validate([
                'oname' => 'required',
                'oaddress' => 'required',
                'odesc' => 'nullable',
                'ostate' => 'required|exists:states,name',
                'otype' => 'nullable|exists:organization_type,id',

            ], [
                'otype.in' => 'The selected organization type is invalid. Please choose a valid organization type.',
                'ostate.in' => 'The selected state is invalid. Please choose a valid state.',
            ], [
                'oname' => 'Organization Name',
                'odesc' => 'Organization Name',
                'oaddress' => 'Organization Address',
                'ostate' => 'Organization State',
                'otype' => 'Organization Type',
            ]);

            $validatedData['otype'] = (int) $validatedData['otype'];
            $org_type = DB::table('organization_type')
                ->where('id', $validatedData['otype'])
                ->select('type')
                ->first();
            // Update data ke tabel `organizations`
            DB::table('organization as o')
                ->join('organization_user as ou', 'o.id', '=', 'ou.organization_id')
                ->where('user_id', Auth::user()->id)->update([
                    'name' => $validatedData['oname'],
                    'address' => $validatedData['oaddress'],
                    'state' => $validatedData['ostate'],
                    'org_type' => $org_type->type,
                    'desc' => $validatedData['odesc'],

                ]);

            DB::table('users')->where('id', Auth::user()->id)->update([
                'address' => $validatedData['oaddress'],
                'state' => $validatedData['ostate'],
            ]);

            DB::commit();

            return back()->with('success', 'Your Organization Detail has been updated!')->withFragment('organization');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            // return message error validation dengan menggunakan withErrors and pass withFragment
            return back()->withErrors($e->errors())->withInput()->withFragment('organization');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    }

    public function updatePasswordOrganization(Request $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => 'required|min:5',
                'cpassword' => 'required|min:5|same:password',
            ], [], [
                'current_password' => 'Current Password',
                'password' => 'Password',
                'cpassword' => 'Confirm Password',
            ]);

            if (!Hash::check($request->current_password, Auth::user()->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput()->withFragment('change-password');
            }

            $newPassword = bcrypt($request->password);

            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['password' => $newPassword]);

            DB::commit();

            return back()->with('success', 'Your Password has been updated!')->withFragment('change-password');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            // return message error validation dengan menggunakan withErrors and pass withFragment
            return back()->withErrors($e->errors())->withInput()->withFragment('change-password');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    }
}
