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
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{

    public function maskEmail($email)
    {
        $parts = explode('@', $email);
        $username = $parts[0];
        $maskedUsername = substr($username, 0, 3) . str_repeat('*', strlen($username) - 4);
        return $maskedUsername . '@' . $parts[1];
    }
    public function viewLogin()
    {
        if (Auth::check()) {
            $roles = json_decode(Auth::user()->role, true);

            if (in_array(1, $roles)) {
                // Admin
                return redirect('/admin/dashboard');
            } elseif (in_array(2, $roles)) {
                // Organization
                return redirect('/organization/content-management');
            } elseif (in_array(3, $roles)) {
                // Content Creator
                return redirect('/content-creator/content-management');
            }
        }
        return view('auth.login');
    }
    public function viewVerifyUserOrganization()
    {
        return view('auth.verify-user-organization');
    }
    public function viewVerifyUserContentCreator()
    {
        return view('auth.verify-user-content-creator');
    }

    public function requestDelAcc()
    {
        return view('auth.requestDelAcc');
    }

    public function policy()
    {
        return view('auth.policy');
    }
    public function viewOrganizationRegister()
    {
        $organization_type = DB::table('organization_type')->select('id', 'type')->get();
        $state = DB::table('states')->select('id', 'name')->get();
        return view('auth.organization-register', [
            'organization_types' => $organization_type,
            'states' => $state
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
        $state = DB::table('states')->select('id', 'name')->get();
        return view('auth.content-creator-register', [
            'organization_types' => $organization_type,
            'states' => $state
        ]);
    }
    // public function createOrganizationRegister(Request $request)
    // {
    //     // dd($request->all());
    //     $validatedData = $request->validate([
    //         'icno' => 'required|digits:12|unique:users',
    //         'fullname' => 'required',
    //         'email' => [
    //             'required',
    //             'email',
    //             // Rule::unique('organization', 'email'),
    //             Rule::unique('users', 'email'),
    //         ],
    //         'phoneno' => 'required',
    //         'password' => 'required|min:5',
    //         'cpassword' => 'required|min:5|same:password',
    //         'oname' => 'required',
    //         'oaddress' => 'required',
    //         'ostate' => 'required|exists:states,name',
    //         'otype' => 'required|exists:organization_type,id',
    //     ], [
    //         'otype.in' => 'The selected organization type is invalid. Please choose a valid organization type.',
    //         'ostate.in' => 'The selected state is invalid. Please choose a valid state.',
    //     ], [
    //         'icno' => 'IC Number',
    //         'fullname' => 'Full Name',
    //         'oemail' => 'Email',
    //         'phoneno' => 'Phone Number',
    //         'password' => 'Password',
    //         'cpassword' => 'Confirm Passowrd',
    //         'oname' => 'Organization Name',
    //         'oaddress' => 'Organization Address',
    //         'ostate' => 'Organization state',
    //         'otype' => 'Organization Type',
    //     ]);

    //     $response = $request->input('g-recaptcha-response');
    //     $secretKey = env('RECAPTCHA_SECRET_KEY');

    //     $verifyResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
    //         'secret' => $secretKey,
    //         'response' => $response,
    //     ]);

    //     $verifyResult = $verifyResponse->json();

    //     // dd($verifyResult);

    //     if (!$verifyResult['success']) {
    //         return back()->with(['error' => 'Please verify that you are not a robot.']);
    //     }

    //     $validatedData['password'] = bcrypt(($validatedData['password']));
    //     $validatedData['phoneno'] = '+60' . $validatedData['phoneno'];


    //     DB::beginTransaction();
    //     try {
    //         // Insert ke tabel users
    //         $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    //         $user = DB::table('users')->insertGetId([
    //             'name' => $validatedData['fullname'],
    //             'password' => $validatedData['password'],
    //             'telno' => $validatedData['phoneno'],
    //             'icNo' => $validatedData['icno'],
    //             'address' => $validatedData['oaddress'],
    //             'state' => $validatedData['ostate'],
    //             'email' => $validatedData['email'],
    //             'status' => 'ACTIVE',
    //             'role' => json_encode([2]),
    //             'active' => 1,
    //             'email_status' => 'NOT VERIFY',
    //             'verification_code' => $verificationCode,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);


    //         $validatedData['otype'] = (int) $validatedData['otype'];
    //         $org_type = DB::table('organization_type')
    //             ->where('id', $validatedData['otype'])
    //             ->select('type')
    //             ->first();

    //         $organization = DB::table('organization')->insertGetId([
    //             'name' => $validatedData['oname'],
    //             'address' => $validatedData['oaddress'],
    //             'state' => $validatedData['ostate'],
    //             'email' => $validatedData['email'],
    //             'org_type' => $org_type->type,
    //             'created_at' => now(),
    //             'updated_at' => now()
    //         ]);

    //         DB::table('organization_user')->insert([
    //             'user_id' => $user,
    //             'organization_id' => $organization,
    //             'role_id' => 2,
    //             'status' => 1,
    //             'created_at' => now(),
    //             'updated_at' => now()
    //         ]);
    //         Session::put('user_id', $user);


    //         $logData = [
    //             'email_type' => 'REGISTER ORGANIZATION',
    //             'recipient_email' => $validatedData['email'],
    //             'from_email' => 'admin@xbug.online',
    //             'name' => $validatedData['fullname'],
    //             'status' => 'SUCCESS',
    //             'response_data' => 'Verification code send',
    //             'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
    //             'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
    //         ];

    //         DB::table('email_logs')->insert($logData);
    //         DB::commit();
    //         Mail::to($validatedData['email'])->send(new VerificationCodeMail($validatedData['fullname'], $verificationCode));

    //         return redirect(route('viewVerify'))->with('success', 'Registration successfull. Please check your Inbox or Spam email to get verification code to active your account');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         $logData = [
    //             'email_type' => 'REGISTER ORGANIZATION',
    //             'recipient_email' => $validatedData['email'],
    //             'from_email' => 'admin@xbug.online',
    //             'name' => $validatedData['fullname'],
    //             'status' => 'FAILED',
    //             'response_data' => 'ERROR',
    //             'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
    //             'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
    //         ];

    //         DB::table('email_logs')->insert($logData);
    //         return back()->withError('Error EDE' . $e->getLine() . ' : ' . $e->getMessage());
    //     }
    // }
    public function createOrganizationRegister(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'icno' => 'required|digits:12|unique:users',
            'fullname' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'),
            ],
            'phoneno' => 'required',
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
            'oemail' => 'Email',
            'phoneno' => 'Phone Number',
            'password' => 'Password',
            'cpassword' => 'Confirm Password',
            'oname' => 'Organization Name',
            'oaddress' => 'Organization Address',
            'ostate' => 'Organization state',
            'otype' => 'Organization Type',
        ]);

        // Get the Turnstile response from the form
        $response = $request->input('cf-turnstile-response');
        $secretKey = env('CLOUDFLARE_TURNSTILE_SECRET_KEY'); // Add your Turnstile secret key to the .env file

        // Get the user's IP address (optional)
        $ip = $request->ip();

        // Call the Cloudflare Turnstile siteverify API
        $verifyResponse = Http::asJson()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => $secretKey,
            'response' => $response,
            'remoteip' => $ip,
        ]);

        $verifyResult = $verifyResponse->json();

        // Check if Turnstile verification was successful
        if (!$verifyResult['success']) {
            return back()->with(['error' => 'Please verify that you are not a robot.']);
        }

        $validatedData['password'] = bcrypt($validatedData['password']);
        $validatedData['phoneno'] = '+60' . $validatedData['phoneno'];

        DB::beginTransaction();
        try {
            // Insert into the users table
            $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $user = DB::table('users')->insertGetId([
                'name' => $validatedData['fullname'],
                'password' => $validatedData['password'],
                'telno' => $validatedData['phoneno'],
                'icNo' => $validatedData['icno'],
                'address' => $validatedData['oaddress'],
                'state' => $validatedData['ostate'],
                'email' => $validatedData['email'],
                'status' => 'ACTIVE',
                'role' => json_encode([2]),
                'active' => 1,
                'email_status' => 'NOT VERIFY',
                'verification_code' => $verificationCode,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $validatedData['otype'] = (int) $validatedData['otype'];
            $orgType = DB::table('organization_type')
                ->where('id', $validatedData['otype'])
                ->select('type')
                ->first();

            // Insert into the organization table
            $organization = DB::table('organization')->insertGetId([
                'name' => $validatedData['oname'],
                'address' => $validatedData['oaddress'],
                'state' => $validatedData['ostate'],
                'email' => $validatedData['email'],
                'org_type' => $orgType->type,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert into the organization_user table
            DB::table('organization_user')->insert([
                'user_id' => $user,
                'organization_id' => $organization,
                'role_id' => 2,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Session::put('user_id', $user);

            // Log email sending
            $logData = [
                'email_type' => 'REGISTER ORGANIZATION',
                'recipient_email' => $validatedData['email'],
                'from_email' => 'admin@xbug.online',
                'name' => $validatedData['fullname'],
                'status' => 'SUCCESS',
                'response_data' => 'Verification code sent',
                'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
            ];

            DB::table('email_logs')->insert($logData);
            DB::commit();

            // Send verification email
            Mail::to($validatedData['email'])->send(new VerificationCodeMail($validatedData['fullname'], $verificationCode));

            return redirect(route('viewVerify'))->with('success', 'Registration successful. Please check your Inbox or Spam folder for the verification code to activate your account.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Log email sending failure
            $logData = [
                'email_type' => 'REGISTER ORGANIZATION',
                'recipient_email' => $validatedData['email'],
                'from_email' => 'admin@xbug.online',
                'name' => $validatedData['fullname'],
                'status' => 'FAILED',
                'response_data' => 'ERROR: ' . $e->getMessage(),
                'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
            ];

            DB::table('email_logs')->insert($logData);

            return back()->withError('An error occurred: ' . $e->getMessage());
        }
    }

    public function createContentCreatorRegister(Request $request)
    {
        $validatedData = $request->validate([
            'icno' => 'required|digits:12|unique:users',
            'fullname' => 'required',
            'email' => [
                'required',
                'email',
                // Rule::unique('organization', 'email'),
                Rule::unique('users', 'email'),
            ],
            'phoneno' => 'required',
            'password' => 'required|min:5',
            'cpassword' => 'required|min:5|same:password',
            'address' => 'required',
            'state' => 'required|exists:states,name',

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


        $response = $request->input('g-recaptcha-response');
        $secretKey = env('RECAPTCHA_SECRET_KEY');

        $verifyResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $response,
        ]);

        $verifyResult = $verifyResponse->json();

        // dd($verifyResult);

        if (!$verifyResult['success']) {
            return back()->with(['error' => 'Please verify that you are not a robot.']);
        }

        $validatedData['password'] = bcrypt(($validatedData['password']));
        $validatedData['phoneno'] = '+60' . $validatedData['phoneno'];

        DB::beginTransaction();
        try {
            $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $user = DB::table('users')->insertgetId([
                'name' => $validatedData['fullname'],
                'password' => $validatedData['password'],
                'telno' => $validatedData['phoneno'],
                'icNo' => $validatedData['icno'],
                'email' => $validatedData['email'],
                'address' => $validatedData['address'],
                'state' => $validatedData['state'],
                'status' => 'ACTIVE',
                'role' => json_encode([3]),
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
                'role_id' => 3,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            Session::put('user_id', $user);

            $logData = [
                'email_type' => 'REGISTER CONTENT CREATOR',
                'recipient_email' => $validatedData['email'],
                'from_email' => 'admin@xbug.online',
                'name' => $validatedData['fullname'],
                'status' => 'SUCCESS',
                'response_data' => 'Verification code send',
                'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
            ];

            DB::table('email_logs')->insert($logData);
            DB::commit();
            Mail::to($validatedData['email'])->send(new VerificationCodeMail($validatedData['fullname'], $verificationCode));

            return redirect(route('viewVerify'))->with('success', 'Registration successfull. Please check your Inbox or Spam email to get verification code to active your account');
        } catch (Exception $e) {
            DB::rollBack();
            $logData = [
                'email_type' => 'REGISTER CONTENT CREATOR',
                'recipient_email' => $validatedData['email'],
                'from_email' => 'admin@xbug.online',
                'name' => $validatedData['fullname'],
                'status' => 'FAILED',
                'response_data' => 'ERROR',
                'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
            ];

            DB::table('email_logs')->insert($logData);
            return back()->withError('Error EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    }
    // public function login(Request $request)
    // {
    //     // dd($request->all());
    //     $validatedData =  $request->validate([
    //         'email' => 'required',
    //         'password' => 'required|min:5',
    //     ]);

    //     $response = $request->input('g-recaptcha-response');
    //     $secretKey = env('RECAPTCHA_SECRET_KEY');

    //     $verifyResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
    //         'secret' => $secretKey,
    //         'response' => $response,
    //     ]);

    //     $verifyResult = $verifyResponse->json();


    //     if (!$verifyResult['success']) {
    //         return back()->with(['error' => 'Please verify that you are not a robot.']);
    //     }

    //     $user = \App\Models\User::where('email', $validatedData['email'])->first();

    //     // Check if the user exists
    //     if (!$user) {
    //         return back()->with('error', 'Invalid credentials. Please make sure your email and password is correct');
    //     }

    //     // Replace $2b$ with $2y$ in the stored password hash for compatibility
    //     $userPasswordHash = str_replace('$2b$', '$2y$', $user->password);
    //     $userPasswordHash = str_replace('$2a$', '$2y$', $userPasswordHash);

    //     // Verify the password using Hash::check
    //     if (Hash::check($validatedData['password'], $userPasswordHash)) {
    //         Auth::login($user);

    //         // Check if the user's email is not verified
    //         if ($user->email_status === "NOT VERIFY") {
    //             Session::put('user_id', $user->id);
    //             $maskedEmail = $this->maskEmail($user->email);
    //             return back()->with(
    //                 'error',
    //                 'Your account is not verified by email. <a class="fw-bold text-danger" href="' . route('resendVerify') . '">Click here</a> to get the verification code via email ' . $maskedEmail
    //             );
    //         }
    //         if ($user->email_status === null) {
    //             return back()->with(
    //                 'error',
    //                 'Your account is not verified by email and dont have email registered with us. contact us at [help-center@xbug.online] if this is a mistake.'
    //             );
    //         }

    //         // Check if the user is blocked
    //         if ($user->active !== 1) {
    //             return back()->with('error', 'Your account is blocked. Please contact us at [help-center@xbug.online] if this is a mistake.');
    //         }

    //         // Store user roles in the session
    //         Session::put('user_roles', json_encode($user->role));

    //         // Redirect based on user roles
    //         $roles = json_decode($user->role, true);

    //         if (in_array(1, $roles)) {
    //             return redirect('/admin/dashboard');
    //         } elseif (in_array(2, $roles)) {
    //             return redirect('/organization/dashboard');
    //         } elseif (in_array(3, $roles)) {
    //             return redirect('/content-creator/dashboard');
    //         } elseif (in_array(5, $roles)) {
    //             return back()->with('error', ' <span class="fw-bold">Your account is not for Web User. Please contact us at [help-center@xbug.online] to add you for new role for web</span>');
    //         }
    //     } else {
    //         return back()->with('error', 'Invalid credentials. Please make sure your email and password is correct');
    //     }
    // }

    public function login(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required|min:5',
        ]);

        // Get the Turnstile response from the form
        $response = $request->input('cf-turnstile-response');
        $secretKey = env('CLOUDFLARE_TURNSTILE_SECRET_KEY'); // Add your Turnstile secret key to the .env file

        // Get the user's IP address (optional)
        $ip = $request->ip();

        // Call the Cloudflare Turnstile siteverify API
        $verifyResponse = Http::asJson()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => $secretKey,
            'response' => $response,
            'remoteip' => $ip,
        ]);

        $verifyResult = $verifyResponse->json();

        // Check if Turnstile verification was successful
        if (!$verifyResult['success']) {
            return back()->with(['error' => 'Please verify that you are not a robot.']);
        }

        // Find the user by email
        $user = \App\Models\User::where('email', $validatedData['email'])->first();

        // Check if the user exists
        if (!$user) {
            return back()->with('error', 'Invalid credentials. Please make sure your email and password is correct');
        }

        // Replace $2b$ with $2y$ in the stored password hash for compatibility
        $userPasswordHash = str_replace(['$2b$', '$2a$'], '$2y$', $user->password);

        // Verify the password using Hash::check
        if (Hash::check($validatedData['password'], $userPasswordHash)) {
            Auth::login($user);

            // Check if the user's email is not verified
            if ($user->email_status === "NOT VERIFY") {
                Session::put('user_id', $user->id);
                $maskedEmail = $this->maskEmail($user->email);
                return back()->with(
                    'error',
                    'Your account is not verified by email. <a class="fw-bold text-danger" href="' . route('resendVerify') . '">Click here</a> to get the verification code via email ' . $maskedEmail
                );
            }
            if ($user->email_status === null) {
                return back()->with(
                    'error',
                    'Your account is not verified by email and doesn\'t have an email registered with us. Contact us at [help-center@xbug.online] if this is a mistake.'
                );
            }

            // Check if the user is blocked
            if ($user->active !== 1) {
                return back()->with('error', 'Your account is blocked. Please contact us at [help-center@xbug.online] if this is a mistake.');
            }

            // Store user roles in the session
            Session::put('user_roles', json_encode($user->role));

            // Redirect based on user roles
            $roles = json_decode($user->role, true);

            if (in_array(1, $roles)) {
                return redirect('/admin/dashboard');
            } elseif (in_array(2, $roles)) {
                return redirect('/organization/dashboard');
            } elseif (in_array(3, $roles)) {
                return redirect('/content-creator/dashboard');
            } elseif (in_array(5, $roles)) {
                return back()->with('error', ' <span class="fw-bold">Your account is not for Web User. Please contact us at [help-center@xbug.online] to add you for a new role for web</span>');
            }
        } else {
            return back()->with('error', 'Invalid credentials. Please make sure your email and password is correct');
        }
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
        DB::beginTransaction();
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
            $logData = [
                'email_type' => 'RESEND CODE EMAIL',
                'recipient_email' => $user->email,
                'from_email' => 'admin@xbug.online',
                'name' => $user->name,
                'status' => 'SUCCESS',
                'response_data' => 'Resend code has been sent',
                'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
            ];

            DB::table('email_logs')->insert($logData);
            DB::commit();
            Mail::to($user->email)->send(new ResendVerificationCodeMail($user->name, $verificationCode));

            return redirect(route('viewVerify'))->with('success', 'Resend code successfull. Please check your Inbox or Spam email to get verification code to active your account');
        } catch (\Exception $e) {
            DB::rollBack();
            $logData = [
                'email_type' => 'RESEND CODE EMAIL',
                'recipient_email' => $user->email,
                'from_email' => 'admin@xbug.online',
                'name' => $user->name,
                'status' => 'FAILED',
                'response_data' => 'ERROR',
                'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
            ];

            DB::table('email_logs')->insert($logData);
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
    // public function resetPassword(Request $request)
    // {
    //     // dd($request->all());
    //     $validator = $request->validate([
    //         'emailResetPassword' => 'required|email|exists:users,email',
    //     ], [
    //         'emailResetPassword.required' => 'Please fill the email address.',
    //         'emailResetPassword.email' => 'Please enter a valid email address.',
    //         'emailResetPassword.exists' => 'This email does not exist in our records.',
    //     ], []);

    //     $response = $request->input('g-recaptcha-response');
    //     $secretKey = env('RECAPTCHA_SECRET_KEY');

    //     $verifyResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
    //         'secret' => $secretKey,
    //         'response' => $response,
    //     ]);

    //     $verifyResult = $verifyResponse->json();


    //     if (!$verifyResult['success']) {
    //         return back()->with(['error' => 'Please verify that you are not a robot.']);
    //     }

    //     DB::beginTransaction();
    //     try {
    //         $user = DB::table('users')->where('email', $validator['emailResetPassword'])->first();

    //         if (!$user) {
    //             return back()->with('error', 'This email does not exist in our records. Please make sure your email address is valid');
    //         }
    //         Session::put('user_email', $validator['emailResetPassword']);
    //         $password = Str::random(6);
    //         DB::table('users')->where('email', $validator['emailResetPassword'])->update([
    //             'password' => bcrypt($password)
    //         ]);

    //         $logData = [
    //             'email_type' => 'RESET PASSWORD CODE EMAIL',
    //             'recipient_email' => $user->email,
    //             'from_email' => 'admin@xbug.online',
    //             'name' => $user->name,
    //             'status' => 'SUCCESS',
    //             'response_data' => 'RESET PASSWORD SEND',
    //             'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
    //             'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
    //         ];

    //         DB::table('email_logs')->insert($logData);
    //         DB::commit();
    //         Mail::to($user->email)->send(new ResetPasswordMail($user->name, $password));
    //         return back()->with('success', 'Password reset successfully. A new password has been sent to your email. Use it to login. You can change later when you login into your account. If You dont recieve a email, click resend email');
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         $logData = [
    //             'email_type' => 'RESET PASSWORD CODE EMAIL',
    //             'recipient_email' => $user->email,
    //             'from_email' => 'admin@xbug.online',
    //             'name' => $user->name,
    //             'status' => 'FAILED',
    //             'response_data' => 'ERROR',
    //             'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
    //             'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
    //         ];

    //         DB::table('email_logs')->insert($logData);
    //         return back()->withError('Error EDE' . $e->getLine() . ' : ' . $e->getMessage());
    //     }
    // }
    public function resetPassword(Request $request)
    {
        // Validate input
        $validator = $request->validate([
            'emailResetPassword' => 'required|email|exists:users,email',
        ], [
            'emailResetPassword.required' => 'Please fill the email address.',
            'emailResetPassword.email' => 'Please enter a valid email address.',
            'emailResetPassword.exists' => 'This email does not exist in our records.',
        ]);

        // Get the Turnstile response from the form
        $response = $request->input('cf-turnstile-response');
        $secretKey = env('CLOUDFLARE_TURNSTILE_SECRET_KEY'); // Add your Turnstile secret key to the .env file

        // Get the user's IP address (optional)
        $ip = $request->ip();

        // Call the Cloudflare Turnstile siteverify API
        $verifyResponse = Http::asJson()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => $secretKey,
            'response' => $response,
            'remoteip' => $ip,
        ]);

        $verifyResult = $verifyResponse->json();

        // Check if Turnstile verification was successful
        if (!$verifyResult['success']) {
            return back()->with(['error' => 'Please verify that you are not a robot.']);
        }

        // Begin transaction
        DB::beginTransaction();
        try {
            $user = DB::table('users')->where('email', $validator['emailResetPassword'])->first();

            if (!$user) {
                return back()->with('error', 'This email does not exist in our records. Please make sure your email address is valid');
            }

            // Generate a random password and update the user record
            Session::put('user_email', $validator['emailResetPassword']);
            $password = Str::random(6);
            DB::table('users')->where('email', $validator['emailResetPassword'])->update([
                'password' => bcrypt($password),
            ]);

            // Log the email sending process
            $logData = [
                'email_type' => 'RESET PASSWORD CODE EMAIL',
                'recipient_email' => $user->email,
                'from_email' => 'admin@xbug.online',
                'name' => $user->name,
                'status' => 'SUCCESS',
                'response_data' => 'RESET PASSWORD SENT',
                'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
            ];

            DB::table('email_logs')->insert($logData);

            // Commit transaction
            DB::commit();

            // Send the reset password email
            Mail::to($user->email)->send(new ResetPasswordMail($user->name, $password));

            return back()->with('success', 'Password reset successfully. A new password has been sent to your email. Use it to login. You can change later when you login into your account. If you don\'t receive an email, click resend email.');
        } catch (Exception $e) {
            // Rollback transaction in case of error
            DB::rollBack();

            // Log the failed email process
            $logData = [
                'email_type' => 'RESET PASSWORD CODE EMAIL',
                'recipient_email' => $user->email ?? 'unknown',
                'from_email' => 'admin@xbug.online',
                'name' => $user->name ?? 'unknown',
                'status' => 'FAILED',
                'response_data' => 'ERROR: ' . $e->getMessage(),
                'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
            ];

            DB::table('email_logs')->insert($logData);

            return back()->withError('An error occurred: ' . $e->getMessage());
        }
    }

    public function resendResetPassword(Request $request)
    {

        DB::beginTransaction();
        try {
            $userId = Session::get('user_email');


            if (!$userId) {
                return back()->with('error', 'Your session has expired, please login to get new verification code - 1');
            }

            $user = DB::table('users')->where('email', $userId)->first();
            // dd($user);


            if (!$user) {
                return back()->with('error', 'This email does not exist in our records. Please make sure your email address is valid - 2');
            }


            $password = Str::random(6);
            DB::table('users')->where('email', $userId)->update([
                'password' => bcrypt($password)
            ]);
            $logData = [
                'email_type' => 'RESEND RESET PASSWORD CODE EMAIL',
                'recipient_email' => $user->email,
                'from_email' => 'admin@xbug.online',
                'name' => $user->name,
                'status' => 'SUCCESS',
                'response_data' => 'Resend reset password send',
                'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
            ];

            DB::table('email_logs')->insert($logData);
            DB::commit();
            Mail::to($user->email)->send(new ResetPasswordMail($user->name, $password));
            return back()->with('success', 'Password has been resend, Check Your Inbox or Spam email to get the new password. If You dont recieve a email, click resend email');
        } catch (\Exception $e) {
            DB::rollBack();
            $logData = [
                'email_type' => 'RESEND RESET PASSWORD CODE EMAIL',
                'recipient_email' => $user->email,
                'from_email' => 'admin@xbug.online',
                'name' => $user->name,
                'status' => 'FAILED',
                'response_data' => 'ERROR',
                'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
            ];

            DB::table('email_logs')->insert($logData);
            return back()->with('error', 'There was an error sending the email reset password. Please try again later. Error: ' . $e->getMessage());
        }
    }

    public function viewOrganizationRegisterUser(Request $request, $data)
    {
        try {
            $organization_type = DB::table('organization_type')->select('id', 'type')->get();
            $state = DB::table('states')->select('id', 'name')->get();
            $decryptedData = Crypt::decrypt($data);

            list($icNo, $name) = explode('|', $decryptedData);
            return view('auth.organization-register-user', [
                'organization_types' => $organization_type,
                'states' => $state,
                'noPengenalan' => $icNo,
                'name' => $name
            ]);
        } catch (Exception $e) {
            return back()->with('error', 'Please dont change the url! Your action will recorded');
        }
    }
    public function viewContentCreatorRegisterUser(Request $request, $data)
    {
        try {
            $organization_type = DB::table('organization_type')->select('id', 'type')->get();
            $state = DB::table('states')->select('id', 'name')->get();
            $decryptedData = Crypt::decrypt($data);

            list($icNo, $name) = explode('|', $decryptedData);
            return view('auth.content-creator-register-user', [
                'organization_types' => $organization_type,
                'states' => $state,
                'noPengenalan' => $icNo,
                'name' => $name
            ]);
        } catch (Exception $e) {
            return back()->with('error', 'Please dont change the url! Your action will recorded');
        }
    }
    // public function verifyUserOrganization(Request $request)
    // {

    //     $validatedData = $request->validate([
    //         'icNo' => 'required|digits:12',
    //     ], [], [
    //         'icNo' => 'Identity Number',
    //     ]);

    //     $response = $request->input('g-recaptcha-response');
    //     $secretKey = env('RECAPTCHA_SECRET_KEY');

    //     $verifyResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
    //         'secret' => $secretKey,
    //         'response' => $response,
    //     ]);

    //     $verifyResult = $verifyResponse->json();


    //     if (!$verifyResult['success']) {
    //         return back()->with(['error' => 'Please verify that you are not a robot.']);
    //     }

    //     $noPengenalan = $validatedData['icNo'];

    //     $user = DB::table('users')->where('icNo', $noPengenalan)->first();

    //     if ($user) {
    //         return back()->with('error', 'Your Identity Number is already registered. Please contact us at [help-center@xbug.online] for further assistance.');
    //     }

    //     $apiUrl = env('EKYC_VERIFY_USER_API');
    //     // dd($apiUrl);

    //     try {

    //         $response = Http::post($apiUrl, [
    //             'noPengenalan' => $noPengenalan,
    //         ]);
    //         if ($response->successful()) {
    //             $apiData = $response->json();
    //             $combinedData = $noPengenalan . '|' . $apiData['name'];
    //             $encryptedData = Crypt::encrypt($combinedData);
    //             return redirect()->route('viewOrganizationRegisterUser', ['data' => $encryptedData]);
    //         } else {
    //             $apiData = $response->json();
    //             if ($apiData['error'] === 'TOO MANY REQUESTS, PLEASE TRY AGAIN LATER AFTER 10 MINUTES.') {
    //                 return back()->with('error', $apiData['error']);
    //             } else {
    //                 return back()->with('error', 'Your Identity Number is not valid. Please contact us at [help-center@xbug.online] for further assistance.');
    //             }
    //         }
    //     } catch (\Exception $e) {

    //         return back()->with('error', 'Something went wrong. Please try again or contact us at [help-center@xbug.online]' . $e->getMessage());
    //     }
    // }
    public function verifyUserOrganization(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'icNo' => 'required|digits:12',
        ], [], [
            'icNo' => 'Identity Number',
        ]);

        // Get the Turnstile response from the form
        $response = $request->input('cf-turnstile-response');
        $secretKey = env('CLOUDFLARE_TURNSTILE_SECRET_KEY'); // Add your Turnstile secret key to the .env file

        // Get the user's IP address (optional)
        $ip = $request->ip();

        // Call the Cloudflare Turnstile siteverify API
        $verifyResponse = Http::asJson()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => $secretKey,
            'response' => $response,
            'remoteip' => $ip,
        ]);

        $verifyResult = $verifyResponse->json();

        // Check if Turnstile verification was successful
        if (!$verifyResult['success']) {
            return back()->with(['error' => 'Please verify that you are not a robot.']);
        }

        // Get the Identity Number
        $noPengenalan = $validatedData['icNo'];

        // Check if the Identity Number is already registered
        $user = DB::table('users')->where('icNo', $noPengenalan)->first();

        if ($user) {
            return back()->with('error', 'Your Identity Number is already registered. Please contact us at [help-center@xbug.online] for further assistance.');
        }

        // Call the external eKYC API
        $apiUrl = env('EKYC_VERIFY_USER_API');

        try {
            $response = Http::post($apiUrl, [
                'noPengenalan' => $noPengenalan,
            ]);

            if ($response->successful()) {
                $apiData = $response->json();
                $combinedData = $noPengenalan . '|' . $apiData['name'];
                $encryptedData = Crypt::encrypt($combinedData);

                return redirect()->route('viewOrganizationRegisterUser', ['data' => $encryptedData]);
            } else {
                $apiData = $response->json();
                if (isset($apiData['error']) && $apiData['error'] === 'TOO MANY REQUESTS, PLEASE TRY AGAIN LATER AFTER 10 MINUTES.') {
                    return back()->with('error', $apiData['error']);
                } else {
                    return back()->with('error', 'Your Identity Number is not valid. Please contact us at [help-center@xbug.online] for further assistance.');
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again or contact us at [help-center@xbug.online]. Error: ' . $e->getMessage());
        }
    }

    public function verifyUserContentCretor(Request $request)
    {
        // dd($request->all());

        $validatedData = $request->validate([
            'icNo' => 'required|digits:12',
        ], [], [
            'icNo' => 'Identity Number',
        ]);

        $response = $request->input('g-recaptcha-response');
        $secretKey = env('RECAPTCHA_SECRET_KEY');

        $verifyResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $response,
        ]);

        $verifyResult = $verifyResponse->json();


        if (!$verifyResult['success']) {
            return back()->with(['error' => 'Please verify that you are not a robot.']);
        }

        $noPengenalan = $validatedData['icNo'];

        $apiUrl = env('EKYC_VERIFY_USER_API');

        $user = DB::table('users')->where('icNo', $noPengenalan)->first();

        if ($user) {
            return back()->with('error', 'Your Identity Number is already registered. Please contact us at [help-center@xbug.online] for further assistance.');
        }

        try {

            $response = Http::post($apiUrl, [
                'noPengenalan' => $noPengenalan,
            ]);

            if ($response->successful()) {
                $apiData = $response->json();
                $combinedData = $noPengenalan . '|' . $apiData['name'];
                $encryptedData = Crypt::encrypt($combinedData);
                return redirect()->route('viewContentCreatorRegisterUser', ['data' => $encryptedData]);
            } else {
                $apiData = $response->json();
                if ($apiData['error'] === 'TOO MANY REQUESTS, PLEASE TRY AGAIN LATER AFTER 10 MINUTES.') {
                    return back()->with('error', $apiData['error']);
                } else {
                    return back()->with('error', 'Your Identity Number is not valid. Please contact us at [help-center@xbug.online] for further assistance.');
                }
            }
        } catch (\Exception $e) {

            return back()->with('error', 'Something went wrong. Please try again or contact us at [help-center@xbug.online]' . $e->getMessage());
        }
    }
}
