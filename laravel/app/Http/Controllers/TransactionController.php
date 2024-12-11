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
        $organization_id = $request->org_id;
        $fpx_buyerEmail = $request->email;
        $telno = $request->telno;
        $fpx_buyerName = $request->name;

        $fpx_sellerOrderNo = $request->desc . "_" . date('YmdHis') . "_" . $organization_id;
 
        $fpx_sellerExOrderNo  = "XBug"  . "_" . date('YmdHis') . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $private_key= env('DIRECT_PAY_KEY',''); //$organization->private_key;
 
        
 
 
        $fpx_sellerTxnTime  = date('YmdHis');
        $fpx_txnAmount      = $request->amount;
 
 
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
            
        
        }
        else
        {
            return view('errors.500');
        }
             //dd('fpxsellerOrderNo:'.$fpx_sellerOrderNo.'\nlength:'.strlen($fpx_sellerOrderNo),'fpx_sellerExOrderNo:'.$fpx_sellerExOrderNo.'\nlength:'.strlen($fpx_sellerOrderNo));
             //$private_key = '9BB6D047-2FB3-4B7A-9199-09441E7F4B0C';
 
             // dd($fpx_buyerEmail, $fpx_buyerName, $private_key, $fpx_txnAmount, $fpx_sellerExOrderNo, $fpx_sellerOrderNo);
 
             //dd($pos,$fpx_sellerOrderNo);
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

           return view('directpay.receipt');
            
            
        }
        else {

            Transaction::where('nama', '=', $request->Fpx_SellerOrderNo)->update(['transac_no' => $request->Fpx_FpxTxnId, 'status' => 'Failed']);

            $user = Transaction::where('nama', '=', $request->Fpx_SellerOrderNo)->first();
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
