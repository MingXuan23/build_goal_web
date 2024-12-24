<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Content;

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

        $password1 = Str::random(16);
        $password = bcrypt($password1);

        DB::beginTransaction();
        $user = 0;
        try {
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
                    'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                    'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                ]);

                $user = DB::table('users')->where('email', $request->input('email'))->first();

                $content = DB::table('content_card')
                    ->join('contents', 'content_card.content_id', '=', 'contents.id')->where('content_card.card_id', $card_id)->first();


                // dd($content,$card_id);
                $checkUser = DB::table('user_content')->where('user_id', $user->id)->where('content_id', $content->content_id)->first();
                if ($checkUser) {
                    return back()->with('error', 'You have already registered for this content');
                }

                $userDetails = DB::table('user_content')->insertGetId([
                    'user_id' => $user->id,
                    'interaction_type_id' =>  3,
                    'status' => 1,
                    'content_id' => $content->content_id,
                    'ip_address' => $request->ip(),
                    'verification_code' => $content->verification_code,
                    'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                    'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                ]);

                $logData = [
                    'email_type' => 'REGISTER GUEST CONTENT',
                    'recipient_email' => $request->input('email'),
                    'from_email' => 'admin@xbug.online',
                    'name' => $validatedData['fullname'],
                    'status' => 'SUCCESS',
                    'response_data' => 'Verification code has been sent',
                    'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                    'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                ];



                DB::table('email_logs')->insert($logData);
                DB::commit();

                Mail::to($request->input('email'))->send(new ResetPasswordMail($validatedData['fullname'], $password1));
                return back()->with('success', 'Registration successfull. Your record has been saved and we has been created your account. Please check your email for password xBUG app');
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
                'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
            ];

            DB::table('email_logs')->insert($logData);
            return back()->withError('Error EDE' . $e->getLine() . ' : ' . $e->getMessage());
        }
    }
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
        // dd($request->all());
        $user = Auth::user();

        $org = DB::table('organization_user')->where('user_id',$user->id)->where('status',1)->first(); //should change in the future
        // Validate form inputs
        $validated = $request->validate([
            'content_name' => 'required|string|max:255',
            'content_desc' => 'required|string',
            'content_link' => 'required|url',
            'enrollment_price' => 'required|numeric|min:0',
            'place' => 'required|string|max:255',
            'participant_limit' => 'required|integer',
            'states' => 'required|array',
            'content_type_id' => 'required|exists:content_types,id', // Validate foreign key
        ], [
            'states' => ', Please select at least 1 state',
        ], [
            'content_type_id' => 'Content Type'
        ]);

        // Insert data into the contents table
        DB::table('contents')->insert([
            'name' => $validated['content_name'],
            'desc' => $validated['content_desc'],
            'link' => $validated['content_link'],
            'enrollment_price' => $validated['enrollment_price'],
            'place' => $validated['place'],
            'participant_limit' => $validated['participant_limit'],
            'state' => json_encode($validated['states']),
            'content_type_id' => $validated['content_type_id'], // Foreign key
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => $user->id,
            'org_id' => $org->organization_id,
            'reason_phrase' => 'PENDING'
        ]);

        // Redirect back with success message
        return back()->with('success', 'Your Content Is Applied Successfully!');
    }

    public function approveContent($id)
    {
        $content = Content::find($id);
        if ($content) {
            $content->reason_phrase = 'APPROVED'; // Set content as approved
            $content->reject_reason = null; // Clear any rejection reason if it was previously set
            $content->save();
        }

        return redirect()->back()->with('status', 'Content approved successfully!');
    }

    public function rejectContent(Request $request, $id)
    {
        $content = Content::find($id);
        if ($content) {
            $content->reason_phrase = 'REJECTED'; // Set content as rejected
            $content->reject_reason = $request->input('rejection_reason'); // Save rejection reason
            $content->save();
        }

        return back()->with('status', 'Content rejected successfully!');
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

        if ($card == null) {
            abort(404);
        }


        return view('content_interaction.index', compact('card'));
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
            ]);
    
            // Handle the image upload as a base64-encoded string
            $imageFile = $request->file('image');
            $imageBase64 = base64_encode(file_get_contents($imageFile));
    
            // Prepare data to be inserted into the contents table
            $contentData = [
                'name' => $validatedData['content_name'], // Save title
                'desc' => $validatedData['content_desc'], // Save description
                'image' => $imageBase64,  // Save image as base64 string
                'content' => $validatedData['formattedContent'],  // Save combined sections (content)
                'content_type_id' => 2, // Set content_type_id to 2
                'created_at' => now(), // Timestamp for creation
                'updated_at' => now(), // Timestamp for update
                'user_id' => $user->id,
                'reason_phrase' => 'PENDING'
            ];
    
            // Insert the data into the contents table
            DB::table('contents')->insert($contentData);
    
            // Redirect with success message
            return redirect()->back()->with('success', 'Content uploaded successfully!');
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

        $exist = DB::table('content_promotion')
                
                ->whereNotNull('views')
                ->whereNotNull('clicks')
                ->where('status',1)
                ->where('content_id',$content->id)
                ->where('completed',0)
                ->exists();

        if($exist){
            return back()->withError('You have an ongoing promotion. Please wait the current promotion to be completed first.');
        }

        $id = DB::table('content_promotion')->insertGetId([
            'content_id' => $content->id,
            'views' => null,
            'clicks' => null,
            'enrollment' => null,
            'target_audience' =>json_encode($request->states),
            'estimate_reach'=> $package ->estimate_user,
            'promotion_price' => $calculatedPrice

        ]);
        $cp_id =DB::table('content_promotion')->where('id',$id)->first();

        return view('content.payment', compact('content','cp_id','package'));

       
    }

    
    public function getLabels(Request $request){
        try {
            $query = $request->input('query'); // Get the query parameter from the request

            // Fetch labels that match the query (case-insensitive)
            $labels = Label::where('name', 'like', '%' . $query . '%')->pluck('name');

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

    public function promoteContentReceipt($transaction_id){
        $transaction = DB::table('transactions')->where('id',$transaction_id)->first();

        if($transaction == null){
            return response()->json('Invalid Transaction');

        }
        $cp_id = DB::table('content_promotion')->where('transaction_id', $transaction->id)->first();
        if(!isset($cp_id) ||$cp_id->views == null || $cp_id->clicks == null  ){
            return response()->json('Invalid Transaction');
        }
        $content = DB::table('contents')->where('id', $cp_id->content_id)->first();

        if(!isset($content) ){
            return response()->json('Invalid Transaction');
        }

        $user = Auth::user();
        $userRoles = json_decode($user->role);
        if (!in_array(1, $userRoles) && Auth::id() != $content->user_id) {
            return response()->json(['message' => 'Unauthorized Action']);
        }
       

        return view('content.promote_content_receipt', compact('cp_id','content','transaction'));

    }


    public function xbugStandReceipt($transaction_id){
        $transaction = DB::table('transactions')->where('id',$transaction_id)->first();

        $cp_id = DB::table('content_promotion')->where('transaction_id', $transaction->id)->first();
        $content = DB::table('contents')->where('id', $cp_id->content_id)->first();

        if($cp_id->number_of_card == null || $cp_id->enrollment == null){
            return response()->json('Invalid Transaction');
        }

        $user = Auth::user();
        $userRoles = json_decode($user->role);
        if (!in_array(1, $userRoles) && Auth::id() != $content->user_id) {
            return response()->json(['message' => 'Unauthorized Action']);
        }
       

        return view('content.xbug_stand_receipt', compact('cp_id','content','transaction'));

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