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

            // Handle the image upload
            $imagePath = $request->file('image')->store('asset1/images', 'public'); // Store image in the public/asset1/images folder

            // Prepare data to be inserted into the contents table
            $contentData = [
                'name' => $validatedData['content_name'], // Save title
                'desc' => $validatedData['content_desc'], // Save description
                'image' => $imagePath,  // Save image path
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
            return redirect()->back()->with('success', 'Content uploads successfully!');
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
        $validator = Validator::make($request->all(), [
            'content_id' => 'required|integer|exists:contents,id', // content_id must be an integer and exist in the `contents` table
            'content_name' => 'required|string|max:255', // content_name must be a string and not exceed 255 characters
            'package' => 'required|integer|exists:package,id', // package must be a valid ID in the `packages` table
            'states' => 'required|array|min:1', // at least one state must be selected
            'states.*' => 'string|exists:states,name', // each state must be a valid state name
            'final_price' => 'required|regex:/^RM \d+(\.\d{2})?$/', // final_price must match RM <amount> format
        ]);

        if ($validator->fails()) {
            dd($validator->errors()); // This will give you the error messages from the validator
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

        $update = DB::table('content_promotion')->whereNull('transaction_id')->where('status',1)->where('content_id',$content->id)->update([
            'views' => 0,
            'clicks' => 0,
            'enrollment' => 0,
            'target_audience' =>json_encode($request->states),
            'estimate_reach'=> $package ->estimate_user,
            'promotion_price' => $calculatedPrice   
        ]);

        if(!$update){
            DB::table('content_promotion')->insert([
                'content_id' => $content->id,
                'views' => 0,
                'clicks' => 0,
                'enrollment' => 0,
                'target_audience' =>json_encode($request->states),
                'estimate_reach'=> $package ->estimate_user,
                'promotion_price' => $calculatedPrice
    
            ]);
        }
        $cp_id = DB::table('content_promotion')->whereNull('transaction_id')->where('status',1)->where('content_id',$content->id)->first();

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

    public function addCard(Request $request, $card_id)
    {
        dd($request->all());
    }
}