<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function viewLogin(){
        return view('auth.login');
    }

    public function viewRegister(){
        return view('auth.register');
    }

    public function register(Request $request){
            $validatedData = $request->validate([
                'icno' => 'required|digits:12',
                'fullname' => 'required|',
                'email' => 'required|email',
                'phoneno' => 'required|',
                'password' => 'required|min:5',
                'cpassword' => 'required|min:5|same:password',
                'oname' => 'required',
                'oaddress' => 'required',
                'ostate' => 'required',
                'otype' => 'required|in:1,2',
            ],[
                'otype.in' => 'The selected organization type is invalid. Please select either Company or Content Creater.',
            ],[
                'icno' => 'IC Number',
                'fullname' => 'Full Name',
                'email' => 'Email',
                'phoneno' => 'Phone Number',
                'password' => 'Password',
                'cpassword' => 'Confirm Passowrd',
                'oname' => 'Organization Name',
                'oaddress' => 'Organization Address',
                'ostate' => 'Organization state',
                'otype' => 'Type',
            ]);

            // $existingIcno = DB::table('users')->where('icno', $validatedData['icno'])->exists();
            // if ($existingIcno) {
            //     return redirect()->back()->withErrors(['icno' => 'The IC number is already registered.'])->withInput();
            // }
        
            $existingEmail = DB::table('users')->where('email', $validatedData['email'])->exists();
            if ($existingEmail) {
                return redirect()->back()->withErrors(['email' => 'The email is already registered.'])->withInput();
            }
    
            $validatedData['password'] = bcrypt(($validatedData['password']));

            $role = $validatedData['otype'] = '1' ? 'Company' : 'Content Creator';
    
            DB::table('users')->insert([
                'name' => $validatedData['fullname'], 
                'password' => $validatedData['password'],
                'telno' => $validatedData['phoneno'],
                'address' => $validatedData['oaddress'],
                'state' => $validatedData['ostate'],
                'email' => $validatedData['email'],
                'icNo' => $validatedData['icno'],
                'status' => 'Active',
                'role' => json_encode([$role]),
                'active' => 1,
                'email_status' => 'Unverified',
                'verification_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect(route('viewLogin'))->with('success','Your account has been successfully created! Please log in with your registered credentials.');
       
    }
}
