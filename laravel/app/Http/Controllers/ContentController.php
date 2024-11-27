<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Content; // Replace with your actual model

class ContentController extends Controller
{
    /**
     * Show the promotion content page with the content details.
     *
     * @param int $id Content ID
     * @return \Illuminate\View\View
     */
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

 

    public function showContent(Request $request)
    {
        $user = Auth::user();
        $stateCitiesJson = file_get_contents(public_path('assets/json/states-cities.json'));
        $stateCities = json_decode($stateCitiesJson, true);
        // $user->id;

        $user_data = DB::table('contents as c')->where('c.user_id',$user->id)->join('content_types as ct','ct.id','c.content_type_id')->get();
        $packages = DB::table('package')->where('status', true)->get();
        if($request->ajax()) {
            $table = DataTables::of($user_data)->addIndexColumn();
            $table->addColumn('action', function ($row) {
                if($row->reason_phrase == 'APPROVED'){

                    $button = 
                    '<div class="d-flex">
                            <button class="btn  btn-success-light"
                            data-bs-toggle="modal"
                            data-bs-target="#modalView-' . $row->id . '">
                             Promote
                            </button>
                            </div>';                                                        
                }
                else{
                    $button = 
                    '<div class="d-flex justify-content-between">
                        <span class=" text-warning p-2 me-1 fw-bold">
                             <i class="bi bi-circle-fill"></i> Pending..
                        </span>
                    </div>';
                    
                }
                return $button;
            });

            $table->rawColumns(['action']);
            return $table->make(true);
        }
        

        return view('organization.contentManagement.index', [
            'content_data' => $user_data,
            'stateCities' => $stateCities,
            'packages' => $packages
        ]);

    }

    public function viewAddContent(Request $request)
    {
        $content_types = DB::table('content_types')->where('status', true)->get();
        $stateCitiesJson = file_get_contents(public_path('assets/json/states-cities.json'));
        $stateCities = json_decode($stateCitiesJson, true);
        return view('organization.contentManagement.applyContent', compact('content_types','stateCities'));
    }

    public function addContent(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
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
        ],[
            'states' => ', Please select at least 1 state',
        ],[
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
            'reason_phrase' => 'PENDING'
        ]);
    
        // Redirect back with success message
        return back()->with('success', 'Content created successfully!');
    }
    

    // public function showContentType()
    // {
    //     // Fetch all active content types
    //     $content_types = DB::table('content_types')->where('status', true)->get();
    
    //     // Pass content types to the view
    //     return view('organization.contentManagement.applyContent', compact('content_types'));
    // }
    

}
