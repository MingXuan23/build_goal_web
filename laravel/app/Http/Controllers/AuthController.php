<?php

namespace App\Http\Controllers;

use App\Mail\ResendVerificationCodeMail;
use App\Mail\ResetPasswordMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function maskEmail($email)
    {
        $parts = explode('@', $email);
        $username = $parts[0]; // Bagian username sebelum '@'
        $maskedUsername = substr($username, 0, 3) . str_repeat('*', strlen($username) - 4);
        return $maskedUsername . '@' . $parts[1];
    }
    public function viewLogin()
    {
        return view('auth.login');
    }

    public function viewOrganizationRegister()
    {
        $organization_type = DB::table('organization_type')->select('id', 'type')->get();
        return view('auth.organization-register', [
            'organization_types' => $organization_type
        ]);
    }

    public function viewVerify()
    {

        return view('auth.verify-code');
    }
    public function viewResetPassword()
    {

        return view('auth.reset-password');
    }




    public function viewContentCreatorRegister()
    {
        $organization_type = DB::table('organization_type')->select('id', 'type')->get();
        return view('auth.content-creator-register', [
            'organization_types' => $organization_type
        ]);
    }

    public function createOrganizationRegister(Request $request)
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

        $validatedData['password'] = bcrypt(($validatedData['password']));


        DB::beginTransaction();
        try {
            // Insert ke tabel users
            $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $user = DB::table('users')->insertGetId([
                'name' => $validatedData['fullname'],
                'password' => $validatedData['password'],
                'telno' => $validatedData['phoneno'],
                'icNo' => $validatedData['icno'],
                'email' => $validatedData['email'],
                'status' => 'Active',
                'role' => json_encode([3]),
                'active' => 1,
                'email_status' => 'NOT VERIFY',
                'verification_code' => $verificationCode,
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
                'role_id' => 3,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            Session::put('user_id', $user);
            DB::commit();


            Mail::to($validatedData['email'])->send(new VerificationCodeMail($validatedData['fullname'], $verificationCode));

            return redirect(route('viewVerify'))->with('success', 'Registration successfull. Please check your Inbox or Spam email to get verification code to active your account');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withError('Error EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    }

    public function createContentCreatorRegister(Request $request)
    {
        $validatedData = $request->validate([
            'icno' => 'required|digits:12|unique:users',
            'fullname' => 'required',
            'email' => 'required|email|unique:users',
            'phoneno' => 'required',
            'password' => 'required|min:5',
            'cpassword' => 'required|min:5|same:password',
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
            ]

        ], [], [
            'icno' => 'IC Number',
            'fullname' => 'Full Name',
            'email' => 'Email',
            'phoneno' => 'Phone Number',
            'password' => 'Password',
            'cpassword' => 'Confirm Passowrd',
            'address' => 'Address',
            'state' => 'State',
        ]);

        $validatedData['password'] = bcrypt(($validatedData['password']));

        DB::beginTransaction();
        try {
            $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $user = DB::table('users')->insertgetId([
                'name' => $validatedData['fullname'],
                'password' => $validatedData['password'],
                'telno' => $validatedData['phoneno'],
                'icNo' => $validatedData['icno'],
                'email' => $validatedData['email'],
                'status' => 'Active',
                'role' => json_encode([4]),
                'active' => 1,
                'email_status' => 'NOT VERIFY',
                'verification_code' => $verificationCode,
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            $organization = DB::table('organization')->insertgetId([
                'name' => $validatedData['fullname'],
                'address' => $validatedData['address'],
                'state' => $validatedData['state'],
                'email' => $validatedData['email'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Db::table('organization_user')->insert([
                'user_id' => $user,
                'organization_id' => $organization,
                'role_id' => 4,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            Session::put('user_id', $user);
            DB::commit();
            Mail::to($validatedData['email'])->send(new VerificationCodeMail($validatedData['fullname'], $verificationCode));

            return redirect(route('viewVerify'))->with('success', 'Registration successfull. Please check your Inbox or Spam email to get verification code to active your account');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withError('Error EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    }

    public function login(Request $request)
    {
        $validatedData =  $request->validate([
            'email' => 'required',
            'password' => 'required|min:5',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            if ($user->email_status === "NOT VERIFY") {
                Session::put('user_id', $user->id);
                $maskedEmail = $this->maskEmail($user->email);
                return back()->with('error', 'Your account is not verified by email. <a class="fw-bold text-danger" href="' . route('resendVerify') . '">Click here</a> to get the verification code via email ' . $maskedEmail);
            }

            if ($user->active !== 1) {
                return back()->with('error', 'Your account is block, Please Contact us by email to help-center@xbug.online for inform if we mistake');
            }
            // dd($user);
            if (in_array(1, json_decode($user->role))) {
                return redirect('/admin/dashboard');
            } elseif (in_array(2, json_decode($user->role))) {
                return redirect('/staff/dashboard');
            } elseif (in_array(3, json_decode($user->role))) {
                return redirect('/organization/dashboard');
            } elseif (in_array(4, json_decode($user->role))) {
                return redirect('/content-creator/dashboard');
            }
        }

        return back()->with('error', 'Invalid credentials. Please make sure your email and password is correct');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->flush();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out successfully!');
    }

    public function resendVerify(Request $request)
    {

        try {
            $user = Auth::user();

            if (!$user) {
                $userId = Session::get('user_id');

                if (!$userId) {
                    return redirect()->route('login')->with('error', 'Your session has expired, please login to get new verification code - 1');
                }

                $user = DB::table('users')->find($userId);


                if (!$user) {
                    return redirect()->route('login')->with('error', 'Your session has expired, please login to get new verification code - 2');
                }
            }

            $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            DB::table('users')
                ->where('id', $user->id)
                ->update(['verification_code' => $verificationCode]);

            Mail::to($user->email)->send(new ResendVerificationCodeMail($user->name, $verificationCode));

            return redirect(route('viewVerify'))->with('success', 'Resend code successfull. Please check your Inbox or Spam email to get verification code to active your account');
        } catch (\Exception $e) {
            return back()->with('error', 'There was an error sending the verification code. Please try again later. Error: ' . $e->getMessage());
        }
    }

    public function verifyCode(Request $request)
    {
        $validator = $request->validate([
            'input1' => 'required',
            'input2' => 'required',
            'input3' => 'required',
            'input4' => 'required',
            'input5' => 'required',
            'input6' => 'required',
        ], [
            'required' => 'Please fill up all the verifcation code',
        ], []);


        $inputCode = $request->input('input1') . $request->input('input2') . $request->input('input3') .
            $request->input('input4') . $request->input('input5') . $request->input('input6');
        $userId = Session::get('user_id');
        $user = DB::table('users')->where('id', $userId)->first();
        // dd($user);

        if (!$user) {
            return back()->with('error', 'Your session has expired, please login to get new verification code');
        }

        if ($inputCode == $user->verification_code) {
            try {
                DB::table('users')
                    ->where('id', $userId)
                    ->update(['email_status' => 'VERIFY']);

                Session::forget('user_id');
                return redirect(route('viewLogin'))->with('success', 'Your email has been verified!, Now you can Login...');
            } catch (\Exception $e) {
                return back()->with('error', 'Error: ' . $e->getMessage());
            }
        } else {
            return back()->with('error', 'Invalid verification code. Please make sure yuor verifciation code is valid');
        }
    }






    public function resetPassword(Request $request)
    {
        $validator = $request->validate([
            'emailResetPassword' => 'required|email|exists:users,email',
        ], [
            'emailResetPassword.required' => 'Please fill the email address.',
            'emailResetPassword.email' => 'Please enter a valid email address.',
            'emailResetPassword.exists' => 'This email does not exist in our records.',
        ], []);
        DB::beginTransaction();
        try {
            $user = DB::table('users')->where('email', $validator['emailResetPassword'])->first();

            if (!$user) {
                return back()->with('error', 'This email does not exist in our records. Please make sure your email address is valid');
            }
            Session::put('user_email', $validator['emailResetPassword']);
            $password = Str::random(6);
            DB::table('users')->where('email', $validator['emailResetPassword'])->update([
                'password' => bcrypt($password)
            ]);
            DB::commit();
            Mail::to($user->email)->send(new ResetPasswordMail($user->name, $password));
            return back()->with('success', 'Password reset successfully. A new password has been sent to your email. Use it to login. You can change later when you login into your account. If You dont recieve a email, click resend email');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withError('Error EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    }



    public function resendResetPassword(Request $request)
    {

        try {


            $userId = Session::get('user_email');
           

            if (!$userId) {
                return back()->with('error', 'Your session has expired, please login to get new verification code - 1');
            }

            $user = DB::table('users')->where('email',$userId)->first();
            // dd($user);


            if (!$user) {
                return back()->with('error', 'This email does not exist in our records. Please make sure your email address is valid - 2');
            }


            $password = Str::random(6);
            DB::table('users')->where('email', $userId)->update([
                'password' => bcrypt($password)
            ]);
            DB::commit();
            Mail::to($user->email)->send(new ResetPasswordMail($user->name, $password));
            return back()->with('success', 'Password has been resend, Check Your Inbox or Spam email to get the new password. If You dont recieve a email, click resend email');

        } catch (\Exception $e) {
            return back()->with('error', 'There was an error sending the email reset password. Please try again later. Error: ' . $e->getMessage());
        }
    }
}
