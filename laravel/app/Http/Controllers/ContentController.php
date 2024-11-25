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

        if($request->ajax()) {
            $table = DataTables::of($user_data)->addIndexColumn();
            $table->addColumn('action', function ($row) {
                if($row->reason_phrase == 'APPROVED'){

                    $button = '<div class="d-flex justify-content-end"><button class="btn btn-icon btn-sm btn-info-transparent rounded-pill me-2"
                                            data-bs-toggle="modal" data-bs-target="#modalView-' . $row->id . '">
                                            <i class="ri-eye-line fw-bold"></i>
                                        </button>                                      
                                </div>
                                        ';
                   
                }
                else{
                    $button = '
                    <div class="d-flex justify-content-between">
                                <span class=" text-warning p-2 me-1 fw-bold">
                                    <i class="bi bi-circle-fill"></i> Pending..
                                </span>
                            </div>
                                    ';
                    
                }
                return $button;
            });

            $table->rawColumns(['action']);
            return $table->make(true);
        }
        

        return view('organization.contentManagement.index', [
            'content_data' => $user_data,
            'stateCities' => $stateCities
            
        ]);

    }

}
