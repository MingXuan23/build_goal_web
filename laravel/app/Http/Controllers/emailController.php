<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Mail\NotificationMail;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Str;

class emailController extends Controller
{
    //

    public function showEmail(Request $request)
    {

        $data = DB::table('users as u')
            ->join('roles as r', function ($join) {
                $join->whereRaw('JSON_CONTAINS(u.role, JSON_ARRAY(r.id))');
            })
            ->select(
                'u.*',
                DB::raw('GROUP_CONCAT(r.role) as role_names')
            )
            ->groupBy(
                'u.id',
                'u.name',
                'u.password',
                'u.telno',
                'u.address',
                'u.state',
                'u.email',
                'u.status',
                'u.role',
                'u.active',
                'u.created_at',
                'u.Updated_at',
                'u.email_status',
                'u.verification_code',
                'u.icNo',
                'u.remember_token',
                'u.ekyc_status',
                'u.ekyc_time',
                'u.ekyc_signature',
                'u.is_gpt',
                'u.gpt_status',
            )
            ->orderby('u.created_at', 'asc')
            ->get();
        // dd($logs);  
        if ($request->ajax()) {

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('action', function ($row) {
                $button = '<div class="d-flex justify-content-center">
                                    <button class="btn btn-icon btn-sm btn-warning-transparent rounded-pill"
                                        data-bs-toggle="modal" data-bs-target="#modalSend-' . $row->id . '">
                                        <i class="ri-edit-line fw-bold"></i>
                                    </button>
                                    </div>
                                    ';
                return $button;
            });

            $table->addColumn('status', function ($row) {
                $statusClass = $row->status === 'ACTIVE' ? 'success' : 'danger';
                return '<span class="badge bg-' . $statusClass . ' p-2">' . $row->status . '</span>';
            });
            $table->addColumn('role_names', function ($row) {
                return '<span class="badge bg-info-transparent p-2 fw-bold">' . $row->role_names . '</span>';
            });

            $table->rawColumns(['status', 'action', 'role_names']);

            return $table->make(true);
        }
        $roles = DB::table('roles')->get();

        return view('admin.email.index', ['datas' => $data, 'roles' => $roles]);
    }
    public function sendEmail(Request $request)
    {
        DB::beginTransaction();

        $request->validate([
            'to_email' => 'required|email',
            'subject' => 'required|string',
            'content' => 'required|string',
        ]);
        $toEmail = $request->to_email;
        $subject = $request->subject;
        $content = $request->content;
        $user = DB::table('users')->where('email', $toEmail)->first();

        if ($user) {
            try {

                $content = $this->processBase64Images($content);

                $logData = [
                    'email_type' => 'NOTIFICATION USER',
                    'recipient_email' => $toEmail,
                    'from_email' => 'help-center@xbug.online',
                    'name' => $user->name,
                    'status' => 'SUCCESS',
                    'response_data' => $content,
                    'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                    'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                ];

                DB::table('email_logs')->insert($logData);
                DB::commit();

                Mail::mailer('smtp2')->to($toEmail)->send(new NotificationMail($subject, $content));
                return back()->with('success', 'Email sent successfully!');
            } catch (Exception $e) {
                DB::rollBack();

                $logData = [
                    'email_type' => 'NOTIFICATION USER',
                    'recipient_email' => $toEmail,
                    'from_email' => 'help-center@xbug.online',
                    'name' => $user->name,
                    'status' => 'FAILED',
                    'response_data' => 'ERROR : ' . $e->getMessage(),
                    'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                    'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                ];

                DB::table('email_logs')->insert($logData);
                return back()->with('error', 'Failed to send email: ' . $e->getMessage());
            }
        } else {
            return back()->with('error', 'Email user not found in database!');
        }
    }
    private function processBase64Images($content)
    {
        preg_match_all('/<img src="data:image\/(png|jpeg|jpg);base64,([^"]+)"/', $content, $matches);

        if (count($matches) > 0) {
            foreach ($matches[0] as $key => $match) {
                $imageData = base64_decode($matches[2][$key]);
                $extension = $matches[1][$key];

                $imageName = '_image_' . time() . '_' . $key . '.' . $extension;

                $path = Storage::disk('public')->put('emails/images/' . $imageName, $imageData);

                if ($path) {
                    $newImageUrl = asset('storage/emails/images/' . $imageName);

                    $content = str_replace($match, '<img src="' . $newImageUrl . '"', $content);
                }
            }
        }

        return $content;
    }

    public function showNotificationLogs(Request $request)
    {
        $logs = DB::table('email_logs')
            ->select([
                'id',
                'email_type',
                'recipient_email',
                'from_email',
                'name',
                'status',
                'response_data',
                'created_at'
            ])
            ->whereIn('email_type', ['NOTIFICATION USER', 'NOTIFICATION TO ALL USERS'])
            ->orderBy('id', 'desc')
            ->get();
        if ($request->ajax()) {

            $table = DataTables::of($logs)->addIndexColumn();
            $table->addColumn('status', function ($row) {
                $statusClass = $row->status === 'SUCCESS' ? 'success' : 'danger';
                return '<span class="badge bg-' . $statusClass . ' p-2">' . $row->status . '</span>';
            });
            $table->addColumn('action', function ($row) {
                $button = '<div class="d-flex justify-content-center align-items-center">
                                <button class="btn btn-icon btn-sm btn-info-transparent rounded-pill me-2"
                                        data-bs-toggle="modal" data-bs-target="#modalView-' . $row->id . '">
                                        <i class="ri-eye-line fw-bold"></i>
                                    </button>
                            </div>
                    ';
                return $button;
            });


            $table->rawColumns(['status', 'action']);

            return $table->make(true);
        }


        return view('admin.email.notification-logs', [
            'datas' => $logs
        ]);
    }

    public function sendEmailToAll(Request $request)
    {

        DB::beginTransaction();
        try {

            if ($request->subject === '' || $request->content === '' || $request->subject === null || $request->content === null || $request->roles === null) {
                return back()->with('error', 'All fields are required for send email.');
            }

            $subject = $request->subject;
            $content = $request->content;
            $roles = $request->roles;

            $users = DB::table('users')
            ->where('status', 'ACTIVE')
            ->whereNotNull('email')
            ->where('email', '<>', '')
            ->where(function ($query) use ($roles) {
                foreach ($roles as $role) {
                    $query->orWhereJsonContains('role', (int)$role);
                }
            })
            ->get();

            // dd($users);

            if ($users->isEmpty()) {
                return back()->with('error', 'No active users with valid email found to send emails.');
            }

            $total = 0;

            foreach ($users as $user) {
                $toEmail = $user->email;


                $total++;
                $processedContent = $this->processBase64Images($content);

                Mail::mailer('smtp2')->to($toEmail)->send(new NotificationMail($subject, $processedContent));
            }

            $logData = [
                'email_type' => 'NOTIFICATION TO ALL USERS',
                'recipient_email' => 'MULTIPLE USERS',
                'from_email' => 'help-center@xbug.online',
                'name' => 'ALL USERS : ' . $total . ' USERS',
                'status' => 'SUCCESS',
                'response_data' => $processedContent,
                'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
            ];

            DB::table('email_logs')->insert($logData);

            DB::commit();

            return back()->with('success', "Emails sent to $total users successfully!");
        } catch (Exception $e) {
            DB::rollBack();

            $logData = [
                'email_type' => 'NOTIFICATION TO ALL USERS',
                'recipient_email' => 'N/A',
                'from_email' => 'help-center@xbug.online',
                'name' => 'ALL USERS',
                'status' => 'FAILED',
                'response_data' => 'ERROR: ' . $e->getMessage(),
                'created_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
                'updated_at' => Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString(),
            ];

            DB::table('email_logs')->insert($logData);

            return back()->with('error', 'Failed to send email to all users: ' . $e->getMessage());
        }
    }
}
