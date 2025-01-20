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
        ->where('status', '=', 1)
        ->count();
        $courseAndTrainingSlug = str_replace(' ', '-', DB::table('content_types')->where('id', 1)->value('type'));
        $microLearningSlug = str_replace(' ', '-', DB::table('content_types')->where('id', 2)->value('type'));
        $eventSlug = str_replace(' ', '-', DB::table('content_types')->where('id', 5)->value('type'));
        $jobOfferingSlug = str_replace(' ', '-', DB::table('content_types')->where('id', 4)->value('type'));
        
        

        $countContents_CourseTraining = DB::table('contents')
        ->where('content_type_id', '=', 1)
        ->where('reason_phrase', '=', 'APPROVED')
        ->where('status', '=', 1)
        ->count();

        $countContents_MicroLearning = DB::table('contents')
        ->where('content_type_id', '=', 2)
        ->where('reason_phrase', '=', 'APPROVED')
        ->where('status', '=', 1)
        ->count();

        $countContents_Event = DB::table('contents')
        ->where('content_type_id', '=', 5)
        ->where('reason_phrase', '=', 'APPROVED')
        ->where('status', '=', 1)
        ->count();

        $countContents_JobOffer = DB::table('contents')
        ->where('content_type_id', '=', 4)
        ->where('reason_phrase', '=', 'APPROVED')
        ->where('status', '=', 1)
        ->count();

        return view('viewContent.indexContent', compact('countContent','countContents_CourseTraining','countContents_MicroLearning', 'countContents_Event', 'countContents_JobOffer','courseAndTrainingSlug','microLearningSlug','eventSlug','jobOfferingSlug'));
    }


    public function showContentDetail(Request $request, $slug)
    {
            // Convert slug back to the type (in case you need to restore spaces)
            $contentType = str_replace('-', ' ', $slug); 
            $countContent = DB::table('contents')
            ->where('reason_phrase', '=', 'APPROVED')
            ->where('status', '=', 1)
            ->count();

            $countContents_CourseTraining = DB::table('contents')
            ->where('content_type_id', '=', 1)
            ->where('reason_phrase', '=', 'APPROVED')
            ->where('status', '=', 1)
            ->count();

            $countContents_MicroLearning = DB::table('contents')
            ->where('content_type_id', '=', 2)
            ->where('reason_phrase', '=', 'APPROVED')
            ->where('status', '=', 1)
            ->count();

            $countContents_Event = DB::table('contents')
            ->where('content_type_id', '=', 5)
            ->where('reason_phrase', '=', 'APPROVED')
            ->where('status', '=', 1)
            ->count();

            $countContents_JobOffer = DB::table('contents')
            ->where('content_type_id', '=', 4)
            ->where('reason_phrase', '=', 'APPROVED')
            ->where('status', '=', 1)
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
                ->leftJoin('smart_contract as sc', 'sc.content_id','=','c.id')
                ->select(
                    'c.id',
                    'c.name',
                    'c.image',
                    'content_types.type as content_type_name',
                    'c.created_at',
                    'c.reason_phrase',
                    'c.content',
                    'c.desc',
                    'c.enrollment_price',
                    'c.participant_limit',
                    'c.place',
                    'c.link',
                    'c.status',
                    'sc.tx_hash',
                    'sc.block_no',
                    'sc.status_contract',
                    'sc.updated_at'
                )
                ->where('content_types.id', '=', $contentTypeId)  // Use content type ID to fetch contents
                ->where('c.reason_phrase', '=', 'APPROVED')  // Filter only approved contents
                ->where('c.status', '=', 1)
                ->orderBy('c.created_at', 'desc')
                ->get();

            // dd($contents);

            // Return the view with the fetched content
            return view('viewContent.showContentDetail', [
                'contents' => $contents,
                'contentTypeId' => $contentTypeId
                
            ], compact('countContent','microLearningSlug','countContents_CourseTraining','countContents_MicroLearning','countContents_Event','countContents_JobOffer'));
        }

        public function showMicrolearningDetail(Request $request, $slug, $name)
        {
            // Convert slug back to content name with spaces
            $originalName = str_replace('~', ' ', $name); // Replace hyphen with space

            // Optional: Decode URL-encoded characters (if necessary)
            $originalName = urldecode($originalName);
            
            // dd($name);
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
                ->leftJoin('smart_contract as sc', 'sc.content_id','=','c.id')
                ->select(
                    'c.id',
                    'c.name',
                    'c.image',
                    'c.status',
                    'content_types.type as content_type_name',
                    'c.created_at',
                    'c.reason_phrase',
                    'c.content',
                    'c.desc',
                    'sc.tx_hash',
                    'sc.block_no',
                    'sc.status_contract',
                    'sc.updated_at'
                )
                ->where('content_types.id', '=', $contentTypeId)
                ->whereRaw('LOWER(c.name) = ?', [strtolower($originalName)]) // Case-insensitive match
                ->where('c.reason_phrase', '=', 'APPROVED')
                ->where('c.status', '=', 1)
                ->first();

            if (!$contents) {
                abort(404, 'Content not found');
            }

            // dd($contents);

            return view('viewContent.showMicrolearning', [
                'contents' => $contents
                
            ],compact('microLearningSlug'));
        }

        public function viewContentLink(Request $request, $id, $name)
        {
            // Convert slug back to content name with spaces
            $originalName = str_replace('~', ' ', $name); // Replace hyphen with space

            // Optional: Decode URL-encoded characters (if necessary)
            $originalName = urldecode($originalName);
            
           
            // Fetch the content type ID for 'MicroLearning' (or similar)
            // $contentTypeId = DB::table('content_types')
            //     ->select('id')
            //     ->where('type', '=', str_replace('-', ' ', $slug))
            //     ->first();

            // if (!$contentTypeId) {
            //     abort(404, 'Content Type not found');
            // }

            // $contentTypeId = $contentTypeId->id;

            // Fetch the content by name and type
          
            $contents = DB::table('contents as c')
                ->join('content_types', 'c.content_type_id', '=', 'content_types.id')
                ->select(
                    'c.id',
                    'c.name',
                    'c.image',
                    'c.status',
                    'content_types.type as content_type_name',
                    'c.created_at',
                    'c.reason_phrase',
                    'c.content',
                    'c.desc',
                    'c.content_type_id',
                    'c.link'
                )
               
                ->whereRaw('LOWER(c.name) = ?', [strtolower($originalName)]) // Case-insensitive match
                ->where('c.reason_phrase', '=', 'APPROVED')
                ->where('c.status', '=', 1)
                ->where('c.id',$id)
                ->first();

            if (!$contents) {
                abort(404, 'Content not found');
            }
            $slug =  DB::table('content_types')
               
                ->where('id', '=',$contents->content_type_id )
                ->first();

            $slug_name = str_replace( ' ','-', $slug->type);
            //dd($contents);

            return view('viewContent.showContentLink', [
                'contents' => $contents
                
            ],compact('slug_name'));
        }


    



    

}
