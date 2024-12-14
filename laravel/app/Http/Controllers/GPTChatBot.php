<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GPTChatBot extends Controller
{
    //
    public function showChatBot(Request $request){
        $Model = DB::table('gpt_table')->where('status', 1)->first();

        if (!$Model) {
            return view('organization.gptChatBot.index',[
                'status_model' => 0
            ]);
        }
        return view('organization.gptChatBot.index',[
            'status_model' => 1
        ]);
    }
    public function showGptModel(Request $request){

        $datas = DB::table('gpt_table')
        ->orderby('id', 'asc')
        ->get();


        if ($request->ajax()) {
            $table = DataTables::of($datas)->addIndexColumn();
            $table->addColumn('status', function ($row) {
                $statusClass = $row->status === 1 ? 'success' : 'danger';
                $statusMessage = $row->status === 1 ? 'ACTIVE' : 'INACTIVE';
                return '<div class="d-flex justify-content-between">
                            <span class=" badge bg-' . $statusClass . ' p-2">' . $statusMessage . '</span>
                            <button class="btn btn-icon btn-sm btn-info-transparent rounded-pill"
                                data-bs-toggle="modal" data-bs-target="#modalUpdateStatus-' . $row->id . '">
                                <i class="ri-edit-line fw-bold"></i>
                            </button>
                        </div>';
            });
            $table->addColumn('action', function ($row) {
                $button = '<div class="d-flex justify-content-center">
                                    <button class="btn btn-icon btn-sm btn-warning-transparent rounded-pill"
                                        data-bs-toggle="modal" data-bs-target="#modalUpdateModel-' . $row->id . '">
                                        <i class="ri-edit-line fw-bold"></i>
                                    </button>
                                    </div>
                                    ';
                return $button;
            });


            $table->rawColumns(['action','status']);

            return $table->make(true);
        }

        return view('admin.gpt.model',[
            'datas' => $datas
        ]);
    }
    public function updateGptModelStatus(Request $request, $id){
        $validate = $request->validate([
            'status' => 'required|in:1,0',
        ]);
    
        try {
            DB::beginTransaction();
    
            if ($request->status == 1) {
                DB::table('gpt_table')->update(['status' => 0]);
            }
    
            DB::table('gpt_table')
                ->where('id', $id)
                ->update(['status' => $request->status]);
    
            DB::commit();
    
            return back()->with('success', 'Status has been updated!');
    
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update status: ' . $e->getMessage());
        }
    }
    public function updateGptModel(Request $request, $id){
        $validate = $request->validate([
            'model_name' => 'required',
            'provider' => 'required',
            'max_token' => 'required',
        ]);

        try {
            DB::beginTransaction();
    
            DB::table('gpt_table')
            ->where('id', $id)
            ->update(['model_name' => $request->model_name, 'provider' => $request->provider,'max_token' => $request->max_token]);

            DB::commit();
            return back()->with('success', 'Model has been updated!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update status: ' . $e->getMessage());
        }
    }
    public function showChatBotAdmin(Request $request){
        $Model = DB::table('gpt_table')->where('status', 1)->first();

        if (!$Model) {
            return view('admin.gpt.gpt',[
                'status_model' => 0
            ]);
        }

        return view('admin.gpt.gpt',[
            'status_model' => 1
        ]);
    }
    public function sendMessage(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:240',
            ]);
    
            $userMessage = $request->input('message');
            $apiKey = env('OPENAI_API_KEY');
            $model = DB::table('gpt_table')->where('status', 1)->first();
    
            if (Auth::user()->is_gpt == 0) {
                DB::table('gpt_log')->insert([
                    'name' => 'GPT API',
                    'model' => $model->model_name,
                    'provider' => $model->provider,
                    'user_id' => auth()->user()->id,
                    'status' => 0,
                    'prompt_tokens' => '-',
                    'completion_tokens' => '-',
                    'total_tokens' => 'USER NOT GPT',
                    'request' => $userMessage,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry, Please Upgrade Your Account To Premium User First.',
                ], 500);
            }
            if (Auth::user()->gpt_status == 0) {
                DB::table('gpt_log')->insert([
                    'name' => 'GPT API',
                    'model' => $model->model_name,
                    'provider' => $model->provider,
                    'user_id' => auth()->user()->id,
                    'status' => 0,
                    'prompt_tokens' => '-',
                    'completion_tokens' => '-',
                    'total_tokens' => 'USER IS BANNED',
                    'request' => $userMessage,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry, Your Account Is Currently Banned. Please Contact Us By Email [help-center@xbug.online] Inform Us or To Get Support.',
                ], 500);
            }
            if (!$model) {
                DB::table('gpt_log')->insert([
                    'name' => 'GPT API',
                    'model' => 'N/A',
                    'provider' => 'N/A',
                    'user_id' => auth()->user()->id,
                    'status' => 0,
                    'prompt_tokens' => '-',
                    'completion_tokens' => '-',
                    'total_tokens' => 'MODEL UNAVAILABLE',
                    'request' => $userMessage,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry, Model is Currently Unavailable. Please Contact Us By Email [help-center@xbug.online] Inform Us or To Get Support.',
                ], 500);
            }
            $maxTokens = $model->max_token;
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => $model->model_name,
                'messages' => [
                    [
                        'role' => 'system', 
                        'content' => "You are a helpful assistant. Please limit your response to approximately {$maxTokens} tokens."
                    ],
                    ['role' => 'user', 'content' => $userMessage],
                ],
            ]);
            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['choices'][0]['message']['content'] ?? 'No response from AI';


                DB::table('gpt_log')->insert([
                    'name' => 'GPT API',
                    'model' => $model->model_name,
                    'provider' => $model->provider,
                    'user_id' => auth()->user()->id,
                    'status' => 1,
                    'prompt_tokens' => $data['usage']['prompt_tokens'],
                    'completion_tokens' => $data['usage']['completion_tokens'],
                    'total_tokens' => $data['usage']['total_tokens'],
                    'request' => $userMessage,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => $reply,
                ]);
            }

            DB::table('gpt_log')->insert([
                'name' => 'GPT API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '-',
                'completion_tokens' => '-',
                'total_tokens' => 'API CALL ERROR 500',
                'request' => $userMessage,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Sorry, Something went wrong. Please Contact Us By Email [help-center@xbug.online] Inform Us or To Get Support.',
            ], 500);
    
        } catch (ValidationException $e) {
            DB::table('gpt_log')->insert([
                'name' => 'GPT API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '-',
                'completion_tokens' => '-',
                'total_tokens' => 'VALIDATION ERROR 422',
                'request' => $userMessage,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error: ' . $e->getMessage(),
            ], 422);
        } catch (RequestException $e) {
            DB::table('gpt_log')->insert([
                'name' => 'GPT API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '-',
                'completion_tokens' => '-',
                'total_tokens' => 'REQUEST ERROR 500',
                'request' => $userMessage,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Request error: ' . $e->getMessage(),
            ], 500);
        } catch (Exception $e) {
            DB::table('gpt_log')->insert([
                'name' => 'GPT API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '-',
                'completion_tokens' => '-',
                'total_tokens' => 'UNEXPECTED ERROR 500',
                'request' => $userMessage,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
            ], 500);
        }
    } 
    public function sendMessageAdmin(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:240',
            ]);
    
            $userMessage = $request->input('message');
            $apiKey = env('OPENAI_API_KEY');
            $model = DB::table('gpt_table')->where('status', 1)->first();
    
            if (!$model) {
                DB::table('gpt_log')->insert([
                    'name' => 'GPT API',
                    'model' => 'N/A',
                    'provider' => 'N/A',
                    'user_id' => auth()->user()->id,
                    'status' => 0,
                    'prompt_tokens' => '',
                    'completion_tokens' => '',
                    'total_tokens' => 'MODEL UNAVAILABLE',
                    'request' => $userMessage,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry, Model is Currently Unavailable. Please Contact Us By Email [help-center@xbug.online] Inform Us or To Get Support.',
                ], 500);
            }
            $maxTokens = $model->max_token;
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => $model->model_name,
                'messages' => [
                    [
                        'role' => 'system', 
                        'content' => "You are a helpful assistant. Please limit your response to approximately {$maxTokens} tokens."
                    ],
                    ['role' => 'user', 'content' => $userMessage],
                ],
            ]);
            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['choices'][0]['message']['content'] ?? 'No response from AI';


                DB::table('gpt_log')->insert([
                    'name' => 'GPT API',
                    'model' => $model->model_name,
                    'provider' => $model->provider,
                    'user_id' => auth()->user()->id,
                    'status' => 1,
                    'prompt_tokens' => $data['usage']['prompt_tokens'],
                    'completion_tokens' => $data['usage']['completion_tokens'],
                    'total_tokens' => $data['usage']['total_tokens'],
                    'request' => $userMessage,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => $reply,
                ]);
            }

            DB::table('gpt_log')->insert([
                'name' => 'GPT API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '',
                'completion_tokens' => '',
                'total_tokens' => 'API CALL ERROR 500',
                'request' => $userMessage,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Sorry, Something went wrong. Please Contact Us By Email [help-center@xbug.online] Inform Us or To Get Support.',
            ], 500);
    
        } catch (ValidationException $e) {
            DB::table('gpt_log')->insert([
                'name' => 'GPT API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '',
                'completion_tokens' => '',
                'total_tokens' => 'VALIDATION ERROR 422',
                'request' => $userMessage,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error: ' . $e->getMessage(),
            ], 422);
        } catch (RequestException $e) {
            DB::table('gpt_log')->insert([
                'name' => 'GPT API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '',
                'completion_tokens' => '',
                'total_tokens' => 'REQUEST ERROR 500',
                'request' => $userMessage,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Request error: ' . $e->getMessage(),
            ], 500);
        } catch (Exception $e) {
            DB::table('gpt_log')->insert([
                'name' => 'GPT API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '',
                'completion_tokens' => '',
                'total_tokens' => 'UNEXPECTED ERROR 500',
                'request' => $userMessage,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
            ], 500);
        }
    } 
    public function getUsage(Request $request)
    {
        try {
            $apiKey = env('OPEN_API_KEY_ADMIN');
            $startTime = time();
    
            $costResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->get('https://api.openai.com/v1/organization/costs?start_time=' . $startTime . '&limit=7');
            
            $apiKeysResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->get('https://api.openai.com/v1/organization/projects/proj_ZMTd66XVKNgntqSA7svtjJV5/api_keys/key_EJZCxTcPiUtMsR17');

            if ($costResponse->successful() && $apiKeysResponse->successful()) {
                $costData = $costResponse->json()['data'] ?? [];
                $apiKeysData = $apiKeysResponse->json() ?? [];
    
                if ($request->ajax()) {
                    $table = DataTables::of($costData)->addIndexColumn();
                    $table->addColumn('amount', function ($row) {
                        return $row['results'][0]['amount']['value'] ?? '0.00';
                    });
                    $table->addColumn('name', function ($row) {
                        return $row['results'][0]['object'] ?? 'N/A';
                    });
                    $table->addColumn('currency', function ($row) {
                        return 'USD';
                    });
                    $table->addColumn('start_time', function ($row) {
                        return 'LATEST';
                    });
                    $table->addColumn('end_time', function ($row) {
                        return 'LATEST';
                    });
                    $table->rawColumns(['amount', 'currency','start_time','end_time','name']);
    
                    return $table->make(true);
                }
    
                return view('admin.gpt.index', [
                    'costs' => $costData,
                    'apiKeys' => $apiKeysData,
                ]);
            } else {
                return view('admin.gpt.index', ['error' => 'Unable to fetch data']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        
    }
    public function showGptLog(Request $request){
        $data = DB::table('gpt_log as gl')
        ->join('users as u', 'gl.user_id', '=', 'u.id')
        ->select('gl.*', 'u.name as user_name','u.email as user_email','u.icNo as user_icNo')
        ->orderby('gl.created_at', 'desc')
        ->get();

        if ($request->ajax()) {
            $table = DataTables::of($data)->addIndexColumn();
            $table->addColumn('status', function ($row) {
                $statusClass = $row->status === 1 ? 'success' : 'danger';
                $statusMessage = $row->status === 1 ? 'SUCCESS' : 'FAILED';
                $button = '<span class=" badge bg-' . $statusClass . ' p-2">' . $statusMessage . '</span>';
                return $button;
            });
            $table->addColumn('model', function ($row) {
                $button = '<span class="">' . $row->model . ' ['.$row->provider.']'.'</span>';
                return $button;
            });
            $table->addColumn('total_tokens', function ($row) {
                $statusClass = $row->status === 1 ? 'success' : 'danger';
                $statusMessage = $row->status === 1 ? 'SUCCESS' : 'FAILED';
                $button = '<span class=" text-' . $statusClass . ' fs-12 fw-bold">' . $row->total_tokens . '</span>';
                return $button;
            });


            $table->rawColumns(['status','model','total_tokens']);
            return $table->make(true);
        }

            return view('admin.gpt.log');
    }
    
}
