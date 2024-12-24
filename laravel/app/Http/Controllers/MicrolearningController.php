<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MicrolearningController extends Controller
{

    public function displayContent(Request $request)
    {
        // Get the search term from the request
        $search = $request->query('search', '');
    
        // Query the database to fetch and filter contents
        $contents = DB::table('contents as c')
            ->join('content_types', 'c.content_type_id', '=', 'content_types.id')
            ->select('c.id', 'c.name', 'c.image', 'content_types.type as content_type_name')
            ->where('content_types.id', '=' , 2)
            ->when($search, function ($query, $search) {
                return $query->where('c.name', 'like', '%' . $search . '%'); // 
            })
            ->get();
    
        // Return the dashboard view with the contents
        return view('microlearning.index', ['contents' => $contents]);
    }
    

    public function showContentBasedOnID($id)
{
    // Query the database to fetch the content by ID
    $content = DB::table('contents as c')
        ->join('content_types', 'c.content_type_id', '=', 'content_types.id')
        ->select(
            'c.id', 
            'c.name', 
            'c.image', 
            'c.desc', 
            'content_types.type as content_type_name',
            'c.link')
        ->where('c.id', $id)
        ->first();

    // Check if content exists
    if (!$content) {
        abort(404, 'Content not found');
    }

    // Return the view with the content data
    return view('microlearning.show', ['content' => $content]);
}

    


    public function upload()
    {
        
        return view('microlearning.upload');
    }




    public function showMicrolearning()
    {
        $countContent = DB::table('contents')
        ->count();
        $countContents_CourseTraining = DB::table('contents')
        ->where('content_type_id', '=', 1)
        ->count();

        $countContents_MicroLearning = DB::table('contents')
        ->where('content_type_id', '=', 2)
        ->count();

        $countContents_Event = DB::table('contents')
        ->where('content_type_id', '=', 4)
        ->count();

        $countContents_JobOffer = DB::table('contents')
        ->where('content_type_id', '=', 5)
        ->count();

        return view('viewMicroLearning.indexMicrolearning', compact('countContent','countContents_CourseTraining','countContents_MicroLearning', 'countContents_Event', 'countContents_JobOffer'));
    }


    public function showMicrolearningDetail(Request $request, $id)
    {
        // Get the search term from the request
        $search = $request->query('search', '');
        
    
        // Query the database to fetch and filter contents by content_type_id and search term
        $contents = DB::table('contents as c')
            ->join('content_types', 'c.content_type_id', '=', 'content_types.id')
            ->select('c.id', 'c.name', 'c.image', 'content_types.type as content_type_name', 'c.created_at','c.reason_phrase')
            ->where('content_types.id', '=', $id) // Use dynamic $id
            ->where('c.reason_phrase', '=', 'APPROVED')
            ->when($search, function ($query, $search) {
                return $query->where('c.name', 'like', '%' . $search . '%'); 
            })
            ->get();
    
        // Return the view with the fetched data
        return view('viewMicroLearning.showMicrolearningDetail', [
            'contents' => $contents
        ]);
    }
    

}
