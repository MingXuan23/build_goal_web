<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


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




    public function showContentHomepage()
    {
        $countContent = DB::table('contents')
        ->where('reason_phrase', '=', 'APPROVED')
        ->count();
        $courseAndTrainingSlug = str_replace(' ', '-', DB::table('content_types')->where('id', 1)->value('type'));
        $microLearningSlug = str_replace(' ', '-', DB::table('content_types')->where('id', 2)->value('type'));
        $eventSlug = str_replace(' ', '-', DB::table('content_types')->where('id', 5)->value('type'));
        $jobOfferingSlug = str_replace(' ', '-', DB::table('content_types')->where('id', 4)->value('type'));
        
        

        $countContents_CourseTraining = DB::table('contents')
        ->where('content_type_id', '=', 1)
        ->where('reason_phrase', '=', 'APPROVED')
        ->count();

        $countContents_MicroLearning = DB::table('contents')
        ->where('content_type_id', '=', 2)
        ->where('reason_phrase', '=', 'APPROVED')
        ->count();

        $countContents_Event = DB::table('contents')
        ->where('content_type_id', '=', 5)
        ->where('reason_phrase', '=', 'APPROVED')
        ->count();

        $countContents_JobOffer = DB::table('contents')
        ->where('content_type_id', '=', 4)
        ->where('reason_phrase', '=', 'APPROVED')
        ->count();

        return view('viewContent.indexContent', compact('countContent','countContents_CourseTraining','countContents_MicroLearning', 'countContents_Event', 'countContents_JobOffer','courseAndTrainingSlug','microLearningSlug','eventSlug','jobOfferingSlug'));
    }


    public function showContentDetail(Request $request, $slug)
    {
            // Convert slug back to the type (in case you need to restore spaces)
            $contentType = str_replace('-', ' ', $slug); 
            $countContent = DB::table('contents')
            ->where('reason_phrase', '=', 'APPROVED')
            ->count();

            $microLearningSlug = str_replace(' ', '-', DB::table('content_types')->where('id', 2)->value('type'));
            // Fetch the content type ID based on the slug (type)
            $contentTypeId = DB::table('content_types')
                ->select('id')
                ->where('type', '=', $contentType)
                ->first();

            // Check if content type is found
            if (!$contentTypeId) {
                abort(404, 'Content Type not found');
            }

            // Extract the ID from the result
            $contentTypeId = $contentTypeId->id;

            // Fetch the contents related to the content type ID
            $contents = DB::table('contents as c')
                ->join('content_types', 'c.content_type_id', '=', 'content_types.id')
                ->select(
                    'c.id',
                    'c.name',
                    'c.image',
                    'content_types.type as content_type_name',
                    'c.created_at',
                    'c.reason_phrase',
                    'c.content',
                    'c.desc'
                )
                ->where('content_types.id', '=', $contentTypeId)  // Use content type ID to fetch contents
                ->where('c.reason_phrase', '=', 'APPROVED')  // Filter only approved contents
                ->get();

            // Return the view with the fetched content
            return view('viewContent.showContentDetail', [
                'contents' => $contents,
                'contentTypeId' => $contentTypeId
                
            ], compact('countContent','microLearningSlug'));
        }

        public function showMicrolearningDetail(Request $request, $slug, $name)
        {
            // Convert slug back to content name with spaces
            $name = str_replace('-', ' ', $name);
            $microLearningSlug = str_replace(' ', '-', DB::table('content_types')->where('id', 2)->value('type'));
            // Fetch the content type ID for 'MicroLearning' (or similar)
            $contentTypeId = DB::table('content_types')
                ->select('id')
                ->where('type', '=', str_replace('-', ' ', $slug))
                ->first();

            if (!$contentTypeId) {
                abort(404, 'Content Type not found');
            }

            $contentTypeId = $contentTypeId->id;

            // Fetch the content by name and type
            $contents = DB::table('contents as c')
                ->join('content_types', 'c.content_type_id', '=', 'content_types.id')
                ->select(
                    'c.id',
                    'c.name',
                    'c.image',
                    'content_types.type as content_type_name',
                    'c.created_at',
                    'c.reason_phrase',
                    'c.content',
                    'c.desc'
                )
                ->where('content_types.id', '=', $contentTypeId)
                ->where('c.name', '=', $name)
                ->where('c.reason_phrase', '=', 'APPROVED')
                ->first();

            if (!$contents) {
                abort(404, 'Content not found');
            }

            return view('viewContent.showMicrolearning', [
                'contents' => $contents
                
            ],compact('microLearningSlug'));
        }


    



    

}
