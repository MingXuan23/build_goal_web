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
        $states_list = [
            "Johor", "Kedah", "Kelantan", "Kuala Lumpur", "Labuan", "Melaka", 
            "Negeri Sembilan", "Pahang", "Perak", "Perlis", "Penang", "Putrajaya", 
            "Selangor", "Terengganu",
            // Sarawak Divisions
            "Sarawak - Kuching", "Sarawak - Sri Aman", "Sarawak - Sibu", "Sarawak - Miri", 
            "Sarawak - Limbang", "Sarawak - Sarikei", "Sarawak - Kapit", "Sarawak - Samarahan", 
            "Sarawak - Bintulu", "Sarawak - Betong", "Sarawak - Mukah", "Sarawak - Serian",
            // Sabah Divisions
            "Sabah - Beaufort", "Sabah - Keningau", "Sabah - Kuala Penyu", "Sabah - Membakut", 
            "Sabah - Nabawan", "Sabah - Sipitang", "Sabah - Tambunan", "Sabah - Tenom", 
            "Sabah - Kota Marudu", "Sabah - Pitas", "Sabah - Beluran", "Sabah - Kinabatangan", 
            "Sabah - Sandakan", "Sabah - Telupid", "Sabah - Tongod", "Sabah - Kalabakan", 
            "Sabah - Kunak", "Sabah - Lahad Datu", "Sabah - Semporna", "Sabah - Tawau", 
            "Sabah - Kota Belud", "Sabah - Kota Kinabalu", "Sabah - Papar", "Sabah - Penampang", 
            "Sabah - Putatan", "Sabah - Ranau", "Sabah - Tuaran"
        ];
        // Fetch id and name from the table
    $contents = DB::table('contents')->select('id', 'name')->get();

    // Pass the data to the Blade view
    return view('organization.contentManagement.promoteContent', [
        'contents' => $contents,
        'state_list' => $states_list
    ]);
    }
}
