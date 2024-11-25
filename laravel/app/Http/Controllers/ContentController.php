<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

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
        // Fetch id and name from the table
    $contents = DB::table('contents')->select('id', 'name')->get();

    // Pass the data to the Blade view
    return view('auth.organization-register', [
        'contents' => $contents
    ]);
    }
}
