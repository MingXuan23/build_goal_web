<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Exception;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Str;
use Ramsey\Uuid\Guid\Guid;


class GPTChatBot extends Controller
{
    //
    public function showChatBot(Request $request)
    {
        $Model = DB::table('gpt_table')->where('status', 1)->first();

        if (!$Model) {
            return view('organization.gptChatBot.index', [
                'status_model' => 0
            ]);
        }
        return view('organization.gptChatBot.index', [
            'status_model' => 1
        ]);
    }
    public function showGptModel(Request $request)
    {

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


            $table->rawColumns(['action', 'status']);

            return $table->make(true);
        }

        return view('admin.gpt.model', [
            'datas' => $datas
        ]);
    }
    public function updateGptModelStatus(Request $request, $id)
    {
        $validate = $request->validate([
            'status' => 'required|in:1,0',
        ]);

        try {
            DB::beginTransaction();

            // if ($request->status == 1) {
            //     DB::table('gpt_table')->update(['status' => 0]);
            // }

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
    public function updateGptModel(Request $request, $id)
    {
        $validate = $request->validate([
            'model_name' => 'required',
            'provider' => 'required',
            'max_token' => 'required',
        ]);

        try {
            DB::beginTransaction();

            DB::table('gpt_table')
                ->where('id', $id)
                ->update(['model_name' => $request->model_name, 'provider' => $request->provider, 'max_token' => $request->max_token]);

            DB::commit();
            return back()->with('success', 'Model has been updated!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update status: ' . $e->getMessage());
        }
    }
    public function showChatBotAdmin(Request $request)
    {
        $Model_GPT = DB::table('gpt_table')->where('id', 1)->first();
        $Model_Anal = DB::table('gpt_table')->where('id', 2)->first();

        return view('admin.gpt.gpt', [
            'status_gpt' => $Model_GPT ? $Model_GPT->status : 0, // default 0 jika tidak ditemukan
            'status_analysis' => $Model_Anal ? $Model_Anal->status : 0,
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
            $model = DB::table('gpt_table')->where('status', 1)->where('id', 1)->first();

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
    public function sendGenerateSuggestion(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:240',
            ]);

            $userMessage = $request->input('message');
            $apiKey = env('OPENAI_API_KEY');
            $model = DB::table('gpt_table')->where('status', 1)->where('id', 1)->first();

            if (Auth::user()->is_gpt == 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry, Please Upgrade Your Account To Premium User First.',
                ], 500);
            }
            if (Auth::user()->gpt_status == 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry, Your Account Is Currently Banned. Please Contact Us By Email [help-center@xbug.online] Inform Us or To Get Support.',
                ], 500);
            }
            if (!$model) {
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
                return response()->json([
                    'status' => 'success',
                    'message' => $reply,
                ]);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Sorry, Something went wrong. Please Contact Us By Email [help-center@xbug.online] Inform Us or To Get Support.',
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function generateDescription(Request $request)
    {
        $model = DB::table('gpt_table')->where('status', 1)->where('id', 1)->first();
        $contentName = $request->input('content_name');
        try {
            $request->validate([
                'content_name' => 'required|string|max:240',
                'content_type_id' => 'required|exists:content_types,id',
            ]);

            $apiKey = env('OPENAI_API_KEY');
        
            $content_type_name = DB::table('content_types')->where('id', $request->content_type_id)->select('type')->first();

            if (!$model) {
                DB::table('gpt_log')->insert([
                    'name' => 'CONTENT SUGGESTION API',
                    'model' => 'N/A',
                    'provider' => 'N/A',
                    'user_id' => auth()->user()->id,
                    'status' => 0,
                    'prompt_tokens' => '-',
                    'completion_tokens' => '-',
                    'total_tokens' => 'MODEL UNAVAILABLE',
                    'request' => $contentName,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Model is currently unavailable. Please try again later.',
                ], 500);
            }
            if (Auth::user()->is_gpt == 0) {
                DB::table('gpt_log')->insert([
                    'name' => 'CONTENT SUGGESTION API',
                    'model' => $model->model_name,
                    'provider' => $model->provider,
                    'user_id' => auth()->user()->id,
                    'status' => 0,
                    'prompt_tokens' => '-',
                    'completion_tokens' => '-',
                    'total_tokens' => 'USER NOT GPT',
                    'request' => $contentName,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry, The Suggestion Feature is available for Premium Users only. Please Upgrade Your Account To Premium User First at xBUG Ai.',
                ], 500);
            }
            if (Auth::user()->gpt_status == 0) {
                DB::table('gpt_log')->insert([
                    'name' => 'CONTENT SUGGESTION API',
                    'model' => $model->model_name,
                    'provider' => $model->provider,
                    'user_id' => auth()->user()->id,
                    'status' => 0,
                    'prompt_tokens' => '-',
                    'completion_tokens' => '-',
                    'total_tokens' => 'USER IS BANNED GPT',
                    'request' => $contentName,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry, Your Account Is Currently Banned For xBUG Ai Purpose. Please Contact Us By Email [help-center@xbug.online] Inform Us or To Get Support.',
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
                        'content' => "You are a content generator. Create a detailed and professional description for the content name provided for the content type {$content_type_name->type}. Give the word not more than {$maxTokens} tokens. Give answers related to the name of the content that has been given only. Directly give the description without sentences like in 'Here is a professional description for the content name'."
                    ],
                    ['role' => 'user', 'content' => $contentName],
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $description = $data['choices'][0]['message']['content'] ?? 'No description generated.';
                $cleanDescription = preg_replace('/\*\*/', '', $description);

                DB::table('gpt_log')->insert([
                    'name' => 'CONTENT SUGGESTION API',
                    'model' => $model->model_name,
                    'provider' => $model->provider,
                    'user_id' => auth()->user()->id,
                    'status' => 1,
                    'prompt_tokens' => $data['usage']['prompt_tokens'],
                    'completion_tokens' => $data['usage']['completion_tokens'],
                    'total_tokens' => $data['usage']['total_tokens'],
                    'request' => $contentName,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'success',
                    'description' => $cleanDescription,
                ]);
            }
            DB::table('gpt_log')->insert([
                'name' => 'CONTENT SUGGESTION API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '-',
                'completion_tokens' => '-',
                'total_tokens' => 'API CALL ERROR 500',
                'request' => $contentName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to generate description. Please try again.',
            ], 500);
        } catch (ValidationException $e) {
            DB::table('gpt_log')->insert([
                'name' => 'CONTENT SUGGESTION API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '-',
                'completion_tokens' => '-',
                'total_tokens' => 'VALIDATION ERROR 422',
                'request' => $contentName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error: ' . $e->getMessage(),
            ], 422);
        } catch (RequestException $e) {
            DB::table('gpt_log')->insert([
                'name' => 'CONTENT SUGGESTION API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '-',
                'completion_tokens' => '-',
                'total_tokens' => 'REQUEST ERROR 500',
                'request' => $contentName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Request error: ' . $e->getMessage(),
            ], 500);
        } catch (Exception $e) {
            DB::table('gpt_log')->insert([
                'name' => 'CONTENT SUGGESTION API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '-',
                'completion_tokens' => '-',
                'total_tokens' => 'UNEXPECTED ERROR 500',
                'request' => $contentName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function generateDescriptionGroq(Request $request)
    {
        $model = DB::table('gpt_table')->where('status', 1)->where('id', 2)->first();
        $contentName = $request->input('content_name');
        try {
            $request->validate([
                'content_name' => 'required|string|max:240',
                'content_type_id' => 'required|exists:content_types,id',
            ]);

            $content_type_name = DB::table('content_types')->where('id', $request->content_type_id)->select('type')->first();

            if (!$model) {
                DB::table('gpt_log')->insert([
                    'name' => 'CONTENT SUGGESTION API',
                    'model' => 'N/A',
                    'provider' => 'N/A',
                    'user_id' => auth()->user()->id,
                    'status' => 0,
                    'prompt_tokens' => '-',
                    'completion_tokens' => '-',
                    'total_tokens' => 'MODEL UNAVAILABLE',
                    'request' => $contentName,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Model is currently unavailable. Please try again later.',
                ], 500);
            }
            if (Auth::user()->is_gpt == 0) {
                DB::table('gpt_log')->insert([
                    'name' => 'CONTENT SUGGESTION API',
                    'model' => $model->model_name,
                    'provider' => $model->provider,
                    'user_id' => auth()->user()->id,
                    'status' => 0,
                    'prompt_tokens' => '-',
                    'completion_tokens' => '-',
                    'total_tokens' => 'USER NOT GPT',
                    'request' => $contentName,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry, The Suggestion Feature is available for Premium Users only. Please Upgrade Your Account To Premium User First at xBUG Ai.',
                ], 500);
            }
            if (Auth::user()->gpt_status == 0) {
                DB::table('gpt_log')->insert([
                    'name' => 'CONTENT SUGGESTION API',
                    'model' => $model->model_name,
                    'provider' => $model->provider,
                    'user_id' => auth()->user()->id,
                    'status' => 0,
                    'prompt_tokens' => '-',
                    'completion_tokens' => '-',
                    'total_tokens' => 'USER IS BANNED GPT',
                    'request' => $contentName,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry, Your Account Is Currently Banned For xBUG Ai Purpose. Please Contact Us By Email [help-center@xbug.online] Inform Us or To Get Support.',
                ], 500);
            }
            $maxTokens = $model->max_token;

            $apiKey = env('GROQ_API_KEY');
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => $model->model_name,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are a content generator. Create a detailed and professional description for the content name provided for the content type {$content_type_name->type}. Give the word not more than {$maxTokens} tokens. Give answers related to the name of the content that has been given only. Directly give the description without sentences like in 'Here is a professional description for the content name'."
                    ],
                    ['role' => 'user', 'content' => $contentName],
                ],
            ]);

            // 8. Proses respon dari Groq/OpenAI
            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['choices'][0]['message']['content'] ?? 'No response from AI';
                $cleanDescription = preg_replace('/\*\*/', '', $reply);
                DB::table('gpt_log')->insert([
                    'name' => 'CONTENT SUGGESTION API',
                    'model' => $model->model_name,
                    'provider' => $model->provider,
                    'user_id' => auth()->user()->id,
                    'status' => 1,
                    'prompt_tokens' => $data['usage']['prompt_tokens'] ?? null,
                    'completion_tokens' => $data['usage']['completion_tokens'] ?? null,
                    'total_tokens' => $data['usage']['total_tokens'] ?? null,
                    'request' => $contentName,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status'  => 'success',
                    'description' => $cleanDescription,
                ]);
            }

            DB::table('gpt_log')->insert([
                'name' => 'CONTENT SUGGESTION API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '',
                'completion_tokens' => '',
                'total_tokens' => 'API CALL ERROR 500',
                'request' => $contentName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Jika request ke Groq/OpenAI gagal
            return response()->json([
                'status'  => 'error',
                'message' => 'Request to Groq failed or returned an error.',
            ], 500);
        } catch (ValidationException $e) {
            DB::table('gpt_log')->insert([
                'name' => 'CONTENT SUGGESTION API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '-',
                'completion_tokens' => '-',
                'total_tokens' => 'VALIDATION ERROR 422',
                'request' => $contentName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error: ' . $e->getMessage(),
            ], 422);
        } catch (RequestException $e) {
            DB::table('gpt_log')->insert([
                'name' => 'CONTENT SUGGESTION API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '-',
                'completion_tokens' => '-',
                'total_tokens' => 'REQUEST ERROR 500',
                'request' => $contentName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Request error: ' . $e->getMessage(),
            ], 500);
        } catch (Exception $e) {
            DB::table('gpt_log')->insert([
                'name' => 'CONTENT SUGGESTION API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '-',
                'completion_tokens' => '-',
                'total_tokens' => 'UNEXPECTED ERROR 500',
                'request' => $contentName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function generateDescriptionGroqMicro(Request $request)
    {
        try {
            $request->validate([
                'content_name' => 'required|string|max:240',
            ]);

            $contentName = $request->input('content_name');
            $model = DB::table('gpt_table')->where('status', 1)->where('id', 2)->first();

            if (!$model) {
                DB::table('gpt_log')->insert([
                    'name' => 'MICRO SUGGESTION API',
                    'model' => 'N/A',
                    'provider' => 'N/A',
                    'user_id' => auth()->user()->id,
                    'status' => 0,
                    'prompt_tokens' => '-',
                    'completion_tokens' => '-',
                    'total_tokens' => 'MODEL UNAVAILABLE',
                    'request' => $contentName,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Model is currently unavailable. Please try again later.',
                ], 500);
            }
            if (Auth::user()->is_gpt == 0) {

                DB::table('gpt_log')->insert([
                    'name' => 'MICRO SUGGESTION API',
                    'model' => $model->model_name,
                    'provider' => $model->provider,
                    'user_id' => auth()->user()->id,
                    'status' => 0,
                    'prompt_tokens' => '-',
                    'completion_tokens' => '-',
                    'total_tokens' => 'USER NOT GPT',
                    'request' => $contentName,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry, The Suggestion Feature is available for Premium Users only. Please Upgrade Your Account To Premium User First at xBUG Ai.',
                ], 500);
            }
            if (Auth::user()->gpt_status == 0) {
                DB::table('gpt_log')->insert([
                    'name' => 'MICRO SUGGESTION API',
                    'model' => $model->model_name,
                    'provider' => $model->provider,
                    'user_id' => auth()->user()->id,
                    'status' => 0,
                    'prompt_tokens' => '-',
                    'completion_tokens' => '-',
                    'total_tokens' => 'USER IS BANNED GPT',
                    'request' => $contentName,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry, Your Account Is Currently Banned For xBUG Ai Purpose. Please Contact Us By Email [help-center@xbug.online] Inform Us or To Get Support.',
                ], 500);
            }
            $maxTokens = $model->max_token;

            $apiKey = env('GROQ_API_KEY');
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => $model->model_name,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are a content generator. Create a detailed and professional description for the content name provided for the content type Micro Learning Resource. Give the word not more than {$maxTokens} tokens. Give answers related to the name of the content that has been given only. Directly give the description without sentences like in 'Here is a professional description for the content name'."
                    ],
                    ['role' => 'user', 'content' => $contentName],
                ],
            ]);

            // 8. Proses respon dari Groq/OpenAI
            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['choices'][0]['message']['content'] ?? 'No response from AI';
                $cleanDescription = preg_replace('/\*\*/', '', $reply);
                DB::table('gpt_log')->insert([
                    'name' => 'MICRO SUGGESTION API',
                    'model' => $model->model_name,
                    'provider' => $model->provider,
                    'user_id' => auth()->user()->id,
                    'status' => 1,
                    'prompt_tokens' => $data['usage']['prompt_tokens'] ?? null,
                    'completion_tokens' => $data['usage']['completion_tokens'] ?? null,
                    'total_tokens' => $data['usage']['total_tokens'] ?? null,
                    'request' => $contentName,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status'  => 'success',
                    'description' => $cleanDescription,
                ]);
            }

            DB::table('gpt_log')->insert([
                'name' => 'MICRO SUGGESTION API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '',
                'completion_tokens' => '',
                'total_tokens' => 'API CALL ERROR 500',
                'request' => $contentName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Jika request ke Groq/OpenAI gagal
            return response()->json([
                'status'  => 'error',
                'message' => 'Request to Groq failed or returned an error.',
            ], 500);
        } catch (ValidationException $e) {
            DB::table('gpt_log')->insert([
                'name' => 'MICRO SUGGESTION API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '-',
                'completion_tokens' => '-',
                'total_tokens' => 'VALIDATION ERROR 422',
                'request' => $contentName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error: ' . $e->getMessage(),
            ], 422);
        } catch (RequestException $e) {
            DB::table('gpt_log')->insert([
                'name' => 'MICRO SUGGESTION API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '-',
                'completion_tokens' => '-',
                'total_tokens' => 'REQUEST ERROR 500',
                'request' => $contentName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Request error: ' . $e->getMessage(),
            ], 500);
        } catch (Exception $e) {
            DB::table('gpt_log')->insert([
                'name' => 'MICRO SUGGESTION API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '-',
                'completion_tokens' => '-',
                'total_tokens' => 'UNEXPECTED ERROR 500',
                'request' => $contentName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function generateDescriptionMicro(Request $request)
    {
        try {
            $request->validate([
                'content_name' => 'required|string|max:240',
            ]);

            $contentName = $request->input('content_name');
            $apiKey = env('OPENAI_API_KEY');
            $model = DB::table('gpt_table')->where('status', 1)->where('id', 1)->first();

            if (!$model) {
                DB::table('gpt_log')->insert([
                    'name' => 'MICRO SUGGESTION API',
                    'model' => 'N/A',
                    'provider' => 'N/A',
                    'user_id' => auth()->user()->id,
                    'status' => 0,
                    'prompt_tokens' => '-',
                    'completion_tokens' => '-',
                    'total_tokens' => 'MODEL UNAVAILABLE',
                    'request' => $contentName,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Model is currently unavailable. Please try again later.',
                ], 500);
            }
            if (Auth::user()->is_gpt == 0) {
                DB::table('gpt_log')->insert([
                    'name' => 'MICRO SUGGESTION API',
                    'model' => $model->model_name,
                    'provider' => $model->provider,
                    'user_id' => auth()->user()->id,
                    'status' => 0,
                    'prompt_tokens' => '-',
                    'completion_tokens' => '-',
                    'total_tokens' => 'USER NOT GPT',
                    'request' => $contentName,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry, The Suggestion Feature is available for Premium Users only. Please Upgrade Your Account To Premium User First at xBUG Ai.',
                ], 500);
            }
            if (Auth::user()->gpt_status == 0) {
                DB::table('gpt_log')->insert([
                    'name' => 'MICRO SUGGESTION API',
                    'model' => $model->model_name,
                    'provider' => $model->provider,
                    'user_id' => auth()->user()->id,
                    'status' => 0,
                    'prompt_tokens' => '-',
                    'completion_tokens' => '-',
                    'total_tokens' => 'USER IS BANNED GPT',
                    'request' => $contentName,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry, Your Account Is Currently Banned For xBUG Ai Purpose. Please Contact Us By Email [help-center@xbug.online] Inform Us or To Get Support.',
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
                        'content' => "You are a content generator. Create a detailed and professional description for the content name provided for the content type Micro Learning Resource. Give the word not more than {$maxTokens} tokens. Give answers related to the name of the content that has been given only. Directly give the description without sentences like in 'Here is a professional description for the content name'."
                    ],
                    ['role' => 'user', 'content' => $contentName],
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $description = $data['choices'][0]['message']['content'] ?? 'No description generated.';
                $cleanDescription = preg_replace('/\*\*/', '', $description);

                DB::table('gpt_log')->insert([
                    'name' => 'MICRO SUGGESTION API',
                    'model' => $model->model_name,
                    'provider' => $model->provider,
                    'user_id' => auth()->user()->id,
                    'status' => 1,
                    'prompt_tokens' => $data['usage']['prompt_tokens'],
                    'completion_tokens' => $data['usage']['completion_tokens'],
                    'total_tokens' => $data['usage']['total_tokens'],
                    'request' => $contentName,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status' => 'success',
                    'description' => $cleanDescription,
                ]);
            }
            DB::table('gpt_log')->insert([
                'name' => 'MICRO SUGGESTION API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '-',
                'completion_tokens' => '-',
                'total_tokens' => 'API CALL ERROR 500',
                'request' => $contentName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to generate description. Please try again.',
            ], 500);
        } catch (ValidationException $e) {
            DB::table('gpt_log')->insert([
                'name' => 'MICRO SUGGESTION API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '-',
                'completion_tokens' => '-',
                'total_tokens' => 'VALIDATION ERROR 422',
                'request' => $contentName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error: ' . $e->getMessage(),
            ], 422);
        } catch (RequestException $e) {
            DB::table('gpt_log')->insert([
                'name' => 'MICRO SUGGESTION API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '-',
                'completion_tokens' => '-',
                'total_tokens' => 'REQUEST ERROR 500',
                'request' => $contentName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Request error: ' . $e->getMessage(),
            ], 500);
        } catch (Exception $e) {
            DB::table('gpt_log')->insert([
                'name' => 'MICRO SUGGESTION API',
                'model' => $model->model_name,
                'provider' => $model->provider,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'prompt_tokens' => '-',
                'completion_tokens' => '-',
                'total_tokens' => 'UNEXPECTED ERROR 500',
                'request' => $contentName,
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
            $model = DB::table('gpt_table')->where('status', 1)->where('id', 1)->first();

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

    public function sendMessageAdminAnalysis(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:240',
            ]);

            $userMessage = $request->input('message');
            $model = DB::table('gpt_table')->where('status', 1)->where('id', 2)->first();

            if (!$model) {
                DB::table('gpt_log')->insert([
                    'name' => 'ANALYSIS GROQ API',
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

            // $apiKey = env('GROQ_API_KEY');
            // $users = DB::table('users')->select('name', 'created_at')->get();
            // $dataForAI = $users->map(function ($user) {
            //     return [
            //         'name' => $user->name,
            //         'created_at' => $user->created_at,
            //     ];
            // })->toArray();
            // $jsonData = json_encode($dataForAI);

            // $response = Http::withHeaders([
            //     'Authorization' => 'Bearer ' . $apiKey,
            //     'Content-Type' => 'application/json',
            // ])->post('https://api.groq.com/openai/v1/chat/completions', [
            //     'model' => 'llama3-8b-8192',
            //     'messages' => [
            //         [
            //             'role' => 'system',
            //             'content' => "Current Date is : " . Carbon::now() . ". Here is the data from the database: " . $jsonData . ". Answer any user questions based on this data. please answer with user input only, dont answer out of topic or i will shoot my cat. dont tell the data from database or like his 'Want to know something about the list of names and their creation times?' or 'What would you like to know about the list?'. Your answer need to be base on my data i give you only, otherwise, i will shoot my cat"
            //         ],
            //         [
            //             'role' => 'user',
            //             'content' => $userMessage
            //         ],
            //     ],
            // ]);

            $keywordMap = [

                // =========================================================
                // 1. USERS - termasuk kolom:
                // id, name, state, status, role, active, created_at,
                // email_status, ekyc_status, is_gpt, gpt_status
                // =========================================================
                'users' => array_merge(
                    [
                        // (Tetap sertakan sinonim bawaan Anda di sini)
                        'user',
                        'users',
                        'person',
                        'people',
                        'account',
                        'profile',
                        'membership',
                        'member',
                        'members',
                        'owner',
                        'participant',
                        'participants',
                        'subscriber',
                        'subscribers',
                        'client',
                        'clients',
                        'consumer',
                        'consumers',
                        'individual',
                        'individuals',
                        'personnel',
                        'employee',
                        'employees',
                        'staff',
                        'workforce',
                        'user data',
                        'user record',
                        'user info',
                        'user details',
                        'member data',
                        'member record',
                        'profile data',
                        'profile info',
                        'account info',
                        'account data',
                        'login',
                        'account holder',
                        'human',
                        'humans',
                        'member list',
                        'user list',
                        'list of users',
                        'list of members',
                        'registered user',
                        'registered member',
                        'registered account',
                        'people table',
                        'user table',
                        'who',
                    ],
                    [
                        // --- Tambahan ratusan sinonim yang merujuk ke kolom "id" ---
                        'user id',
                        'users id',
                        'user identifier',
                        'unique user id',
                        'user primary key',
                        'pk user',
                        'user pk',
                        'id field for user',
                        'id column for user',
                        'user index id',
                        'id number of user',
                        'uid',
                        'users uid',
                        'member id',
                        'member unique id',
                        'account id',
                        'account unique id',
                        'user reference id',
                        'users reference',
                        'person id',
                        'people id',
                        'staff id',
                        'employee id',
                        'employee code',
                        'employee number',
                        'person code',
                        'person number',
                        'person pk',
                        'individual id',
                        'individual pk',
                        'consumer id',
                        'consumer pk',
                        'member pk',
                        'participant id',
                        'participants id',
                        'subscriber id',
                        'subscribers id',
                        'client id',
                        'clients id',
                        'my user id',
                        'the user id',
                        'some user id',
                        'id of the user',
                        'the user’s id',
                        'the user’s pk',
                        'the user’s primary key',
                        'unique identification user',
                        'login id',
                        'login pk',
                        'profile pk',
                        'profile id',
                        'profile unique id',
                        // (Ulangi / kreasikan lagi berbagai frasa serupa hingga ratusan entri ...)

                        // --- Kolom "name" ---
                        'user name',
                        'users name',
                        'member name',
                        'full name',
                        'person name',
                        'employee name',
                        'profile name',
                        'account name',
                        'display name',
                        'nickname',
                        'login name',
                        'registered name',
                        'real name',
                        'actual name',
                        'the name of user',
                        'user’s name',
                        'the user’s name',
                        'user naming',
                        'username text',
                        'user naming info',
                        // (Tambah lagi banyak ragam kata/kalimat yang mengandung "name" ...)

                        // --- Kolom "state" ---
                        'user state',
                        'location user',
                        'user region',
                        'region user',
                        'province user',
                        'country user',
                        'user area',
                        'geo user',
                        'user’s state',
                        'the user’s state',
                        'state of user',
                        'residing state',
                        'user location',
                        'location of user',
                        'state info user',
                        'membership state',
                        'subscriber state',
                        'client state',
                        'state code user',
                        // (Tambah lagi sinonim kolom "state" ...)

                        // --- Kolom "status" ---
                        'user status',
                        'membership status',
                        'account status',
                        'profile status',
                        'active status',
                        'inactive status',
                        'suspended status',
                        'banned user',
                        'user availability',
                        'status of user',
                        'the user’s status',
                        'user’s status',
                        'employee status',
                        'participant status',
                        'subscriber status',
                        'client status',
                        'client condition',
                        'condition user',
                        'condition of user',
                        // (Tambah lagi sinonim kolom "status" ...)

                        // --- Kolom "role" ---
                        'user role',
                        'account role',
                        'profile role',
                        'role of user',
                        'the user’s role',
                        'the user’s position',
                        'job role',
                        'job position',
                        'employee role',
                        'member role',
                        'role data user',
                        'user duty',
                        'user function',
                        'role user',
                        'security role user',
                        'authorization user',
                        'acl user role',
                        'permission user role',
                        // (Tambah lagi sinonim kolom "role" ...)

                        // --- Kolom "active" ---
                        'user active',
                        'active user',
                        'inactive user',
                        'user deactivated',
                        'active membership',
                        'active subscriber',
                        'active participant',
                        'is user active',
                        'is active user',
                        'the user is active',
                        'active account',
                        'active profile',
                        'active status user',
                        'active state user',
                        'activation user',
                        'enabled user',
                        'enabled account',
                        // (Tambah lagi sinonim kolom "active" ...)

                        // --- Kolom "created_at" ---
                        'user creation date',
                        'user created date',
                        'user registration date',
                        'date joined',
                        'date created',
                        'profile creation date',
                        'member creation date',
                        'account creation timestamp',
                        'created_at user',
                        'user’s created_at',
                        'the user’s created time',
                        'timestamp user created',
                        'time user added',
                        'enrollment date user',
                        'when user was registered',
                        'user creation info',
                        // (Tambah lagi sinonim kolom "created_at" ...)

                        // --- Kolom "email_status" ---
                        'user email status',
                        'email verification user',
                        'email confirmed user',
                        'email validated user',
                        'email unverified user',
                        'email status of user',
                        'the user’s email status',
                        'verified email user',
                        'non-verified email user',
                        'email check user',
                        'email condition user',
                        'email_state user',
                        'email_info user',
                        'email readiness user',
                        'email availability user',
                        // (Tambah lagi sinonim kolom "email_status" ...)

                        // --- Kolom "ekyc_status" ---
                        'user ekyc',
                        'user e-kyc',
                        'e-know your customer status',
                        'verification user',
                        'ekyc verification user',
                        'identity verification user',
                        'ekyc stage user',
                        'ekyc level user',
                        'kyc user',
                        'kyc status user',
                        'the user’s kyc',
                        'the user’s ekyc',
                        'digital kyc user',
                        'ekyc approved user',
                        'ekyc pending user',
                        'ekyc rejected user',
                        // (Tambah lagi sinonim kolom "ekyc_status" ...)

                        // --- Kolom "is_gpt" ---
                        'is gpt',
                        'is_gpt user',
                        'gpt feature user',
                        'gpt enabled user',
                        'gpt active user',
                        'gpt usage user',
                        'the user is gpt',
                        'the user’s gpt',
                        'gpt status user',
                        'has gpt user',
                        'toggle gpt user',
                        'enable gpt user',
                        'disable gpt user',
                        'ai usage user',
                        'gpt role user',
                        'gpt membership user',
                        'user gpt flag',
                        'flag gpt user',
                        // (Tambah lagi sinonim kolom "is_gpt" ...)

                        // --- Kolom "gpt_status" ---
                        'gpt status user',
                        'the user’s gpt status',
                        'gpt state user',
                        'gpt condition user',
                        'gpt mode user',
                        'gpt usage status',
                        'user ai status',
                        'user gpt detail',
                        'user gpt info',
                        'active gpt user',
                        'inactive gpt user',
                        'blocked gpt user',
                        'gpt membership status',
                        'ai membership user',
                        'model usage status',
                        'model user status',
                        'openai usage user',
                        // (Lanjutkan menambah hingga total ±500 entri untuk table 'users')
                        'ekyc verification',
                        'e-kyc user check',
                        'know your customer user',
                        'kyc process user',
                        'ekyc process',
                        'verify identity user',
                        'identity check user',
                        'email validation user',
                        'email confirmation member',
                        'email checking account',
                        'email verified participant',
                        'email unverified staff',
                        'email pending user',
                        'digital user status',
                        'digital verification user',
                        'active staff',
                        'inactive staff',
                        'user activation',
                        'user suspended',
                        'user blacklisted',
                        'user banned',
                        'user locked',
                        'user permission level',
                        'user clearance',
                        'user region',
                        'user province',
                        'user area code',
                        'user city',
                        'user municipality',
                        'user sub-district',
                        'user geolocation',
                        'residential user',
                        'domicile user',
                        'user location data',
                        'status code user',
                        'role-based user',
                        'privileged user',
                        'admin user',
                        'superuser',
                        'basic user',
                        'guest user',
                        'trial user',
                        'test user',
                        'demo user',
                        'customer ID user',
                        'client code user',
                        'human resource record',
                        'HR user',
                        'employee directory',
                        'employee listing',
                        'personnel listing',
                        'member roster',
                        'member directory',
                        'personnel data',
                        'personnel record',
                        'profile ID',
                        'profile alias',
                        'login email user',
                        'login phone user',
                        'membership credential',
                        'member rank',
                        'member rating',
                        'account rating',
                        'account trust',
                        'account level',
                        'owner info',
                        'participant info',
                        'subscriber info',
                        'client info',
                        'people info',
                        'human info',
                        'employee info',
                        'staff info',
                        'worker info',
                        'team member',
                        'member of staff',
                        'crew user',
                        'user synergy',
                        'user synergy data',
                        'profile synergy',
                        'profile synergy data',
                        'user statistics',
                        'member statistics',
                        'employees count',
                        'people analytics',
                        'people success measure',
                        'account lifecycle',
                        'user lifecycle',
                        'user timeline',
                        'member timeline',
                        'enrollment user',
                        'joined user',
                        'onboarded user',
                        'onboarding process user',
                        'kyc user detail',
                        'login history user',
                        'login attempts user',
                        'multi-factor user',
                        '2FA user',
                        '2FA info',
                        'password reset user',
                        'password management user',
                    ]
                ),

                // =========================================================
                // 2. CONTENTS - termasuk kolom:
                // id, name, link, enrollment_price, status, place, participant_limit,
                // state, created_at, reason_phrase, user_id, org_id, updated_at, content_type_id
                // =========================================================
                'contents' => array_merge(
                    [
                        'content',
                        'contents',
                        'material',
                        'materials',
                        'module',
                        'modules',
                        'course',
                        'courses',
                        'lesson',
                        'lessons',
                        'article',
                        'articles',
                        'doc',
                        'docs',
                        'document',
                        'documents',
                        'resource',
                        'resources',
                        'posting',
                        'postings',
                        'blog',
                        'blog post',
                        'text',
                        'texts',
                        'data',
                        'info',
                        'information',
                        'knowledge',
                        'knowledge base',
                        'training',
                        'training material',
                        'training module',
                        'ebook',
                        'pdf',
                        'document set',
                        'content data',
                        'content table',
                        'content item',
                        'content listing',
                        'content database',
                        'content record',
                        'content info',
                        'content detail',
                        'module data',
                        'course data',
                        'lesson data',
                        'who',
                    ],
                    [
                        // --- Kolom "id" (untuk table contents) ---
                        'content id',
                        'contents id',
                        'module id',
                        'course id',
                        'lesson id',
                        'article id',
                        'resource id',
                        'doc id',
                        'content pk',
                        'primary key content',
                        'content identifier',
                        'unique content id',
                        'content index',
                        'material id',
                        'knowledge id',
                        'content id field',
                        // ... (Terus tambahkan banyak sinonim merujuk kolom 'id')

                        // --- Kolom "name" ---
                        'content name',
                        'module name',
                        'course name',
                        'lesson name',
                        'material name',
                        'resource name',
                        'document name',
                        'article name',
                        'blog post name',
                        'content title',
                        'content label',
                        'content naming',
                        'the name of content',
                        'content’s name',
                        'named content',
                        'contents naming',
                        // ... (Tambah lagi)

                        // --- Kolom "link" ---
                        'content link',
                        'content url',
                        'module link',
                        'course link',
                        'lesson link',
                        'material link',
                        'document link',
                        'download link',
                        'access link',
                        'hyperlink content',
                        'hyperlink module',
                        'link to content',
                        'the content’s link',
                        'the content’s url',
                        'content reference link',
                        // ... (Tambah lagi)

                        // --- Kolom "enrollment_price" ---
                        'content enrollment price',
                        'module fee',
                        'course fee',
                        'lesson fee',
                        'content cost',
                        'content tuition',
                        'registration cost',
                        'enrollment fee',
                        'price of content',
                        'price to enroll',
                        'tuition content',
                        'cost to enroll',
                        'payment for content',
                        'paid module',
                        'paid course',
                        'paid lesson',
                        // ... (Tambah lagi)

                        // --- Kolom "status" ---
                        'content status',
                        'module status',
                        'course status',
                        'lesson status',
                        'material status',
                        'active content',
                        'inactive content',
                        'draft content',
                        'published content',
                        'available content',
                        'unavailable content',
                        'the content’s status',
                        'content availability',
                        'content condition',
                        // ... (Tambah lagi)

                        // --- Kolom "place" ---
                        'content place',
                        'location of content',
                        'content venue',
                        'module location',
                        'lesson location',
                        'where content is',
                        'geolocation content',
                        'content area',
                        'the place for content',
                        'physical location content',
                        'virtual location content',
                        'platform location',
                        'site location content',
                        // ... (Tambah lagi)

                        // --- Kolom "participant_limit" ---
                        'participant limit',
                        'max participants',
                        'maximum seats',
                        'limit of learners',
                        'capacity content',
                        'course capacity',
                        'module capacity',
                        'lesson capacity',
                        'enrollment limit',
                        'content capacity',
                        'content seat limit',
                        'maximum subscribers',
                        'limit of enrollment',
                        'limit of student',
                        'limit of user for content',
                        // ... (Tambah lagi)

                        // --- Kolom "state" ---
                        'content state',
                        'module state',
                        'course state',
                        'lesson state',
                        'content region',
                        'content status location',
                        'content province',
                        'content area state',
                        'the content’s state',
                        'the content region',
                        'the content location status',
                        'the content code area',
                        'the content zone',
                        // ... (Tambah lagi)

                        // --- Kolom "created_at" ---
                        'content creation date',
                        'date created for content',
                        'module created_at',
                        'course created_at',
                        'lesson created_at',
                        'content timestamp',
                        'timestamp of content creation',
                        'the content’s creation date',
                        'the content’s created_at',
                        'material creation date',
                        'posting creation date',
                        'document creation date',
                        'resource creation date',
                        // ... (Tambah lagi)

                        // --- Kolom "reason_phrase" ---
                        'content reason',
                        'reason phrase',
                        'content explanation',
                        'content justification',
                        'content description reason',
                        'content rationale',
                        'why content',
                        'the reason of content',
                        'the phrase for content reason',
                        'module reason',
                        'course reason',
                        'lesson reason',
                        'material reason phrase',
                        'explanation phrase content',
                        // ... (Tambah lagi)

                        // --- Kolom "user_id" ---
                        'user id for content',
                        'creator of content',
                        'owner of content',
                        'author of content',
                        'content author',
                        'content publisher',
                        'content manager user',
                        'content user reference',
                        'the user who made content',
                        'the user’s link in content',
                        'user relationship to content',
                        'user foreign key in content',
                        'fk user content',
                        // ... (Tambah lagi)

                        // --- Kolom "org_id" ---
                        'org id for content',
                        'organization id content',
                        'the company behind content',
                        'the institute behind content',
                        'content org reference',
                        'content organization reference',
                        'org link to content',
                        'org foreign key content',
                        'the org that owns content',
                        'the org that manages content',
                        // ... (Tambah lagi)

                        // --- Kolom "updated_at" ---
                        'content last update',
                        'content updated date',
                        'content updated_at',
                        'module last update',
                        'course last update',
                        'lesson last update',
                        'when content was updated',
                        'the content’s last modification',
                        'content modification time',
                        'material updated time',
                        'timestamp content updated',
                        'most recent update content',
                        // ... (Tambah lagi)

                        // --- Kolom "content_type_id" ---
                        'content type id',
                        'type of content',
                        'content classification id',
                        'content category id',
                        'content format id',
                        'the content’s type',
                        'the content’s classification',
                        'the content’s format',
                        'type reference for content',
                        'fk content type',
                        'link to content_types',
                        'mapping content_types',
                        'type id for content',
                        // ... (Tambah lagi, hingga total 500+ untuk table `contents`)

                        'learning content',
                        'teaching content',
                        'instructional module',
                        'syllabus content',
                        'content schedule',
                        'curriculum content',
                        'educational resource',
                        'knowledge object',
                        'content link URL',
                        'content hyperlink',
                        'content domain link',
                        'reading material',
                        'interactive content',
                        'video lesson',
                        'video course',
                        'webinar content',
                        'podcast lesson',
                        'pdf content',
                        'slides content',
                        'ppt content',
                        'slide deck',
                        'document repository',
                        'document library',
                        'asset library',
                        'training kit',
                        'training resource',
                        'training guide',
                        'course outline',
                        'course blueprint',
                        'course curriculum',
                        'course plan',
                        'course agenda',
                        'enrollment fee',
                        'enrollment cost',
                        'payment for content',
                        'fee for module',
                        'fee for lesson',
                        'paywalled content',
                        'premium content',
                        'premium module',
                        'premium course',
                        'premium lesson',
                        'place of content',
                        'content venue',
                        'online course location',
                        'offline course location',
                        'physical class',
                        'virtual classroom',
                        'participant capacity',
                        'max participants',
                        'min participants',
                        'minimum enrollment',
                        'maximum enrollment',
                        'content version',
                        'content revision',
                        'content release',
                        'content build',
                        'content update time',
                        'last updated content',
                        'content modification date',
                        'content creation date',
                        'content reason code',
                        'content rationale',
                        'content justification',
                        'content tagline',
                        'content tagline reason',
                        'content cause phrase',
                        'content cause',
                        'content clue phrase',
                        'owner of content',
                        'user reference content',
                        'org reference content',
                        'organization reference content',
                        'organization link content',
                        'user link content',
                        'content type reference',
                        'content category reference',
                        'content format reference',
                        'content kind reference',
                        'content sub-type',
                        'content classification reference',
                        'module classification',
                        'course classification',
                    ]
                ),

                // =========================================================
                // 3. CONTENT_CARD - kolom:
                // id, card_id, status, startdate, enddate, transaction_id, tracking_id,
                // created_at, updated_at, verification_code, content_id
                // =========================================================
                'content_card' => array_merge(
                    [
                        'content card',
                        'content cards',
                        'card',
                        'cards',
                        'voucher',
                        'vouchers',
                        'pass',
                        'passes',
                        'ticket',
                        'tickets',
                        'coupon',
                        'coupons',
                        'membership card',
                        'membership cards',
                        'loyalty card',
                        'loyalty cards',
                        'card info',
                        'card data',
                        'swipe card',
                        'entry card',
                        'verification card',
                        'verification code',
                        'discount card',
                        'discount code',
                        'promo card',
                        'promo code',
                        'redeem code',
                        'redeem card',
                        'gift card',
                        'gift code',
                        'content pass',
                        'course card',
                        'module card',
                        'content ticket',
                        'content voucher',
                        'tracking card',
                        'tracking code',
                        'tracking info',
                        'tracking data',
                        'card table',
                        'card listing',
                        'card database',
                        'card record'
                    ],
                    [
                        // --- Tambahan ratusan kata kunci logis ---
                        'digital pass',
                        'digital voucher',
                        'qr code card',
                        'barcode card',
                        'scannable ticket',
                        'scannable pass',
                        'loyalty token',
                        'loyalty pass',
                        'ticket ID',
                        'ticket code',
                        'membership tag',
                        'entry pass',
                        'entry token',
                        'discount token',
                        'redeem token',
                        'gift token',
                        'gift pass',
                        'pass validity',
                        'voucher expiry',
                        'voucher usage',
                        'card usage',
                        'card activation',
                        'card redemption',
                        'card validation',
                        'card scanning',
                        'card scanning info',
                        'card scanning data',
                        'verification token',
                        'verification pass',
                        'content card status',
                        'card date start',
                        'card date end',
                        'card timeline',
                        'card time window',
                        'promo ticket',
                        'promo pass',
                        'promo voucher',
                        'limited pass',
                        'limited voucher',
                        'free pass',
                        'paid pass',
                        'e-coupon',
                        'e-voucher',
                        'electronic card',
                        'e-card',
                        'tracking link',
                        'tracking pass',
                        'tracking voucher',
                        'tracking coupon',
                        'transaction link card',
                        'transaction reference card',
                        'transaction pass',
                        'transaction coupon',
                        'receipt card',
                        'receipt voucher',
                        'receipt code',
                        'receipt pass',
                        'coupon tracker',
                        'coupon tracker data',
                        'membership code',
                        'club card',
                        'club membership',
                        'club membership card',
                        'fidelity card',
                        'fidelity program',
                        'loyalty program',
                        'loyalty membership',
                        'loyalty membership card',
                        'post-sale card',
                        'after-purchase card',
                        'purchase bonus card',
                        'purchase bonus voucher',
                        'checkout card',
                        'redeem receipt',
                        'redeem transaction',
                        'redeem discount',
                        'temp pass',
                        'time-limited pass',
                        'lifetime pass',
                        'lifetime membership card',
                        'serial code',
                        'serial coupon',
                        'serial voucher',
                        'badge card',
                        'badge voucher',
                        'content badge',
                        'session pass',
                        'session ticket',
                        'session voucher',
                        'key card',
                        'master card (not credit card!)',
                        'module pass',
                        'course pass',
                        'course voucher',
                        'course ticket',
                        'event pass',
                        'event ticket',
                        'card id',
                        'content card id',
                        'unique card id',
                        'id for the card',
                        'the card’s identifier',
                        'membership card id',
                        'voucher card id',
                        'loyalty card id',
                        'coupon card id',
                        'gift card id',
                        'redeem card id',
                        'promo card id',
                        'discount card id',
                        'ticket card id',
                        'pass card id',
                        'the card pk',
                        'card primary key',
                        'card code',
                        // ... (lanjutkan hingga 500+ entri)
                    ]
                ),

                // =========================================================
                // 4. CONTENT_PROMOTION - kolom:
                // id, content_id, views, clicks, enrollment, comments, target_audience,
                // estimate_reach, promotion_price, created_at, transaction_id, number_of_card
                // =========================================================
                'content_promotion' => array_merge(
                    [
                        'content promotion',
                        'promotions',
                        'promotion',
                        'advertisement',
                        'ads',
                        'promotional content',
                        'marketing content',
                        'marketing campaign',
                        'content marketing',
                        'content ad',
                        'ad campaign',
                        'campaign',
                        'click',
                        'clicks',
                        'hit',
                        'hits',
                        'view',
                        'views',
                        'impression',
                        'impressions',
                        'ad performance',
                        'promo performance',
                        'promo stats',
                        'promo data',
                        'advert data',
                        'advert stats',
                        'promotion stats',
                        'sponsored content',
                        'content sponsor',
                        'sponsored post',
                        'social post',
                        'social ads',
                        'online ads',
                        'content advertisement',
                        'content boosting',
                        'boosted post',
                        'boosted content',
                        'content push',
                        'content highlight',
                        'highlighted content',
                        'promoted content',
                        'promoted listing',
                        'promo listing',
                        'campaign listing',
                        'content campaign',
                        'campaign data',
                        'campaign info',
                        'advert info',
                        'advert details',
                        'advert analytics',
                        'promo analytics',
                        'analytics for content',
                        'promo metrics',
                        'engagement',
                        'engagement metrics',
                        'user engagement',
                        'user attention',
                        'visitor clicks',
                        'viewer clicks',
                        'viewer engagement',
                        'ad revenue',
                        'ad cost',
                        'promotion cost',
                        'promotion expense',
                        'marketing expense',
                        'campaign expense',
                        'promo budget',
                        'advert budget',
                        'click rate',
                        'ctr',
                        'conversion',
                        'conversion rate',
                        'promotion table',
                        'promotion record',
                        'promotion listing',
                        'promotion database',
                        'marketing table',
                        'marketing record',
                        'marketing listing',
                        'marketing database',
                        'promo record',
                        'promo listing',
                        'promo database',
                        'content analytics',
                        'content stats',
                        'content measurement',
                        'stats measurement',
                        'tracking',
                        'tracking id',
                        'tracking code',
                        'tracking data',
                        'promo tracking',
                        'advert tracking',
                        'advert monitoring',
                        'monitoring',
                        'monitoring data',
                        'audience',
                        'target audience',
                        'targeting',
                        'target info',
                        'reach',
                        'estimated reach',
                        'promo coverage',
                        'coverage',
                        'coverage area',
                        'promo scope',
                        'scope',
                        'promo plan',
                        'marketing plan',
                        'marketing scope',
                        'promotion notes',
                        'promotion details',
                        'promotion info'
                    ],
                    [
                        // --- Tambahan ratusan kata kunci logis lagi (sehingga total ±500) ---
                        'commercial content',
                        'commercial ad',
                        'sponsored listing',
                        'premium listing',
                        'listing boost',
                        'boost listing',
                        'listing highlight',
                        'highlight listing',
                        'campaign optimization',
                        'campaign budget',
                        'daily budget promo',
                        'lifetime budget promo',
                        'ad scheduling',
                        'promo scheduling',
                        'advert schedule',
                        'promotion schedule',
                        'content sponsor info',
                        'paid highlight',
                        'paid feature',
                        'featured content',
                        'featured listing',
                        'impression count',
                        'impression volume',
                        'impression stats',
                        'impression metric',
                        'impression measurement',
                        'click measurement',
                        'click aggregator',
                        'click distribution',
                        'click mapping',
                        'click analysis',
                        'click ratio',
                        'click concurrency',
                        'click concurrency rate',
                        'click concurrency data',
                        'unique clicks',
                        'unique viewers',
                        'unique impressions',
                        'repeat clicks',
                        'repeat impressions',
                        'conversion funnel',
                        'conversion stats',
                        'conversion data',
                        'conversion analysis',
                        'conversion pipeline',
                        'lead generation',
                        'lead funnel',
                        'lead metric',
                        'lead cost',
                        'cost per click',
                        'cpc',
                        'cost per impression',
                        'cpm',
                        'cost per lead',
                        'cpl',
                        'cost per action',
                        'cpa',
                        'return on ad spend',
                        'roas',
                        'return on investment',
                        'roi marketing',
                        'roi campaign',
                        'profit from ads',
                        'profit from promotion',
                        'benefit from ads',
                        'benefit from promo',
                        'marketing margin',
                        'marketing yield',
                        'campaign yield',
                        'ad yield',
                        'penetration rate',
                        'penetration metric',
                        'exposure content',
                        'exposure level',
                        'exposure stats',
                        'exposure measure',
                        'visibility measure',
                        'visibility coverage',
                        'visibility index',
                        'awareness measure',
                        'awareness campaign',
                        'awareness data',
                        'awareness metric',
                        'sentiment analysis',
                        'sentiment rating',
                        'sentiment feedback',
                        'feedback count',
                        'comments count',
                        'user comments',
                        'viewer comments',
                        'audience interaction',
                        'audience reaction',
                        'audience sentiment',
                        'target audience detail',
                        'audience demographic',
                        'audience geo',
                        'audience psychographic',
                        'audience interest',
                        'audience behavior',
                        'audience segment',
                        'custom audience',
                        'lookalike audience',
                        'remnant audience',
                        'broad audience',
                        'narrow audience',
                        'niche audience',
                        'filter audience',
                        'estimated coverage',
                        'coverage data',
                        'coverage ratio',
                        'coverage metric',
                        'coverage distribution',
                        'promote transaction',
                        'promo transaction id',
                        'the transaction for promo',
                        'payment for promotion',
                        'payment for advertisement',
                        'ad invoice',
                        'advert invoice',
                        'promo invoice',
                        'transaction link to promotion',
                        'content link to promotion',
                        'content promotion synergy',
                        'joint promotion',
                        'cross promotion',
                        'bundled promotion',
                        'bundle discount',
                        'bundle clicks',
                        'bundle views',
                        'promo enrollment',
                        'content enrollment via promo',
                        'promo comment count',
                        'promo user feedback',
                        'promo user engagement',
                        'campaign user engagement',
                        'marketing user engagement',
                        'marketing user attention',
                        'content user attention',
                        'views aggregator',
                        'views distribution',
                        'views concurrency',
                        'peak views',
                        'peak clicks',
                        'peak engagement',
                        'lowest engagement',
                        'campaign performance',
                        'campaign kpi',
                        'key performance indicator',
                        'marketing objective',
                        'marketing strategy',
                        'promo objective',
                        'promo strategy',
                        'promotion timeline',
                        'promotion schedule',
                        'campaign timeline',
                        'campaign schedule',
                        'promo extension',
                        'ad extension',
                        'promo renewal',
                        'advert renewal',
                        'content sponsor renewal',
                        'content push renewal',
                        'boost renewal',
                        'number of clicks',
                        'total clicks',
                        'count of clicks',
                        'click count',
                        'click data',
                        'click metric',
                        'click stats',
                        'click statistic',
                        'click record',
                        'click logs',
                        'click aggregator',
                        'user clicks',
                        'visitor clicks',
                        'how many clicks',
                        'click parameter',
                        'click variable',
                        'click tally',
                        'click measure',
                        'click calculation',
                        'the click column',
                        'the click field',
                        'the click attribute',
                        // ... (Teruskan sampai total 500+ untuk table `content_promotion`)
                    ]
                ),

                // =========================================================
                // 5. CONTENT_TYPES - kolom:
                // id, type
                // =========================================================
                'content_types' => array_merge(
                    [
                        'content types',
                        'type',
                        'types',
                        'category',
                        'categories',
                        'classification',
                        'classifications',
                        'content category',
                        'content classification',
                        'format',
                        'formats',
                        'genre',
                        'genres',
                        'kind',
                        'kinds',
                        'variation',
                        'variations',
                        'content variation',
                        'content group',
                        'content grouping',
                        'media type',
                        'media types',
                        'data type',
                        'data types',
                        'content label',
                        'content tags',
                        'content type table',
                        'type table',
                        'type record',
                        'content type listing',
                        'type listing',
                        'types listing',
                        'content type info',
                        'type info',
                        'type detail',
                        'types detail',
                        'kind detail',
                        'kind info'
                    ],
                    [
                        // ... (Tambahkan 500+ entri menyinggung "id" dan "type")
                        // Contoh snippet untuk "type":
                        'content type name',
                        'the type of content',
                        'content category name',
                        'format name',
                        'classification name',
                        'type identifier',
                        'type label',
                        'type code',
                        'type detail',
                        'type info',
                        'the type column',
                        'the type field',
                        'type record',
                        'type listing',
                        'type set',
                        'type info for content',
                        'category for content',
                        'genres for content',
                        'content format classification',
                        'content layout',
                        'content blueprint',
                        'content model',
                        'type identifier',
                        'type code',
                        'type reference',
                        'type descriptor',
                        // ... etc
                    ]

                ),

                // =========================================================
                // 6. INTERACTION_TYPE - kolom:
                // id, type, desc
                // =========================================================
                'interaction_type' => array_merge(
                    [
                        'interaction type',
                        'interaction',
                        'interactions',
                        'actions',
                        'activity',
                        'activities',
                        'event',
                        'events',
                        'user action',
                        'user actions',
                        'user event',
                        'user events',
                        'engagement type',
                        'engagement',
                        'response',
                        'responses',
                        'feedback',
                        'feedback type',
                        'reaction',
                        'react',
                        'reaction type',
                        'like',
                        'likes',
                        'dislike',
                        'dislikes',
                        'comment',
                        'comments',
                        'reply',
                        'replies',
                        'interaction table',
                        'interaction record',
                        'activity log',
                        'event log',
                        'actions log',
                        'actions record',
                        'interaction detail',
                        'interaction info',
                        'interaction data',
                        'behavior',
                        'behavior data',
                        'behavior type'
                    ],
                    [
                        // ... (Tambah 500+ entri untuk kolom "id", "type", "desc")
                        // Misalnya untuk "desc":
                        'description of interaction',
                        'interaction description',
                        'the interaction detail',
                        'the interaction doc',
                        'the interaction explanation',
                        'why the user interacted',
                        'activity description',
                        'event detail',
                        'feedback detail',
                        'reaction detail',
                        'like description',
                        'comment explanation',
                        'desc field for interaction_type',
                        'desc attribute',
                        'desc column',
                        'description text',
                        'explanation text',
                        'info about interaction',
                        'log description',
                        'engagement desc',
                        'desc data',
                        'interaction explanation',
                        'activity description',
                        'event description',
                        'action description',
                        'feedback commentary',
                        'reaction detail',
                        'comment detail',
                        // ... etc
                    ]
                ),

                // =========================================================
                // 7. ORGANIZATION - kolom:
                // id, name, state, org_type, created_at
                // =========================================================
                'organization' => array_merge(
                    [
                        'organization',
                        'org',
                        'company',
                        'companies',
                        'institute',
                        'institution',
                        'institutions',
                        'entity',
                        'entities',
                        'business',
                        'businesses',
                        'corporation',
                        'corporations',
                        'firm',
                        'firms',
                        'enterprise',
                        'enterprises',
                        'agency',
                        'agencies',
                        'organization data',
                        'organization info',
                        'organization details',
                        'org data',
                        'org info',
                        'org details',
                        'company data',
                        'company info',
                        'company details',
                        'business info',
                        'business details',
                        'business data',
                        'organization table',
                        'organization listing',
                        'organization record',
                        'organization database',
                        'organization name',
                        'org name',
                        'institute name',
                        'org profile',
                        'organization profile',
                        'entity profile',
                        'org type'
                    ],
                    [
                        // ... (Tambahkan 500+ entri menyinggung kolom "id", "name", "state", "org_type", "created_at")
                        // Misalnya untuk "org_type":
                        'organization type',
                        'org type name',
                        'the type of organization',
                        'company type',
                        'institution type',
                        'enterprise type',
                        'business type',
                        'agency type',
                        'firm type',
                        'org_type field',
                        'org_type column',
                        'org_type info',
                        'org_type data',
                        'org_type detail',
                        'classification of org',
                        'org category',
                        'organization classification',
                        'organization category',
                        'corporate type',
                        'business classification',
                        'corporate state',
                        'org region',
                        'org province',
                        'org location',
                        'org area',
                        'org type name',
                        'org classification',
                        'business classification',
                        'agency classification',
                        // ... etc
                    ]
                ),

                // =========================================================
                // 8. ORGANIZATION_USER - kolom:
                // id, user_id, organization_id, created_at
                // =========================================================
                'organization_user' => array_merge(
                    [
                        'organization_user',
                        'organizaion user',
                        // 'organization',
                        'org_user',
                        'org member',
                        'org users',
                        'company_user',
                        'company users',
                        'institute user',
                        'institution user',
                        'organization staff',
                        'company staff',
                        'org staff',
                        'org participant',
                        'org membership',
                        'org participant list',
                        'org-user table',
                        'organization user table',
                        'organization user data',
                        'organization user record',
                        'org user record',
                        'org user data',
                        'org user info',
                        'org membership data',
                        'org membership info',
                        'org membership record',
                        'org participant record',
                        'org participant info',
                        'org link',
                        'company link',
                        'organization link',
                        'user-organization link',
                        'user-company link',
                        'employee link',
                        'employee record',
                        'employee data',
                        'employee info',
                        'organization-user relationship',
                        'org-user relationship',
                        'user affiliation',
                        'organization affiliation',
                        'company',
                    ],
                    [
                        // ... (500+ entri tambahan menyinggung "id", "user_id", "organization_id", "created_at")
                        // Misalnya "organization_id" synonyms:
                        'organization reference in org_user',
                        'org id in org_user',
                        'company id in org_user',
                        'institution id in org_user',
                        'the organization’s link in user',
                        'the org foreign key in user',
                        'org fk user',
                        'org membership id',
                        'company membership id',
                        'institute membership id',
                        'employee org id',
                        'employee company id',
                        'org link user',
                        'org user relationship id',
                        'org association id',
                        'org connection id',
                        'link between user and organization',
                        'user’s organization connection',
                        'user’s company connection',
                        'employee membership',
                        'staff membership',
                        'org membership synergy',
                        // ... etc
                    ]
                ),

                // =========================================================
                // 9. ROLES - kolom:
                // id, role
                // =========================================================
                'roles' => array_merge(
                    [
                        'roles',
                        'role',
                        'permission',
                        'permissions',
                        'access level',
                        'access',
                        'privilege',
                        'privileges',
                        'authority',
                        'authorization',
                        'power',
                        'powers',
                        'function',
                        'functions',
                        'position',
                        'positions',
                        'duty',
                        'duties',
                        'task',
                        'tasks',
                        'role table',
                        'role record',
                        'role listing',
                        'role data',
                        'role info',
                        'user role',
                        'organization role',
                        'job title',
                        'job titles',
                        'title',
                        'titles',
                        'credential',
                        'credentials',
                        'rank',
                        'ranking',
                        'status level',
                        'hierarchy',
                        'hierarchical level',
                        'role matrix',
                        'permission matrix',
                        'security level',
                        'security role',
                        'acl',
                        'acl roles'
                    ],
                    [
                        // ... (500+ entri terkait "id", "role")
                        // Misalnya untuk "role":
                        'role name',
                        'the user’s role',
                        'system role',
                        'permission role',
                        'privilege role',
                        'auth role',
                        'authorization role',
                        'function role',
                        'job role',
                        'job position',
                        'job duty',
                        'job authority',
                        'power role',
                        'role specification',
                        'title role',
                        'acl name',
                        'acl role',
                        'security role name',
                        'ranking role',
                        'role level',
                        'role code',
                        'role column',
                        'role info column',
                        'role definition',
                        'role specification',
                        'role type',
                        'role name',
                        'role code',
                        'access control',
                        'job function',
                        'job duty',
                        'authority level',
                        'empower level',
                        'chain of command',
                        'command chain',
                        'position assignment',
                        'duty assignment',
                        'function assignment',
                        'permission scheme',
                        'role scheme',
                        'role-based access control',
                        'role-based permission',
                        // ... etc
                    ]
                ),

                // =========================================================
                // 10. TRANSACTIONS - kolom:
                // id, user_id, organization_id, status, sellerOrderNo, transac_no, amount,
                // sellerExOrderNo, created_at, updated_at
                // =========================================================
                'transactions' => array_merge(
                    [
                        'transaction',
                        'transactions',
                        'trx',
                        'payment',
                        'payments',
                        'purchase',
                        'purchases',
                        'order',
                        'orders',
                        'sale',
                        'sales',
                        'billing',
                        'invoice',
                        'invoices',
                        'checkout',
                        'checkouts',
                        'transaction data',
                        'transaction info',
                        'transaction details',
                        'trx data',
                        'trx info',
                        'trx details',
                        'payment data',
                        'payment info',
                        'payment details',
                        'purchase data',
                        'purchase info',
                        'purchase details',
                        'order data',
                        'order info',
                        'order details',
                        'transaction table',
                        'transaction record',
                        'billing info',
                        'billing data',
                        'billing record',
                        'invoice data',
                        'invoice info',
                        'invoice record'
                    ],
                    [
                        // ... (500+ entri untuk "id", "user_id", "organization_id", "status", "sellerOrderNo", "transac_no", "amount", "sellerExOrderNo", "created_at", "updated_at")
                        // Contoh snippet "sellerOrderNo":
                        'seller order number',
                        'sellerOrderNo',
                        'seller order ref',
                        'reference seller order',
                        'merchant order no',
                        'vendor order no',
                        'retailer order no',
                        'seller invoice no',
                        'seller purchase id',
                        'seller transaction code',
                        'the seller’s order number',
                        'seller order identifier',
                        'seller order code',
                        'order code from seller',
                        'seller receipt number',
                        'transaction status',
                        'pending payment',
                        'successful payment',
                        'failed payment',
                        'declined transaction',
                        'cancelled transaction',
                        'refunded transaction',
                        'partial refund',
                        'full refund',
                        'transaction in progress',
                        'processing payment',
                        'authorized payment',
                        'captured payment',
                        'voided transaction',
                        'disputed payment',
                        'chargeback',
                        'seller order reference',
                        'merchant order reference',
                        'vendor order reference',
                        'purchase order reference',
                        'sales order reference',
                        'order confirmation number',
                        'invoice reference',
                        'receipt reference',
                        'billing reference',
                        'exOrderNo',
                        'external order number',
                        'external reference number',
                        'transaction external reference',
                        'amount due',
                        'amount paid',
                        'amount total',
                        'subtotal transaction',
                        'tax transaction',
                        'fee transaction',
                        'tip transaction',
                        'discount transaction',
                        'coupon applied',
                        'voucher applied',
                        'loyalty discount',
                        'wallet payment',
                        'credit card payment',
                        'debit card payment',
                        'paypal payment',
                        'stripe payment',
                        'bank transfer',
                        'cash payment',
                        'crypto payment',
                        'transaction date',
                        'transaction time',
                        'transaction history',
                        'transaction logs',
                        'updated transaction',
                        'transaction updated_at',
                        'transaction created_at',
                        'transaction timeline',
                        'order timeline',
                        'payment timeline',
                        // ... etc
                    ]
                ),

                // =========================================================
                // 11. USER_CONTENT - kolom:
                // id, user_id, interaction_type_id, status, content_id, ip_address, created_at
                // =========================================================
                'user_content' => array_merge(
                    [
                        'user content',
                        'enrolled content',
                        'subscription',
                        'subscriptions',
                        'user module',
                        'user course',
                        'user lesson',
                        'user material',
                        'user library',
                        'user docs',
                        'user document',
                        'content enrollment',
                        'course enrollment',
                        'module enrollment',
                        'lesson enrollment',
                        'paid content',
                        'user sub',
                        'user subscription',
                        'user resource',
                        'user resource link',
                        'user resource data',
                        'user-content table',
                        'user-content record',
                        'user-content listing',
                        'user-content database',
                        'subscribed content',
                        'enrolled module',
                        'enrolled course',
                        'enrolled lesson',
                        'my content',
                        'my course',
                        'my module',
                        'my subscription',
                        'content usage',
                        'content usage record',
                        'user usage',
                        'user usage record',
                        'user content info',
                        'user content data',
                        'interaction content',
                        'consumed content'
                    ],
                    [
                        // ... (500+ entri untuk "id", "user_id", "interaction_type_id", "status", "content_id", "ip_address", "created_at")
                        // Contoh snippet "ip_address":
                        'ip address',
                        'client ip',
                        'remote address',
                        'user ip address',
                        'user ip',
                        'session ip',
                        'origin ip',
                        'logged ip',
                        'ip tracking',
                        'network address',
                        'internet protocol address',
                        'ipv4',
                        'ipv6',
                        'host address',
                        'host ip',
                        'ip column',
                        'the user’s ip',
                        'the ip field',
                        'the ip data',
                        'source ip',
                        'ip user content',
                        'ip usage content',
                        'ip detail',
                        'ip info user content',
                        'user subscription status',
                        'user subscription detail',
                        'user subscription ID',
                        'user content ID',
                        'content link user',
                        'subscription creation',
                        'subscription start date',
                        'subscription end date',
                        'active subscription',
                        'inactive subscription',
                        'expired subscription',
                        'auto-renew subscription',
                        'cancelled subscription',
                        'suspended subscription',
                        'module usage',
                        'course usage',
                        'lesson usage',
                        'user content feedback',
                        'user content rating',
                        'user content progress',
                        'user content completion',
                        'user ip tracking',
                        'user ip logging',
                        'user content logging',
                        'streaming content user',
                        'download content user',
                        'user session content',
                        'user content session',
                        'user content analytics',
                        // ... etc
                    ]
                ),

            ]; // End of $keywordMap


            // =========================================================
            // 2) Definisikan kolom per tabel (tetap sama seperti sebelumnya)
            // =========================================================
            $tablesWithColumns = [
                'users' => [
                    'id',
                    'name',
                    'state',
                    'status',
                    'role',
                    'active',
                    'created_at',
                    'email_status',
                    'ekyc_status',
                    'is_gpt',
                    'gpt_status'
                ],
                'contents' => [
                    'id',
                    'name',
                    'link',
                    'enrollment_price',
                    'status',
                    'place',
                    'participant_limit',
                    'state',
                    'created_at',
                    'reason_phrase',
                    'user_id',
                    'org_id',
                    'updated_at',
                    'content_type_id'
                ],
                'content_card' => [
                    'id',
                    'card_id',
                    'status',
                    'startdate',
                    'enddate',
                    'transaction_id',
                    'tracking_id',
                    'created_at',
                    'updated_at',
                    'verification_code',
                    'content_id'
                ],
                'content_promotion' => [
                    'id',
                    'content_id',
                    'views',
                    'clicks',
                    'enrollment',
                    'comments',
                    'target_audience',
                    'estimate_reach',
                    'promotion_price',
                    'created_at',
                    'transaction_id',
                    'number_of_card'
                ],
                'content_types' => [
                    'id',
                    'type'
                ],
                'interaction_type' => [
                    'id',
                    'type',
                    'desc'
                ],
                'organization' => [
                    'id',
                    'name',
                    'state',
                    'org_type',
                    'created_at'
                ],
                'organization_user' => [
                    'id',
                    'user_id',
                    'organization_id',
                    'created_at'
                ],
                'roles' => [
                    'id',
                    'role'
                ],
                'transactions' => [
                    'id',
                    'user_id',
                    'organization_id',
                    'status',
                    'sellerOrderNo',
                    'transac_no',
                    'amount',
                    'sellerExOrderNo',
                    'created_at',
                    'updated_at'
                ],
                'user_content' => [
                    'id',
                    'user_id',
                    'interaction_type_id',
                    'status',
                    'content_id',
                    'ip_address',
                    'created_at'
                ],
            ];

            $getRelevantTables = function (string $message, array $map): array {
                $lowerMessage = strtolower($message);
                $tablesNeeded = [];

                foreach ($map as $table => $keywords) {
                    foreach ($keywords as $keyword) {
                        if (strpos($lowerMessage, strtolower($keyword)) !== false) {
                            $tablesNeeded[] = $table;
                            break;  // satu keyword match -> langsung masukkan
                        }
                    }
                }
                return array_unique($tablesNeeded);
            };

            // 1. Cari tabel relevan
            $tablesNeeded = $getRelevantTables($userMessage, $keywordMap);

            // dd($tablesNeeded);



            // 2. Jika tidak ada kecocokan
            if (
                str_contains(strtolower($userMessage), 'report') ||
                str_contains(strtolower($userMessage), 'summary') ||
                str_contains(strtolower($userMessage), 'analysis')
            ) {
                $tablesNeeded = ['users', 'contents', 'content_card', 'content_promotion', 'content_types', 'interaction_type', 'organization', 'organization_user', 'roles', 'transactions', 'user_content'];
            } else {
                if (empty($tablesNeeded)) {
                    DB::table('gpt_log')->insert([
                        'name' => 'ANALYSIS GROQ API',
                        'model' => $model->model_name,
                        'provider' => $model->provider,
                        'user_id' => auth()->user()->id,
                        'status' => 1,
                        'prompt_tokens' => 'TABLE NOT FOUND',
                        'completion_tokens' => '',
                        'total_tokens' => '',
                        'request' => $userMessage,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    return response()->json([
                        'status'  => 'success',
                        'message' => "No relevant data found for your query: '$userMessage'."
                    ]);
                }
            }

            if (in_array('users', $tablesNeeded)) {
                if (!in_array('roles', $tablesNeeded)) {
                    $tablesNeeded[] = 'roles'; // Tambahkan 'roles' jika belum ada
                }
            }


            // 5. Ambil data hanya dari tabel relevan
            $allData = [];
            $tableMatch = '';
            foreach ($tablesNeeded as $tableName) {
                // Pastikan tabel ada di $tablesWithColumns
                if (isset($tablesWithColumns[$tableName])) {
                    $columns = $tablesWithColumns[$tableName];
                    $tableData = DB::table($tableName)->select($columns)->get();
                    $allData[$tableName] = $tableData->toArray();
                }
                $tableMatch .= '' . $tableName . ':';
            }
            $tableMatch = strtoupper($tableMatch);
            // 6. Encode data ke JSON
            $jsonData = json_encode($allData);

            // 7. Kirim data ke Groq/OpenAI
            $apiKey = env('GROQ_API_KEY');
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [

                'model'    => 'llama3-8b-8192',
                'messages' => [
                    [
                        'role'    => 'system',
                        'content' =>
                        "Current Date is: " . Carbon::now()->setTimezone('Asia/Kuala_Lumpur')
                            . ". Here is the data from the relevant tables based on your request: "
                            . $jsonData
                            . ". Use only this data to answer the user's questions. If the data is 1 like status : 1 in json, it mean active"
                            . "If relevant, provide suggestions or additional insights based on the data. If, data is empty, give suggestions base on the user's request. "
                            . "Make sure your suggestions are useful and grounded in the provided data. "
                            . "Do not share unnecessary details about the database structure or design. "
                            . "Do not answer out of topic or unrelated to the data. "
                            . "Please follow these instructions strictly."
                    ],
                    [
                        'role'    => 'user',
                        'content' => $userMessage
                    ],
                ],
            ]);

            // 8. Proses respon dari Groq/OpenAI
            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['choices'][0]['message']['content'] ?? 'No response from AI';
                DB::table('gpt_log')->insert([
                    'name' => 'ANALYSIS GROQ API',
                    'model' => $model->model_name,
                    'provider' => $model->provider,
                    'user_id' => auth()->user()->id,
                    'status' => 1,
                    'prompt_tokens' => $data['usage']['prompt_tokens'] ?? null,
                    'completion_tokens' => $data['usage']['completion_tokens'] ?? null,
                    'total_tokens' => $tableMatch . $data['usage']['total_tokens'] ?? null,
                    'request' => $userMessage,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return response()->json([
                    'status'  => 'success',
                    'message' => $reply,
                ]);
            }

            DB::table('gpt_log')->insert([
                'name' => 'ANALYSIS GROQ API',
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

            // Jika request ke Groq/OpenAI gagal
            return response()->json([
                'status'  => 'error',
                'message' => 'Request to Groq failed or returned an error.',
            ], 500);
            // return response()->json([
            //     'status' => 'error',
            //     'message' => $response->json()['error']['message'] ?? 'Unknown error',
            // ], 500);
        } catch (ValidationException $e) {
            DB::table('gpt_log')->insert([
                'name' => 'ANALYSIS GROQ API',
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
                'name' => 'ANALYSIS GROQ API',
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
                'name' => 'ANALYSIS GROQ API',
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
                    $table->rawColumns(['amount', 'currency', 'start_time', 'end_time', 'name']);

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
    public function showGptLog(Request $request)
    {
        $data = DB::table('gpt_log as gl')
            ->join('users as u', 'gl.user_id', '=', 'u.id')
            ->select('gl.*', 'u.name as user_name', 'u.email as user_email', 'u.icNo as user_icNo')
            ->orderby('gl.created_at', 'desc')
            ->get();

        // dd($data);

        if ($request->ajax()) {
            $table = DataTables::of($data)->addIndexColumn();
            $table->addColumn('status', function ($row) {
                $statusClass = $row->status === 1 ? 'success' : 'danger';
                $statusMessage = $row->status === 1 ? 'SUCCESS' : 'FAILED';
                $button = '<span class=" badge bg-' . $statusClass . ' p-2">' . $statusMessage . '</span>';
                return $button;
            });
            $table->addColumn('model', function ($row) {
                $button = '<span class="">' . $row->model . ' [' . $row->provider . ']' . '</span>';
                return $button;
            });
            $table->addColumn('total_tokens', function ($row) {
                $statusClass = $row->status === 1 ? 'success' : 'danger';
                $statusMessage = $row->status === 1 ? 'SUCCESS' : 'FAILED';
                $button = '<span class=" text-' . $statusClass . ' fs-12 fw-bold">' . $row->total_tokens . '</span>';
                return $button;
            });


            $table->rawColumns(['status', 'model', 'total_tokens']);
            return $table->make(true);
        }

        return view('admin.gpt.log');
    }

    public function applyChatBot(Request $request)
    {
        // dd(Auth::user()->id);
        $price = 300;
        $data = [
            'title' => 'xBug AI Chatbot',
            'uuid' => Guid::uuid4()->toString(),
            'time' => Carbon::now('Asia/Kuala_Lumpur'),
        ];
        return view('gpt-payment.payment', compact('data', 'price'));
    }

    public function xbugGptReceipt($id)
    {
        $transaction = DB::table('transactions')->where('id', $id)->where('sellerOrderNo', 'like', '%XBugGpt%')->first();
        if (!$transaction) {
            return response()->json(['message' => 'Invalid Access, Your Action Will be Recorded'], 500);
        }

        preg_match('/_(\d+)$/', $transaction->sellerOrderNo, $matches);


        $user = Auth::user();
        $userRoles = json_decode($user->role);
        // dd(!in_array(1, $userRoles));
        if (!in_array(1, $userRoles) && Auth::id() != $transaction->user_id) {
            return response()->json(['message' => 'Unauthorized Action']);
        }


        return view('gpt-payment.gpt_receipt', compact('transaction'));
    }
}
