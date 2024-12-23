<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

use Exception;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     
     public function directpayIndex(Request $request)
     {
       
        try{
        $user = DB::table('users')->where('id',Auth::id())->first();
        //payment of the content promotion
        if (!empty($request->cp_token)) {
            // Split the cp_token into parts using '-'
            $data = explode('-', $request->cp_token);
        
            // Fetch the content promotion record
            $content_promotion = DB::table('content_promotion')->where('id', $data[0])->first();
        
            if(empty($content_promotion)){
                return response()->json(['error' => 'Invalid Request']);
            }
            // Validate if the updated_at part matches the data[1]
            if (!is_numeric($data[1]) || preg_replace('/[^0-9]/', '', $content_promotion->updated_at) !== $data[1]) {
                return response()->json(['error' => 'Invalid Request']);
            }
        
            // Fetch user information
            $fpx_buyerEmail = $user->email;
            $fpx_buyerName = $user->name;
            $telno = $user->telno;
        
            // Fetch content details
            $content = DB::table('contents')->where('id', $content_promotion->content_id)->first();
            $organization_id = $content->org_id;
        
            // Fetch the organization details
            $org = DB::table('organization')->where('id', $organization_id)->first();
        
            // Get the private key, fallback to env value if not set
            $private_key = $org->payment_key ?? env('DIRECT_PAY_KEY', '');

            $fpx_sellerTxnTime  = date('YmdHis');
            $fpx_txnAmount      = $content_promotion->promotion_price;
            $fpx_sellerExOrderNo  = "XBug"  . "_" . date('YmdHis') . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $fpx_sellerOrderNo =  "PromoteContent_" . date('YmdHis') . "_" . $organization_id;

        }

        else if(!empty($request->stand_token)){
            $data = explode('-', $request->stand_token);
           
            // Fetch the content promotion record
            $content_promotion = DB::table('content_promotion')->where('id', $data[0])->first();
           // dd($data, $content_promotion);
            if(empty($content_promotion)){
                return response()->json(['error' => 'Invalid Request']);
            }
            // Validate if the updated_at part matches the data[1]
            if (!is_numeric($data[1]) || preg_replace('/[^0-9]/', '', $content_promotion->updated_at) !== $data[1]) {
                return response()->json(['error' => 'Invalid Request']);
            }
        
            // Fetch user information
            $fpx_buyerEmail = $user->email;
            $fpx_buyerName = $user->name;
            $telno = $user->telno;
        
            // Fetch content details
            $content = DB::table('contents')->where('id', $content_promotion->content_id)->first();
            $organization_id = $content->org_id;
        
            // Fetch the organization details
            $org = DB::table('organization')->where('id', $organization_id)->first();
        
            // Get the private key, fallback to env value if not set
            $private_key = $org->payment_key ?? env('DIRECT_PAY_KEY', '');

            $fpx_sellerTxnTime  = date('YmdHis');
            $fpx_txnAmount      = $content_promotion->promotion_price;
            $fpx_sellerExOrderNo  = "XBug"  . "_" . date('YmdHis') . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $fpx_sellerOrderNo =  "XBugStand_" . date('YmdHis') . "_" . $organization_id;

        }
        //other payment
        else{
            $organization_id = $request->org_id;
            $fpx_buyerEmail = $request->email;
            $telno = $request->telno;
            $fpx_buyerName = $request->name;
    
            $fpx_sellerOrderNo = $request->desc . "_" . date('YmdHis') . "_" . $organization_id;
     
            $fpx_sellerExOrderNo  = "XBug"  . "_" . date('YmdHis') . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    
            $private_key= env('DIRECT_PAY_KEY',''); //$organization->private_key;
     
            
     
     
            $fpx_sellerTxnTime  = date('YmdHis');
            $fpx_txnAmount      = $request->amount;
     
        }
        


       
 
        $transaction = new Transaction();
        $transaction->sellerExOrderNo  = $fpx_sellerExOrderNo;
        $transaction->sellerOrderNo   = $fpx_sellerOrderNo;
        $transaction->transac_no    = NULL;
        // convert time to Y-m-d H:i:s format

        $transaction->amount        = $fpx_txnAmount;
        $transaction->status        = 'Pending';
        //$transaction->email         = $fpx_buyerEmail;
        //$transaction->telno         = $telno;
        $transaction->user_id       = $user ? $user->id : null;
        $transaction->organization_id = $organization_id;
        //$transaction->username      = strtoupper($fpx_buyerName);
          

 
        if ($transaction->save()) {
            if (!empty($request->cp_token)) {
                DB::table('content_promotion')->where('id', $content_promotion->id)->update([
                    'transaction_id'=> $transaction->id
                ]);
            }else  if (!empty($request->stand_token)) {
                DB::table('content_promotion')->where('id', $content_promotion->id)->update([
                    'transaction_id'=> $transaction->id
                ]);
            }
            else{
                //do nothing
            }
        
        }
        else
        {
            return view('errors.500');
        }
           

             return view('directpay.index',compact(
                 'fpx_buyerEmail',
                 'fpx_buyerName',
                 'private_key',
                 'fpx_txnAmount',
                 'fpx_sellerExOrderNo',
                 'fpx_sellerOrderNo',
                
 
             ));
         }  catch (\Throwable $th) {
             return response()->json(['error'=>$th->getMessage()]);
         }
    }

    public function directpayReceipt(Request $request)
    {
        $case = explode("_", $request->Fpx_SellerOrderNo);
        //return response()->json(['request'=>'success']);
        if ($request->Fpx_DebitAuthCode == '00') {
        // dd($case[0]);
            Transaction::where('sellerOrderNo', '=', $request->Fpx_SellerOrderNo)
            ->update(
                ['transac_no' => $request->Fpx_FpxTxnId,
                'status' => 'Success',

                'amount'=>$request->TransactionAmount,
                'sellerExOrderNo' => $request ->Fpx_SellerExOrderNo
                ]
            );

            $transaction =  Transaction::where('sellerOrderNo', '=', $request->Fpx_SellerOrderNo)->first();

            $parts = explode('_', $request->Fpx_SellerOrderNo);

            if($parts[0] == 'PromoteContent'){
                //do update
                 DB::table('content_promotion')->where('transaction_id', $transaction->id)->update([
                    'clicks'=> 0,
                    'views'=>0,
                 ]);

                $cp_id = DB::table('content_promotion')->where('transaction_id', $transaction->id)->first();
                $content = DB::table('contents')->where('id', $cp_id->content_id)->first();

                return view('content.promote_content_receipt', compact('cp_id','content','transaction'));
            }else if($parts[0] == 'XBugStand'){
                DB::table('content_promotion')->where('transaction_id', $transaction->id)->update([
                    'enrollment'=> 0,
                 ]);

                $cp_id = DB::table('content_promotion')->where('transaction_id', $transaction->id)->first();
                $content = DB::table('contents')->where('id', $cp_id->content_id)->first();

                return view('content.xbug_stand_receipt', compact('cp_id','content','transaction'));
            }

            

           return view('directpay.receipt');
            
            
        }
        else {

            Transaction::where('sellerOrderNo', '=', $request->Fpx_SellerOrderNo)->update(['transac_no' => $request->Fpx_FpxTxnId, 'status' => 'Failed']);
            $transaction =  Transaction::where('sellerOrderNo', '=', $request->Fpx_SellerOrderNo)->first();

            $user = Transaction::where('sellerOrderNo', '=', $request->Fpx_SellerOrderNo)->first();

            $parts = explode('_', $request->Fpx_SellerOrderNo);

            if($parts[0] == 'PromoteContent'){
                $content = DB::table('content_promotion')->where('transaction_id',$transaction->id)->update([
                    'status'=>0
                ]); //no success
              
                //do update
            }
            
            //gitdd($user,$request->Fpx_SellerOrderNo);
            return view('directpay.receipt', compact('request', 'user'));

           
        }
    }

 
    public function index()
    {
        return view('directpay.template_payment');
    }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(Transaction $transaction)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Transaction $transaction)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, Transaction $transaction)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Transaction $transaction)
    // {
    //     //
    // }

    public function testcallback()
    {
        return view('directpay.testcallback');
    }
}
