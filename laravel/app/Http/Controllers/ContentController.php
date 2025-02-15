<?php

namespace App\Http\Controllers;

use App\Mail\ContentNotificationMail;
use App\Models\Label;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Mail\ResetPasswordMail;
use App\Mail\VerifyActionMail;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Content;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{
    /**
     * Show the promotion content page with the content details.
     *
     * @param int $id Content ID
     * @return \Illuminate\View\View
     */

    public function guest(Request $request, $card_id)
    {
        $state = DB::table('states')->select('id', 'name')->get();
        $content = DB::table('content_card')
            ->join('contents', 'content_card.content_id', '=', 'contents.id')->where('card_id', $card_id)->first();
        return view('content_interaction.guest', [
            'states' => $state,
            'content' => $content
        ]);
    }
    public function registerGuestContent(Request $request, $card_id)
    {

        $validatedData = $request->validate([
            'fullname' => 'required',
            'phoneno' => 'required',
            'address' => 'required',
            'state' => 'required|exists:states,name',
        ], [
            'state.in' => 'The selected state is invalid. Please choose a valid state.',
        ], [
            'fullname' => 'Full Name',
            'phoneno' => 'Phone Number',
            'address' => 'Organization Address',
            'state' => 'Organization state',
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

        $password1 = Str::random(16);
        $password = bcrypt($password1);

        DB::beginTransaction();
        $user = 0;
        try {
            $enroll_id = DB::table('interaction_type')->where('type', 'enrolled')->first();
            if (!DB::table('users')->where('email', $request->input('email'),)->exists()) {
                $user = DB::table('users')->insertGetId([
                    'name' => $validatedData['fullname'],
                    'password' => $password,
                    'telno' => $validatedData['phoneno'],
                    'icNo' => $request->input('icno'),
                    'address' => $validatedData['address'],
                    'state' => $validatedData['state'],
                    'email' => $request->input('email'),
                    'status' => 'ACTIVE',
                    'role' => json_encode([5]),
                    'active' => 1,
                    'email_status' => 'VERIFY',

                ]);

                $user = DB::table('users')->where('email', $request->input('email'))->first();

                $content = DB::table('content_card')
                    ->join('contents', 'content_card.content_id', '=', 'contents.id')->where('content_card.card_id', $card_id)->first();


                // dd($content,$card_id);
                $checkUser = DB::table('user_content')->where('user_id', $user->id)->where('content_id', $content->content_id)->where('status', 1)->where('interaction_type_id', $enroll_id->id)->first();
                if ($checkUser) {
                    return back()->with('error', 'You have already registered for this content');
                }

                $userDetails = DB::table('user_content')->insertGetId([
                    'user_id' => $user->id,
                    'interaction_type_id' =>  3,
                    'status' => 1,
                    'content_id' => $content->content_id,
                    'ip_address' => $request->ip(),
                    //'verification_code' => $content->verification_code,

                ]);

                $logData = [
                    'email_type' => 'REGISTER GUEST CONTENT',
                    'recipient_email' => $request->input('email'),
                    'from_email' => 'admin@xbug.online',
                    'name' => $validatedData['fullname'],
                    'status' => 'SUCCESS',
                    'response_data' => 'Verification code has been sent',

                ];



                DB::table('email_logs')->insert($logData);
                DB::commit();

                Mail::to($request->input('email'))->send(new ResetPasswordMail($validatedData['fullname'], $password1));
                return back()->with('success', 'Registration successfull. Your record has been saved and we has been created your account. Please check your email for password xBUG app');
            } else {
                $user = DB::table('users')->where('email', $request->input('email'),)->first();

                if (!$user || $user->status !== 'ACTIVE' || $user->active !== 1 || $user->email_status !== 'VERIFY') {
                    return back()->withError('We detected your account is suspended or not verified. Please check your email to verify your account and continue with xBUG app.');
                }

                $content = DB::table('content_card')
                    ->join('contents', 'content_card.content_id', '=', 'contents.id')->where('content_card.card_id', $card_id)->first();


                // dd($content,$card_id);
                $checkUser = DB::table('user_content')->where('user_id', $user->id)->where('content_id', $content->content_id)->where('status', 1)->where('interaction_type_id', $enroll_id->id)->first();
                if ($checkUser) {
                    return back()->with('error', 'You have already registered for this content');
                }

                $userDetails = DB::table('user_content')->insertGetId([
                    'user_id' => $user->id,
                    'interaction_type_id' =>  3,
                    'status' => 0,
                    'content_id' => $content->content_id,
                    'ip_address' => $request->ip(),
                    'token' => Str::random(20),
                    //'verification_code' => $content->verification_code,

                ]);

                $userContent = DB::table('user_content')->where('id', $userDetails)->first();

                // Generate the token with a timestamp containing only digits
                $timestamp = Carbon::parse($userContent->updated_at)->format('YmdHis'); // Convert timestamp to 'YYYYMMDDHHMMSS' format
                $token = $userContent->token . '-' . $timestamp;
                $logData = [
                    'email_type' => 'REGISTER GUEST CONTENT - ACTION',
                    'recipient_email' => $request->input('email'),
                    'from_email' => 'admin@xbug.online',
                    'name' => $validatedData['fullname'],
                    'status' => 'SUCCESS',
                    'response_data' => 'Verification code has been sent',

                ];



                DB::table('email_logs')->insert($logData);
                DB::commit();
                Mail::to($request->input('email'))->send(new VerifyActionMail($token));

                return back()->with('success', 'We detected you have registered account with us. Please check on your email inbox for further action.');
            }

            return back()->withError('We detected you have registered account with us. Please check your email for password xBUG app and continue with xBUG app');
            // $user = DB::table('users')->where('email',$request->input('email') )->first();

            // $content = DB::table('content_card')
            // ->join('contents', 'content_card.content_id', '=', 'contents.id')->where('card_id', $card_id)->first();

            // $checkUser = DB::table('user_content')->where('user_id', $user->id)->where('content_id', $content->content_id)->first();
            // if ($checkUser) {
            //     return back()->with('error', 'You have already registered for this content');
            // }

            // $userDetails = DB::table('user_content')->insertGetId([
            //     'user_id' => $user->id,
            //     'interaction_type_id' =>  3,
            //     'status' => 1,
            //     'content_id' => $content->content_id,
            //     'ip_address' => $request->ip(),
            //     'verification_code' => $content->verification_code,
            //     'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
            //     'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
            // ]);

            // $logData = [
            //     'email_type' => 'REGISTER GUEST CONTENT',
            //     'recipient_email' => $request->input('email'),
            //     'from_email' => 'admin@xbug.online',
            //     'name' => $validatedData['fullname'],
            //     'status' => 'SUCCESS',
            //     'response_data' => 'Verification code has been sent',
            //     'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
            //     'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
            // ];



            // DB::table('email_logs')->insert($logData);
            // DB::commit();


            // return back()->with('success', 'Registration successfull. Your record has been saved.');
        } catch (\Exception $e) {
            DB::rollBack();
            $logData = [
                'email_type' => 'REGISTER GUEST CONTENT',
                'recipient_email' => $request->input('email'),
                'from_email' => 'admin@xbug.online',
                'name' => $validatedData['fullname'],
                'status' => 'FAILED',
                'response_data' => 'ERROR',

            ];

            DB::table('email_logs')->insert($logData);
            return back()->withError('Error EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    }

    public function verifyAction(Request $request)
    {
        $token = $request->query('token');
        if (!$token) {
            return view('verify')->with([
                'message' => 'Token is missing.',
                'status' => 'error'
            ]);
        }

        // Extract token and timestamp
        $parts = explode('-', $token);
        if (count($parts) !== 2) {
            return view('verify')->with([
                'message' => 'Invalid token format.',
                'status' => 'error'
            ]);
        }

        $rawToken = $parts[0];
        $timestamp = $parts[1];

        // Find the user_content record by token
        $userContent = DB::table('user_content')->where('token', $rawToken)->first();

        if (!$userContent) {
            return view('verify')->with([
                'message' => 'Token expired.',
                'status' => 'error'
            ]);
        }

        // Validate timestamp
        $expectedTimestamp = Carbon::parse($userContent->updated_at)->format('YmdHis');
        if ($expectedTimestamp !== $timestamp) {
            return view('verify')->with([
                'message' => 'Token expired.',
                'status' => 'error'
            ]);
        }

        // Update the status to 1
        try {
            DB::table('user_content')->where('id', $userContent->id)->update(['status' => 1]);
        } catch (\Exception $e) {
            return view('verify')->with([
                'message' => 'Failed to update status.',
                'status' => 'error'
            ]);
        }

        return view('verify')->with([
            'message' => 'Enrollment into the event was successful.',
            'status' => 'success'
        ]);
    }
    // public function verifyAction(Request $request)
    // {
    //     $token = $request->query('token');
    //     if (!$token) {
    //         return response()->json('Token is missing.');
    //     }

    //     // Extract token and timestamp
    //     $parts = explode('-', $token);
    //     if (count($parts) !== 2) {
    //         return response()->json('Invalid token format.');
    //     }

    //     $rawToken = $parts[0];
    //     $timestamp = $parts[1];

    //     // Find the user_content record by token
    //     $userContent = DB::table('user_content')->where('token', $rawToken)->first();

    //     if (!$userContent) {
    //         return response()->json('Token expired.');
    //     }

    //     // Validate timestamp
    //     $expectedTimestamp = Carbon::parse($userContent->updated_at)->format('YmdHis');
    //     if ($expectedTimestamp !== $timestamp) {
    //         return response()->json('Token expired.');
    //     }

    //     // Update the status to 1
    //     try {
    //         DB::table('user_content')->where('id', $userContent->id)->update(['status' => 1]);
    //     } catch (\Exception $e) {
    //         return response()->json('Failed to update status.');
    //     }

    //     return response()->json('Enrollment into the event was successful.');
    // }

    public function showPromoteContent($id)
    {

        $stateCitiesJson = file_get_contents(public_path('assets/json/states-cities.json'));
        $stateCities = json_decode($stateCitiesJson, true);

        // Fetch id and name from the table
        // Fetch the content by ID
        $content = DB::table('contents')->where('id', $id)->first();

        // Check if content exists, otherwise return an error or redirect
        if (!$content) {
            return redirect()->back()->with('error', 'Content not found.');
        }

        // Pass the specific content to the view
        return view('organization.contentManagement.promoteContent', [
            'content' => $content,
            'stateCities' => $stateCities
        ]);
    }

    public function addContent(Request $request)
    {
        $user = Auth::user();

        $org = DB::table('organization_user')
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->first();



        // Validate form inputs
        $validated = $request->validate([
            'content_name' => 'required|string|max:255|not_regex:/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F77F}\x{1F780}-\x{1F7FF}\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FA6F}\x{1FA70}-\x{1FAFF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}\x{FE00}-\x{FE0F}\x{1F1E0}-\x{1F1FF}]/u',
            'content_desc' => 'required|string|not_regex:/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F77F}\x{1F780}-\x{1F7FF}\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FA6F}\x{1FA70}-\x{1FAFF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}\x{FE00}-\x{FE0F}\x{1F1E0}-\x{1F1FF}]/u',
            'content_link' => 'required|url',
            'enrollment_price' => 'required|numeric|min:0',
            'place' => 'required|string|max:255',
            'participant_limit' => 'required|integer',
            'state' => 'required',
            'content_type_id' => 'required|exists:content_types,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'state' => ', Please select at least 1 state',
        ], [
            'content_name.not_regex' => 'Try not to insert any emojis to the title field.',
            'content_desc.not_regex' => 'Try not to insert any emojis to the description field.',
        ], [
            'content_type_id' => 'Content Type'
        ]);

        $labels = explode(",", $request->labelIds);
        $weight = $this->calVectorByLabel($labels);

        $imagePath = $request->file('image')->store('public/asset1/images'); // Save the file
        $imageUrl = str_replace('public/', '', $imagePath); // Generate the relative URL

        try {
            DB::transaction(function () use ($validated, $labels, $weight, $user, $org, $request, $imageUrl) {
                // Insert data into the contents table
                $content_id = DB::table('contents')->insertGetId([
                    'name' => $validated['content_name'],
                    'desc' => $validated['content_desc'],
                    'link' => $validated['content_link'],
                    'enrollment_price' => $validated['enrollment_price'],
                    'place' => $validated['place'],
                    'participant_limit' => $validated['participant_limit'],
                    'state' => json_encode([$validated['state']]),
                    'content_type_id' => $validated['content_type_id'],
                    'user_id' => $user->id,
                    'org_id' => $org->organization_id,
                    'reason_phrase' => 'PENDING',
                    'category_weight' => json_encode($weight),
                    'image' => $imageUrl
                ]);

                foreach ($labels as $l) {
                    $exist = DB::table('labels')->where('id', $l)->exists();
                    if ($exist) {
                        DB::table('content_label')->insert([
                            'content_id' => $content_id,
                            'label_id' => $l,
                        ]);
                    }
                }
                $email_status = DB::table('email_status')->where('email', 'admin@xbug.online')->first();
                if ($email_status && $email_status->status == 1) {
                    $status = 1;
                    $reject_reason = null;
                    $name = $user->name;

                    $logData = [
                        'email_type' => 'APPLY CONTENT - PENDING',
                        'recipient_email' => $user->email,
                        'from_email' => 'admin@xbug.online',
                        'name' => $user->name,
                        'status' => 'SUCCESS',
                        'response_data' => 'MESSAGE PENDING SEND',
                        'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                        'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                    ];

                    DB::table('email_logs')->insert($logData);

                    Mail::mailer('smtp')->to($user->email)->send(new ContentNotificationMail($status, $reject_reason, $name, $validated['content_name']));
                }
            });

            return back()->with('success', 'Your Content Is Applied Successfully!');
        } catch (Exception $e) {

            $logData = [
                'email_type' => 'APPLY CONTENT - PENDING',
                'recipient_email' => $user->email,
                'from_email' => 'admin@xbug.online',
                'name' => $user->name,
                'status' => 'FAILED',
                'response_data' => 'ERROR',
                'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
            ];

            DB::table('email_logs')->insert($logData);

            return back()->with('error', 'ERROR: ' . $e->getMessage());
        }
    }

    public function approveContent($id)
    {

        try {
            DB::transaction(function () use ($id) {
                // Temukan konten berdasarkan ID
                $content = Content::find($id);

                if (!$content) {
                    return back()->with('error', 'Content Not Found!');
                }

                $content->reason_phrase = 'APPROVED'; // Set sebagai approved
                $content->reject_reason = null; // Hapus alasan penolakan sebelumnya jika ada
                $content->save();

                $email_status = DB::table('email_status')->where('email', 'admin@xbug.online')->first();

                // dd($user);

                if ($email_status && $email_status->status == 1) {
                    $user = DB::table('contents')
                        ->join('users', 'contents.user_id', '=', 'users.id')
                        ->where('contents.id', $id)->select('users.name', 'users.email', 'contents.name as content_name')
                        ->first();
                    $status = 2; // Status untuk email
                    $reject_reason = null; // Alasan penolakan kosong
                    $name = $user->name;

                    $logData = [
                        'email_type' => 'APPLY CONTENT - APPROVED',
                        'recipient_email' => $user->email,
                        'from_email' => 'admin@xbug.online',
                        'name' => $user->name,
                        'status' => 'SUCCESS',
                        'response_data' => 'MESSAGE APPROVE SEND',
                        'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                        'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                    ];

                    DB::table('email_logs')->insert($logData);

                    Mail::mailer('smtp')->to($user->email)->send(new ContentNotificationMail($status, $reject_reason, $name, $content->name));
                }
            });

            return redirect()->back()->with('status', 'Content approved successfully!');
        } catch (Exception $e) {
            $logData = [
                'email_type' => 'APPLY CONTENT - APPROVED',
                'recipient_email' => $user->email,
                'from_email' => 'admin@xbug.online',
                'name' => $user->name,
                'status' => 'FAILED',
                'response_data' => 'ERROR',
                'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
            ];

            DB::table('email_logs')->insert($logData);
            return back()->with('error', 'ERROR: ' . $e->getMessage());
        }
    }


    public function rejectContent(Request $request, $id)
    {
        try {
            DB::transaction(function () use ($request, $id) {
                // Find the content by ID
                $content = Content::find($id);

                if (!$content) {
                    return back()->with('error', 'Content Not Found!');
                }

                // Update the content status to 'REJECTED'
                $content->reason_phrase = 'REJECTED'; // Set content as rejected
                $content->reject_reason = $request->input('rejection_reason'); // Save the rejection reason
                $content->save();

                // Check if email notifications are enabled
                $email_status = DB::table('email_status')->where('email', 'admin@xbug.online')->first();

                if ($email_status && $email_status->status == 1) {
                    $user = DB::table('contents')
                        ->join('users', 'contents.user_id', '=', 'users.id')
                        ->where('contents.id', $id)->select('users.name', 'users.email', 'contents.name as content_name')
                        ->first();
                    $status = 3; // Status for rejection email
                    $reject_reason = $content->reject_reason; // Pass the rejection reason
                    $name = $user->name;

                    // Log email data
                    $logData = [
                        'email_type' => 'APPLY CONTENT - REJECTED',
                        'recipient_email' => $user->email,
                        'from_email' => 'admin@xbug.online',
                        'name' => $user->name,
                        'status' => 'SUCCESS',
                        'response_data' => 'MESSAGE REJECT SEND',
                        'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                        'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                    ];

                    DB::table('email_logs')->insert($logData);

                    // Send the rejection email
                    Mail::mailer('smtp')->to($user->email)->send(new ContentNotificationMail($status, $reject_reason, $name, $content->name));
                }
            });

            return redirect()->back()->with('status', 'Content rejected successfully!');
        } catch (Exception $e) {
            // Log failure in case of an error
            $logData = [
                'email_type' => 'APPLY CONTENT - REJECTED',
                'recipient_email' => $user->email,
                'from_email' => 'admin@xbug.online',
                'name' => $user->name,
                'status' => 'FAILED',
                'response_data' => 'ERROR',
                'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
            ];

            DB::table('email_logs')->insert($logData);

            return back()->with('error', 'ERROR: ' . $e->getMessage());
        }
    }


    // public function showContentType()
    // {
    //     // Fetch all active content types
    //     $content_types = DB::table('content_types')->where('status', true)->get();

    //     // Pass content types to the view
    //     return view('organization.contentManagement.applyContent', compact('content_types'));
    // }

    public function deeplink($id)
    {

        $today = now(); // Laravel helper for current date and time

        $card = DB::table('content_card as cc')
            ->join('contents as c', 'c.id', '=', 'cc.content_id')
            ->leftJoin('transactions as t', 't.id', '=', 'cc.transaction_id') // Ensure correct join key for transactions
            ->where('t.status', 'Success')
            ->where('cc.status', 1)
            ->where('c.status', 1)
            ->whereDate('cc.startdate', '<=', $today)
            ->whereDate('cc.enddate', '>=', $today)
            ->where('cc.card_id', $id)
            ->select('cc.card_id')
            ->first();
        // dd($card, $today, DB::table('content_card as cc')
        // ->join('contents as c', 'c.id', '=', 'cc.content_id')
        // ->leftJoin('transactions as t', 't.id', '=', 'cc.transaction_id') // Ensure correct join key for transactions
        // // ->where('t.status', 'Success')
        // // ->where('cc.status', 1)
        // // ->where('c.status', 1)
        // ->whereDate('cc.startdate', '<=', $today)
        // ->whereDate('cc.enddate', '>=', $today)
        // ->where('cc.card_id', $id)
        // ->select('cc.card_id')
        // ->first());
        if ($card == null) {
            abort(404);
        }


        return view('content_interaction.index', compact('card'));
    }

    private function getSum(array $targetValues, array $sourceValues): array
    {
        return array_map(function ($val, $index) use ($sourceValues) {
            return $val + ($sourceValues[$index] ?? 0);
        }, $targetValues, array_keys($targetValues));
    }

    // Function to flatten values based on weight
    private function flattenValues(array $values, float $weight): array
    {
        $totalSum = array_sum($values);
        $average = $totalSum / (count($values) ?: 1);

        return array_map(function ($v) use ($totalSum, $average, $weight) {
            $val = 0;
            if ($totalSum == 0 || $v == 0) {
                $val = 0;
            } else {
                $val = ($v / $totalSum) * $weight;
            }

            if ($v >= $average) {
                $val *= 1.5;
            } elseif ($v < $average * 0.2) {
                $val *= 0.8;
            }

            return max(min(round($val, 3), 0.999), 0.0);
        }, $values);
    }

    public function calVectorByLabel($labelIds)
    {

        //dd($labelIds);
        $initialValues = array_fill(0, 8, 0);
        $firstLabel = $initialValues;
        $secondLabel = $initialValues;

        $firstIndex = intdiv(count($labelIds), 2);

        $selectedList = array_map(function ($item) {
            $label = DB::table('labels')->select('values')->where('id', $item)->first();
            if ($label == null) {
                return array_fill(0, 8, 0);
            }
            return json_decode($label->values, true);
        }, $labelIds);

        for ($i = 0; $i < $firstIndex; $i++) {
            $firstLabel = $this->getSum($firstLabel, $selectedList[$i]);
        }

        for ($i = $firstIndex; $i < count($selectedList); $i++) {
            $secondLabel = $this->getSum($secondLabel, $selectedList[$i]);
        }

        $firstLabel = $this->flattenValues($firstLabel, 1.5);
        $secondLabel = $this->flattenValues($secondLabel, 1.0);

        $finalLabel = $this->getSum($initialValues, $firstLabel);
        $finalLabel = $this->getSum($finalLabel, $secondLabel);

        $finalLabel = $this->flattenValues($finalLabel, 2.5);

        $weight = '[' . implode(",", array_map(function ($v) {
            return number_format($v, 3);
        }, $finalLabel)) . ']';

        $weight = json_decode($weight);

        return $weight;

        // //'reference' => '0.Education and Self Improvement ' .
        // '1.Entertainment and Health Fitness ' .
        // '2.Financial and business ' .
        // '3.Technology and digital ' .
        // '4.fashion and art ' .
        // '5.production and construction ' .
        // '6.transportationa and logistics ' .
        // '7.social and personal services'
    }

    public function uploadMicroLearning(Request $request)
    {

        $user = Auth::user();
        // Handle the POST request when the form is submitted
        if ($request->isMethod('post')) {
            // Validate the form inputs


            $validatedData = $request->validate([
                'content_name' => 'required|string|max:255', // Title
                'content_desc' => 'required|string', // Description
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Image
                'formattedContent' => 'required|string', // Combined sections
                'labelIds' => 'required|string'
            ]);

            $labels = explode(",", $request->labelIds);
            $weight = $this->calVectorByLabel($labels);

            // Handle the image upload
            // $imageName = Str::random(40) . '.' . $request->file('image')->getClientOriginalExtension();
            // $imagePath = $request->file('image')->move(public_path('asset1/images'), $imageName);
            // $imageUrl = 'asset1/images/' . $imageName;
            // $imagePath = $request->file('image')->store('asset1/images', 'public'); 
            $imagePath = $request->file('image')->store('public/asset1/images'); // Save the file
            $imageUrl = str_replace('public/', '', $imagePath); // Generate the relative URL


            // Prepare data to be inserted into the contents table
            $contentData = [
                'name' => $validatedData['content_name'], // Save title
                'desc' => $validatedData['content_desc'], // Save description
                'image' => $imageUrl,  // Save image path
                'content' => $validatedData['formattedContent'],  // Save combined sections (content)
                'content_type_id' => 2, // Set content_type_id to 2

                'user_id' => $user->id,
                'reason_phrase' => 'PENDING',
                'category_weight' => json_encode($weight)

            ];

            // Insert the data into the contents table
            $content_id =  DB::table('contents')->insertGetId($contentData);

            foreach ($labels as $l) {
                $exist = DB::table('labels')->where('id', $l)->exists();
                if ($exist) {
                    DB::table('content_label')->insert([
                        'content_id' => $content_id,
                        'label_id' => $l
                    ]);
                }
            }

            // Redirect with success message
            return redirect()->back()->with('success', 'Content uploads successfully!');
        }

        // Return the form view for GET requests (display the form)
        return view('organization.contentManagement.microLearning');
    }

    public function uploadMicroLearningTESTESTESTESTEST(Request $request)
    {
        $user = Auth::user();

        // Handle the POST request when the form is submitted
        if ($request->isMethod('post')) {
            try {
                // Validate the form inputs
                $validatedData = $request->validate([
                    'content_name' => 'required|string|max:255', // Title
                    'content_desc' => 'required|string', // Description
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Image
                    'formattedContent' => 'required|string', // Combined sections
                    'labelIds' => 'required|string' // Labels (IDs)
                ]);

                // Convert label IDs from string to array
                $labels = explode(",", $request->labelIds);
                $weight = $this->calVectorByLabel($labels);

                // Handle the image upload and store it in the public folder
                $imagePath = $request->file('image')->store('asset1/images', 'public');

                // Prepare data for insertion into the contents table
                $contentData = [
                    'name' => $validatedData['content_name'], // Content title
                    'desc' => $validatedData['content_desc'], // Content description
                    'image' => $imagePath,  // Image path
                    'content' => $validatedData['formattedContent'],  // Combined content sections
                    'content_type_id' => 2, // Set content type to 2
                    'user_id' => $user->id,
                    'reason_phrase' => 'PENDING', // Set status as PENDING
                    'category_weight' => json_encode($weight), // Save category weights as JSON
                ];

                // Insert content data into the database and get the inserted ID
                $content_id = DB::table('contents')->insertGetId($contentData);

                // Handle the relationship between content and labels
                foreach ($labels as $labelId) {
                    $exists = DB::table('labels')->where('id', $labelId)->exists();
                    if ($exists) {
                        DB::table('content_label')->insert([
                            'content_id' => $content_id,
                            'label_id' => $labelId
                        ]);
                    }
                }

                // Check if email notifications are enabled
                $email_status = DB::table('email_status')->where('email', 'admin@xbug.online')->first();

                if ($email_status && $email_status->status == 1) {
                    // Log the success of content upload
                    $logData = [
                        'email_type' => 'UPLOAD CONTENT',
                        'recipient_email' => $user->email,
                        'from_email' => 'admin@xbug.online',
                        'name' => $user->name,
                        'status' => 'SUCCESS',
                        'response_data' => 'Content uploaded successfully!',
                        'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                        'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                    ];
                    DB::table('email_logs')->insert($logData);

                    // Send the email if email status is enabled
                    Mail::mailer('smtp')->to($user->email)->send(new ContentNotificationMail(1, null, $user->name, $validatedData['content_name']));
                }

                // Redirect with a success message
                return redirect()->back()->with('success', 'Content uploaded successfully!');
            } catch (Exception $e) {
                // Log the failure in case of an error
                $logData = [
                    'email_type' => 'UPLOAD CONTENT',
                    'recipient_email' => $user->email,
                    'from_email' => 'admin@xbug.online',
                    'name' => $user->name,
                    'status' => 'FAILED',
                    'response_data' => 'ERROR: ' . $e->getMessage(),
                    'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                    'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                ];
                DB::table('email_logs')->insert($logData);

                // Return an error message if the process fails
                return back()->with('error', 'ERROR: ' . $e->getMessage());
            }
        }

        // Return the form view for GET requests (display the form)
        return view('organization.contentManagement.microLearning');
    }


    // public function getLabels(Request $request)
    // {
    //     $labels = DB::table('labels')
    //     ->select('name')->get();

    //     return response()->json($labels);
    // }
    public function promoteContentPayment(Request $request)
    {
        // Validation
        // return view('content.payment');

        $validator = Validator::make($request->all(), [
            'content_id' => 'required|integer|exists:contents,id', // content_id must be an integer and exist in the `contents` table
            'content_name' => 'required|string|max:255', // content_name must be a string and not exceed 255 characters
            'package' => 'required|integer|exists:package,id', // package must be a valid ID in the `packages` table
            'states' => 'required|array|min:1', // at least one state must be selected
            'states.*' => 'string|exists:states,name', // each state must be a valid state name
            'final_price' => 'required|regex:/^RM \d+(\.\d{2})?$/', // final_price must match RM <amount> format
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user_id = Auth::id();

        // Get content and package details
        $content = DB::table('contents')->where('user_id', $user_id)->where('id', $request->content_id)->where('status', 1)->first();
        $package = DB::table('package')->where('id', $request->package)->first();

        if (empty($content) || empty($package)) {
            return back()->withError('Invalid content');
        }

        // Base price and base state
        $basePrice = $package->base_price;
        $baseState = $package->base_state;

        // Get the number of selected states
        $n = count($request->states);

        // Calculate the final price on the server side
        $calculatedPrice = $basePrice * (1 + max($n - $baseState, 0) / 10);

        // Parse the final price sent by the client (remove the "RM" and convert to a number)
        $clientFinalPrice = floatval(str_replace(['RM', ','], '', $request->final_price));

        // Compare the client-sent price with the server-calculated price
        if (abs($clientFinalPrice - $calculatedPrice) > 0.01) {
            // If the prices don't match, you can return an error message
            return back()->withError('Invalid Request. Please Try Again.');
        }

        $delete = DB::table('content_promotion')
            ->whereNull('transaction_id')
            ->where('status', 1)
            ->whereNull('enrollment')
            ->whereNull('views')

            ->whereNull('clicks')

            ->where('content_id', $content->id)
            ->delete();

        $list = DB::table('content_promotion')

            ->whereNotNull('views')
            ->whereNotNull('clicks')
            ->where('status', 1)
            ->where('content_id', $content->id)
            ->where('completed', 0)
            ->get();
        //dd($list,$content->id);
        if (!$list->isEmpty()) {
            DB::transaction(function () use ($list, $content) {
                foreach ($list as $item) {
                    $total_click = DB::table('user_content')
                        ->where('updated_at', '>', $item->created_at)
                        ->where('content_id', $content->id)
                        ->where('interaction_type_id', 2)
                        ->count();

                    $total_view = DB::table('user_content')
                        ->where('updated_at', '>', $item->created_at)
                        ->where('content_id', $content->id)
                        ->where('interaction_type_id', 1)
                        ->count();

                    $total_enroll = DB::table('user_content')
                        ->where('updated_at', '>', $item->created_at)
                        ->where('content_id', $content->id)
                        ->where('interaction_type_id', 3)
                        ->count();

                    $reach = $total_view + $total_click * 2 + $total_enroll * 4;
                    //dd($reach);
                    if ($reach >= $item->estimate_reach) {
                        DB::table('content_promotion')
                            ->where('id', $item->id)
                            ->where('status', 1)
                            ->where('content_id', $content->id)
                            ->update(['completed' => 1]);
                    }
                }
            });
        }


        $exist = DB::table('content_promotion')

            ->whereNotNull('views')
            ->whereNotNull('clicks')
            ->where('status', 1)
            ->where('content_id', $content->id)
            ->where('completed', 0)
            ->exists();

        if ($exist) {
            return back()->withError('You have an ongoing promotion. Please wait the current promotion to be completed first.');
        }

        $id = DB::table('content_promotion')->insertGetId([
            'content_id' => $content->id,
            'views' => null,
            'clicks' => null,
            'enrollment' => null,
            'target_audience' => json_encode($request->states),
            'estimate_reach' => $package->estimate_user,
            'promotion_price' => $calculatedPrice

        ]);
        $cp_id = DB::table('content_promotion')->where('id', $id)->first();

        return view('content.payment', compact('content', 'cp_id', 'package'));
    }


    public function getLabels(Request $request)
    {
        try {
            $query = $request->input('query'); // Get the query parameter from the request

            // Fetch labels that match the query (case-insensitive)
            $labels = Label::where('name', 'like', '%' . $query . '%')->select('id', 'name')->orderByRaw('LENGTH(name) ASC')->limit(15)->get();

            // If labels are found, return them as a JSON response
            return response()->json($labels);
        } catch (\Exception $e) {
            // Return an error response with the exception message in case something goes wrong
            return response()->json([
                'error' => 'Failed to fetch labels',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function promoteContentReceipt($transaction_id)
    {
        $transaction = DB::table('transactions')->where('id', $transaction_id)->first();

        if ($transaction == null) {
            return response()->json('Invalid Transaction');
        }
        $cp_id = DB::table('content_promotion')->where('transaction_id', $transaction->id)->first();
        if (!isset($cp_id) || $cp_id->views == null || $cp_id->clicks == null) {
            return response()->json('Invalid Transaction');
        }
        $content = DB::table('contents')->where('id', $cp_id->content_id)->first();

        if (!isset($content)) {
            return response()->json('Invalid Transaction');
        }

        $user = Auth::user();
        $userRoles = json_decode($user->role);
        if (!in_array(1, $userRoles) && Auth::id() != $content->user_id) {
            return response()->json(['message' => 'Unauthorized Action']);
        }


        return view('content.promote_content_receipt', compact('cp_id', 'content', 'transaction'));
    }


    public function xbugStandReceipt($transaction_id)
    {
        $transaction = DB::table('transactions')->where('id', $transaction_id)->first();

        $cp_id = DB::table('content_promotion')->where('transaction_id', $transaction->id)->first();
        $content = DB::table('contents')->where('id', $cp_id->content_id)->first();

        if ($cp_id->number_of_card == null || $cp_id->enrollment == null) {
            return response()->json('Invalid Transaction');
        }

        $content_cards = DB::table('content_card')->where('content_id', $content->id)->whereNotNull('card_id')->whereNotNull('tracking_id')->select('card_id', 'tracking_id')->get();
        $user = Auth::user();
        $userRoles = json_decode($user->role);
        if (!in_array(1, $userRoles) && Auth::id() != $content->user_id) {
            return response()->json(['message' => 'Unauthorized Action']);
        }


        return view('content.xbug_stand_receipt', compact('cp_id', 'content', 'transaction', 'content_cards'));
    }
    public function addCard(Request $request, $card_id)
    {
        $xbug_stand_price = 1; // Constant value for now

        // Validate the incoming request
        $validatedData = $request->validate([
            'startDate' => 'required|date|before_or_equal:endDate',
            'startTime' => 'required|date_format:H:i',
            'endDate' => 'required|date|after_or_equal:startDate',
            'endTime' => 'required|date_format:H:i',
            'numXbugStand' => 'required|integer|min:1|max:10', // Updated min to 1
        ], [
            'startDate.required' => 'The start date is required.',
            'startDate.date' => 'The start date must be a valid date.',
            'startDate.before_or_equal' => 'The start date must be before or equal to the end date.',
            'startTime.required' => 'The start time is required.',
            'startTime.date_format' => 'The start time must be in the format HH:mm.',
            'endDate.required' => 'The end date is required.',
            'endDate.date' => 'The end date must be a valid date.',
            'endDate.after_or_equal' => 'The end date must be after or equal to the start date.',
            'endTime.required' => 'The end time is required.',
            'endTime.date_format' => 'The end time must be in the format HH:mm.',
            'numXbugStand.required' => 'The number of xBUG stands is required.',
            'numXbugStand.integer' => 'The number of xBUG stands must be an integer.',
            'numXbugStand.min' => 'The number of xBUG stands must be at least 1.',
            'numXbugStand.max' => 'For more than 10 stands, please email admin@xbug.online for your request.',
        ]);

        $user_id = Auth::id();

        $labels = explode(",", $request->labelIds);
        $weight = $this->calVectorByLabel($labels);


        // Retrieve content for the user and validate its existence
        $content = DB::table('contents')
            ->where('user_id', $user_id)
            ->where('id', $card_id)
            ->where('status', 1)
            ->first();

        if (empty($content)) {
            return back()->withError('Invalid content');
        }

        // Calculate the price
        $price = $xbug_stand_price * $request->numXbugStand;


        $delete = DB::table('content_promotion')
            ->whereNull('transaction_id')
            ->where('status', 1)
            ->whereNull('enrollment')
            ->whereNull('views')

            ->whereNull('clicks')

            ->where('content_id', $content->id)
            ->delete();

        $delete2 =  DB::table('content_card')->whereNull('transaction_id')->where('content_id', $content->id)->delete();
        // Attempt to update the promotion
        $exists = DB::table('content_promotion')
            ->whereNotNull('transaction_id')
            ->where('status', 1)
            ->whereNotNull('enrollment')
            ->where('content_id', $content->id)
            ->exists();

        if (!$exists) {
            // Insert new promotion if no update occurred
            $id = DB::table('content_promotion')->insertGetId([
                'content_id' => $content->id,
                'views' => null,
                'clicks' => null,
                'enrollment' => null,
                'number_of_card' => $request->numXbugStand,
                'promotion_price' => $price,
            ]);

            $startDatetime = $request->startDate . ' ' . $request->startTime;
            $endDatetime = $request->endDate . ' ' . $request->endTime;

            $contentCardId = DB::table('content_card')->insertGetId([
                'startdate' => $startDatetime,
                'enddate' => $endDatetime,
                'content_id' => $content->id,
            ]);



            $stand_id = DB::table('content_promotion')->where('id', $id)->first();
        } else {
            return back()->withError('You have placed the xBUG Stand for this content already. If you need more stands, please email admin@xbug.online for your request.');
        }

        return view('content.apply_stand', compact('content', 'stand_id', 'price'));
    }
}
