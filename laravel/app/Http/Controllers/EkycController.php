<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Carbon\Carbon;

class EkycController extends Controller
{
    //
    public function CardVerification()
    {
        return view('ekyc.card-verification');
    }

    public function FaceVerification()
    {
        return view('ekyc.face-verification');
    }
    public function VerificationSuccess(Request $request)
    {
        DB::beginTransaction();
        try {
            $userName = str_replace(' ', '-', Auth::user()->name);
            $formattedIcNo = substr(Auth::user()->icNo, 0, 6) . '-' . substr(Auth::user()->icNo, 6, 2) . '-' . substr(Auth::user()->icNo, 8);

            $data = [
                'status' => 'eKYC_VERIFIED',
                'user' => $formattedIcNo . ':::::' . strtoupper($userName),
                'timestamp' => Carbon::now('Asia/Kuala_Lumpur'), // ISO 8601 format
                'randomString' => Str::random(800), // 512 karakter rawak
            ];
            $ekycSignature = implode(':::|||:::', $data);
            // dd($ekycSignature);

            // Simpan ke dalam pangkalan data
            DB::table('users')->where('id', Auth::user()->id)->update([
                'ekyc_status' => 1,
                'ekyc_time' => Carbon::now('Asia/Kuala_Lumpur'), 
                'ekyc_signature' => $ekycSignature,
            ]);
            DB::commit();
            $currentUrl = request()->url();

            if (str_contains($currentUrl, '/organization')) {
                return redirect()->route('showDashboardOrganization')->with('success', 'Verification e-KYC Successful! Now you can access more features.');
            } elseif (str_contains($currentUrl, '/content-creator')) {
                return redirect()->route('showDashboardContentCreator')->with('success', 'Verification e-KYC Successful! Now you can access more features.');
            }
        } catch (Exception $th) {
            DB::rollBack();
            return redirect()->route('showDashboardOrganization')->with('error', 'Failed to Verify e-KYC. Please Try again later or contact support by email help-center@xbug.online!');
        }
    }
}
