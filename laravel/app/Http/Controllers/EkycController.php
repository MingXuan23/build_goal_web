<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class EkycController extends Controller
{
    //

    public function CheckMobile(Request $request)
    {

        $useragent = $_SERVER['HTTP_USER_AGENT'];

        $is_mobile =
            preg_match(
                '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',
                $useragent,
            ) ||
            preg_match(
                '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/',
                substr($useragent, 0, 4),
            );

        return response()->json(['is_mobile' => $is_mobile]);
    }

    public function CardVerification($data)
    {
        try {
            $decryptedData = $data;
        } catch (\Exception $e) {
            return back()->with(['error' => 'Invalid data']);
        }
        return view('ekyc.card-verification', [
            'data' => $decryptedData
        ]);
    }

    public function FaceVerification()
    {
        return view('ekyc.face-verification');
    }

    public function VerificationSuccess(Request $request)
    {
        DB::beginTransaction();
        try {

            $idno = $request->query('idno');
            $idno = str_replace('-', '', $idno);
            $userData = DB::table('users')->where('icNo', $idno)->first();
            if (!$userData) {
                return back()->with(['error' => 'Invalid data']);
            }

            $userName = str_replace(' ', '-', $userData->name);
            $formattedIcNo = substr($userData->icNo, 0, 6) . '-' . substr($userData->icNo, 6, 2) . '-' . substr($userData->icNo, 8);

            $timestamp = Carbon::now('Asia/Kuala_Lumpur')->format('Y-m-d-H:i:s');

            $data = [
                'VERSION' => '1',
                'SERIAL NO' => Str::random(32), // Random serial number for example
                'SIGNATURE ALGORITHM' => 'SHA256',
                'ISSUER DN' => 'CN=xBug, O=xBug.online, C=MY',
                'SUBJECT DN' => 'CN=' . strtoupper($userName) . ',SERIALNUMBER=' . $formattedIcNo . ', C=MY',
                'KEY USAGE' => 'xBug e-KYC VERIFICATION',
                'DATE ISSUER' => $timestamp,
                'SHA1 FINGERPRINT' => Str::random(70) // Random SHA1 fingerprint for example
            ];

            $ekycSignature = '';
            foreach ($data as $key => $value) {
                $ekycSignature .= strtoupper($key) . ' : ' . $value . "\n";
            }

            // Remove the trailing newline
            $ekycSignature = rtrim($ekycSignature);

            DB::table('users')->where('id', $userData->id)->update([
                'ekyc_status' => 1,
                'ekyc_time' => Carbon::now('Asia/Kuala_Lumpur'),
                'ekyc_signature' => $ekycSignature,
            ]);

            DB::commit();
            return redirect()->route('login')->with('success', 'Verification e-KYC Successful! Login Now to access more features.');
        } catch (Exception $th) {
            DB::rollBack();
            return redirect()->route('login')->with('error', 'Failed to Verify e-KYC. Please Try again later or contact support by email help-center@xbug.online!');
        }
    }

    public function GenerateQrCode(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $encryptedParams =  $user->icNo;
        $url = env('APP_URL') . '/card-verification/' . urlencode($encryptedParams);

        return response()->json(['url' => $url]);
    }


    public function showCardLogs(Request $request)
    {
        // Ambil data dari API
        $response = Http::withHeaders([
            'Authorization' => env("EKYC_API_KEY"),
        ])->get(env('API_EKYC_URL').'/card-logs');   
        $data = $response->json(); 
        

        if ($response->successful()) {
            $data = $response->json();
            
            if (isset($data['data']) && !empty($data['data'])) {
                $logs = $data['data'];
            } else {
                $logs = [];
            }
        } else {
            $logs = [];
        }
        
    
        if ($request->ajax()) {

            return DataTables::of($logs)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row['status'] == 'success') {
                        return '<span class="badge bg-success p-2 fw-bold">SUCCESS</span>';
                    } elseif ($row['status'] == 'failed') {
                        return '<span class="badge bg-danger p-2 fw-bold">FAILED</span>';
                    }
                    return '<span class="badge bg-warning fw-bold">ERROR</span>';
                })
                ->addColumn('res', function ($row) {
                    if ($row['status'] == 'success') {
                        return '<span class="badge bg-success-transparent p-2 fw-bold" style="word-wrap: break-word; white-space: normal; text-align: left;">'.$row['response'].'</span>';
                    } elseif ($row['status'] == 'failed') {
                        return '<span class="badge bg-danger-transparent p-2 fw-bold" style="word-wrap: break-word; white-space: normal; text-align: left;">'.$row['response'].'</span>';
                    }                    
                    
                    return '<span class="badge bg-danger">ERROR</span>';
                })
                ->rawColumns([ 'status','res'])
                ->make(true);
        }


        return view('admin.ekyc.card-logs');
    }

    public function showFaceLogs(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => env("EKYC_API_KEY"),
        ])->get(env('API_EKYC_URL').'/face-logs');
        $data = $response->json();
 
        if ($response->successful()) {
            $data = $response->json();
            
            if (isset($data['data']) && !empty($data['data'])) {
                $logs = $data['data'];
            } else {
                $logs = [];
            }
        } else {
            $logs = [];
        }
    

        if ($request->ajax()) {
            return DataTables::of($logs)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row['status'] == 'SUCCESS') {
                        return '<span class="badge bg-success p-2 fw-bold">SUCCESS</span>';
                    } elseif ($row['status'] == 'FAILED') {
                        return '<span class="badge bg-danger p-2 fw-bold">FAILED</span>';
                    }
                    return '<span class="badge bg-warning fw-bold">ERROR</span>';
                })
                ->addColumn('res', function ($row) {
                    if ($row['status'] == 'SUCCESS') {
                        return '<span class="badge bg-success-transparent p-2 fw-bold">'.$row['response'].'</span>';
                    } elseif ($row['status'] == 'FAILED') {
                        return '<span class="badge bg-danger-transparent p-2 fw-bold">'.$row['response'].'</span>';
                    }
                    return '<span class="badge bg-danger fw-bold">ERROR</span>';
                })
                ->rawColumns(['status','res'])
                ->make(true);
        }
    
        return view('admin.ekyc.face-logs');
    }
    
}
