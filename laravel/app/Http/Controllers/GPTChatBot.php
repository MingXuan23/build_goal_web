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

            $apiKey = env('GROQ_API_KEY');

            $tablesNeeded = [
                'users',
                'contents',
                'content_card',
                'content_promotion',
                'content_types',
                'interaction_type',
                'organization',
                'organization_user',
                'roles',
                'transactions',
                'user_content',
                'smart_contract'
            ];

            // Kolom-kolom yang akan di-select untuk setiap tabel
            $tablesWithColumns = [
                'smart_contract' => [
                    'content_id',
                    'user_id',
                    'status_contract'
                ],
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

            // Kolom numerik (untuk avg, sum, min, max)
            $numericColumns = [
                'users' => ['active'], // contoh: active 0/1
                'contents' => ['enrollment_price', 'participant_limit'],
                'content_card' => [],
                'content_promotion' => ['views', 'clicks', 'enrollment', 'comments', 'promotion_price', 'number_of_card'],
                'content_types' => [],
                'interaction_type' => [],
                'organization' => [],
                'organization_user' => [],
                'roles' => [],
                'transactions' => ['amount'],
                'user_content' => [],
            ];

            // Kolom grouping: groupBy mana saja?
            $groupingColumns = [
                'users' => ['status', 'state'],
                'contents' => ['status', 'state'],
                'content_card' => ['status'],
                'content_promotion' => ['target_audience'],
                'content_types' => [],
                'interaction_type' => [],
                'organization' => ['state'],
                'organization_user' => [],
                'roles' => [],
                'transactions' => ['status'],
                'user_content' => ['status'],
            ];

            // Kolom distinct: mana yang ingin di-check distinct count?
            $distinctColumns = [
                'users' => ['state', 'email_status'],
                'contents' => ['place'],
                'content_card' => [],
                'content_promotion' => ['target_audience'],
                'content_types' => ['type'],
                'interaction_type' => ['type'],
                'organization' => ['org_type'],
                'organization_user' => [],
                'roles' => ['role'],
                'transactions' => ['sellerOrderNo'],
                'user_content' => [],
            ];

            // Kolom top 5 (mencari 5 nilai terbanyak)
            $topFiveColumns = [
                'users' => ['state'],
                'contents' => ['place'],
                'content_card' => ['status'],
                'content_promotion' => ['target_audience'],
                'content_types' => [],
                'smart_contract' => ['status_contract'],
                'interaction_type' => [],
                'organization' => ['state'],
                'organization_user' => [],
                'roles' => ['role'],
                'transactions' => ['status'],
                'user_content' => ['status'],
            ];

            // Kolom date/time untuk monthly breakdown
            $dateColumns = [
                'users' => 'created_at',
                'contents' => 'created_at',
                'content_card' => 'created_at',
                'content_promotion' => 'created_at',
                'organization' => 'created_at',
                'organization_user' => 'created_at',
                'transactions' => 'created_at',
                'user_content' => 'created_at',
            ];

            // ------------------------------------------------
            // 2. Fungsi Pembantu (Semua analisis SELALU FULL)
            // ------------------------------------------------

            // (A) Aggregate numerik
            $getNumericAggregates = function ($tableName, $column) {
                return [
                    'avg' => DB::table($tableName)->avg($column),
                    'sum' => DB::table($tableName)->sum($column),
                    'min' => DB::table($tableName)->min($column),
                    'max' => DB::table($tableName)->max($column),
                ];
            };

            // (B) Grouping
            $getGroupedAnalysis = function ($tableName, $groupColumn, $numCols = []) {
                $selectCols = array_merge([$groupColumn], $numCols);

                $rows = DB::table($tableName)
                    ->select($selectCols)
                    ->get()
                    ->groupBy($groupColumn);

                $result = [];
                foreach ($rows as $groupValue => $collection) {
                    $count = $collection->count();
                    $aggregates = [];
                    foreach ($numCols as $col) {
                        $colValues = $collection->pluck($col)->filter(fn($val) => is_numeric($val));
                        if ($colValues->count() === 0) {
                            $aggregates[$col] = [
                                'avg' => 0,
                                'sum' => 0,
                                'min' => null,
                                'max' => null,
                            ];
                        } else {
                            $aggregates[$col] = [
                                'avg' => $colValues->avg(),
                                'sum' => $colValues->sum(),
                                'min' => $colValues->min(),
                                'max' => $colValues->max(),
                            ];
                        }
                    }
                    $result[] = [
                        'group' => $groupValue,
                        'count' => $count,
                        'aggregates' => $aggregates,
                    ];
                }
                return $result;
            };

            // (C) Distinct count
            $getDistinctCount = function ($tableName, $column) {
                return DB::table($tableName)->distinct($column)->count($column);
            };

            // (D) Top 5 values
            $getTopFiveValues = function ($tableName, $column) {
                $rows = DB::table($tableName)
                    ->select($column, DB::raw('COUNT(*) as total_count'))
                    ->groupBy($column)
                    ->orderBy('total_count', 'desc')
                    ->limit(5)
                    ->get();
                return $rows;
            };

            // (E) Monthly breakdown
            $getMonthlyBreakdown = function ($tableName, $dateColumn) {
                // Asumsi MySQL / MariaDB => YEAR(), MONTH()
                $rows = DB::table($tableName)
                    ->select(
                        DB::raw('YEAR(' . $dateColumn . ') as year_val'),
                        DB::raw('MONTH(' . $dateColumn . ') as month_val'),
                        DB::raw('COUNT(*) as total_count')
                    )
                    ->groupBy('year_val', 'month_val')
                    ->orderBy('year_val', 'asc')
                    ->orderBy('month_val', 'asc')
                    ->get();

                $result = [];
                foreach ($rows as $r) {
                    $result[] = [
                        'year'  => $r->year_val,
                        'month' => $r->month_val,
                        'count' => $r->total_count,
                    ];
                }
                return $result;
            };

            // ----------------------------------
            // 3. Proses "Full Report" untuk SEMUA
            // ----------------------------------
            $analysisData = [];

            foreach ($tablesNeeded as $tableName) {
                if (!isset($tablesWithColumns[$tableName])) {
                    continue;
                }

                $cols     = $tablesWithColumns[$tableName];
                $countAll = DB::table($tableName)->count();

                // a) Numeric aggregates
                $numCols = $numericColumns[$tableName] ?? [];
                $columnAnalysis = [];
                foreach ($numCols as $numCol) {
                    if (in_array($numCol, $cols)) {
                        $columnAnalysis[$numCol] = $getNumericAggregates($tableName, $numCol);
                    }
                }

                // b) Grouping
                $groupAnalysisResult = [];
                if (isset($groupingColumns[$tableName])) {
                    foreach ($groupingColumns[$tableName] as $gCol) {
                        if (in_array($gCol, $cols)) {
                            $groupAnalysisResult[$gCol] = $getGroupedAnalysis($tableName, $gCol, $numCols);
                        }
                    }
                }

                // c) Distinct
                $distinctAnalysis = [];
                if (isset($distinctColumns[$tableName])) {
                    foreach ($distinctColumns[$tableName] as $dCol) {
                        if (in_array($dCol, $cols)) {
                            $distinctAnalysis[$dCol] = $getDistinctCount($tableName, $dCol);
                        }
                    }
                }

                // d) Top 5
                $topFiveAnalysis = [];
                if (isset($topFiveColumns[$tableName])) {
                    foreach ($topFiveColumns[$tableName] as $tCol) {
                        if (in_array($tCol, $cols)) {
                            $topFiveAnalysis[$tCol] = $getTopFiveValues($tableName, $tCol);
                        }
                    }
                }

                // e) Monthly breakdown
                $timeBreakdown = [];
                if (isset($dateColumns[$tableName])) {
                    $dateCol = $dateColumns[$tableName];
                    if (in_array($dateCol, $cols)) {
                        $timeBreakdown = $getMonthlyBreakdown($tableName, $dateCol);
                    }
                }

                // f) Data sample (selalu random limit 10 utk contents & user_content)
                //   Tabel lain => boleh ambil semua, tapi agar aman kita batasi misalnya 50
                $query = DB::table($tableName)->select($cols);
                if (in_array($tableName, ['contents', 'user_content'])) {
                    $query->inRandomOrder()->limit(10);
                } else {
                    // Misal limit 50 agar tidak terlalu besar
                    $query->limit(50);
                }
                $tableData = $query->get();

                // g) Conclusion text (spesifik per tabel)
                $conclusionText = "Table '$tableName': total $countAll records. ";
                if ($tableName === 'users') {
                    // Contoh: status=1 => active
                    $activeUserCount   = DB::table($tableName)->where('status', 1)->count();
                    $inactiveUserCount = $countAll - $activeUserCount;
                    $conclusionText .= "Active users = $activeUserCount; Inactive = $inactiveUserCount. ";
                } elseif ($tableName === 'contents') {
                    $activeContents = DB::table($tableName)->where('status', 1)->count();
                    $conclusionText .= "Active contents = $activeContents. ";
                    if (isset($columnAnalysis['enrollment_price'])) {
                        $avgPrice = round($columnAnalysis['enrollment_price']['avg'], 2);
                        $conclusionText .= "Avg enrollment_price = $avgPrice. ";
                    }
                } elseif ($tableName === 'transactions') {
                    if (isset($columnAnalysis['amount'])) {
                        $sumAmount = round($columnAnalysis['amount']['sum'], 2);
                        $avgAmount = round($columnAnalysis['amount']['avg'], 2);
                        $conclusionText .= "Total transactions amount = $sumAmount; average = $avgAmount. ";
                    }
                }
                // ... tambahkan lagi if-else jika mau detail untuk tabel lain ...

                // Tambahkan ringkasan grouping, distinct, top5, dsb. ke conclusion
                // (Opsional, di sini hanya contoh ringkas)
                if (!empty($groupAnalysisResult)) {
                    foreach ($groupAnalysisResult as $grpCol => $grpItems) {
                        $conclusionText .= "[Group by $grpCol]: ";
                        foreach ($grpItems as $g) {
                            $val   = $g['group'] ?? '(null)';
                            $count = $g['count'];
                            $conclusionText .= "($grpCol=$val => $count rows). ";
                        }
                    }
                }
                if (!empty($distinctAnalysis)) {
                    $conclusionText .= " Distinct columns: ";
                    foreach ($distinctAnalysis as $c => $cnt) {
                        $conclusionText .= "$c => $cnt distinct; ";
                    }
                }
                if (!empty($topFiveAnalysis)) {
                    foreach ($topFiveAnalysis as $col => $rows) {
                        $conclusionText .= " [Top 5 $col]: ";
                        foreach ($rows as $r) {
                            $val = $r->$col ?? '(null)';
                            $cn  = $r->total_count;
                            $conclusionText .= "($val => $cn), ";
                        }
                    }
                }
                if (!empty($timeBreakdown)) {
                    $conclusionText .= " [Monthly breakdown]: ";
                    foreach ($timeBreakdown as $tb) {
                        $y = $tb['year'];
                        $m = $tb['month'];
                        $c = $tb['count'];
                        $conclusionText .= "($y-$m => $c), ";
                    }
                }

                // Simpan dalam $analysisData
                $analysisData[$tableName] = [
                    'analysis' => [
                        'total_count'      => $countAll,
                        'columns_analysis' => $columnAnalysis,
                        'grouped_analysis' => $groupAnalysisResult,
                        'distinct_count'   => $distinctAnalysis,
                        'top_5_analysis'   => $topFiveAnalysis,
                        'time_breakdown'   => $timeBreakdown,
                    ],
                    // 'data_sample' => $tableData->toArray(),
                    'conclusion'  => $conclusionText,
                ];
            }

            // ---------------------------------------
            // 4. Kirim hasil analisis ke Groq/OpenAI
            // ---------------------------------------
            $jsonData = json_encode($analysisData);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                // Gunakan model sesuai $model atau statis
                'model'    => $model->model_name,
                'messages' => [
                    [
                        'role'    => 'system',
                        'content' =>
                "Today's date: " . Carbon::now()->setTimezone('Asia/Kuala_Lumpur')->toDateString() . "\n"
                . "Below is a comprehensive data report from our relevant tables. "
                . "Your goals are:\n"
                . "1. Present the data in a clean, professional, and easy-to-understand manner.\n"
                . "2. Avoid technical references such as 'rows', '=>', or '[]', and do not expose database structure details.\n"
                . "3. Provide a concise summary and brief suggestions for each table.\n"
                . "4. If possible, display a short 'slide report' style summary at the end.\n"
                . "5. Use only the provided data for your analysis and do not go off-topic.\n\n"
                . "=== RELEVANT DATA ===\n"
                . $jsonData // hasil JSON dari analisis data
                . "\n=== END OF DATA ===\n\n"
                . "Please analyze and respond in a clear and concise format. "
                . "If there is sensitive or unclean data, kindly refine and present it professionally. "
                . "Offer helpful suggestions, but remain strictly within the context of the data.\n"
                . "Keep it user-friendly and professional.\n"
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
                    'total_tokens' => $data['usage']['total_tokens'] ?? null,
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
