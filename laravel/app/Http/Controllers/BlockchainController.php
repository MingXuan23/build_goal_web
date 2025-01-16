<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BlockchainController extends Controller
{
    //
    public function showContentBlockchainAdmin(Request $request)
    {
        $user = Auth::user();
        $user_data = DB::table('contents')
            ->join('content_types', 'contents.content_type_id', '=', 'content_types.id')
            ->leftJoin('smart_contract', 'contents.id', '=', 'smart_contract.content_id')
            ->join('organization_user', 'contents.user_id', '=', 'organization_user.user_id')
            ->join('organization', 'organization_user.organization_id', '=', 'organization.id')
            ->where('contents.reason_phrase', 'APPROVED')
            ->select(
                'contents.id',
                'contents.name',
                'contents.created_at',
                'contents.link',
                'contents.status',
                'contents.user_id',
                'contents.enrollment_price',
                'contents.place',
                'contents.reason_phrase',
                'contents.reject_reason',
                'contents.participant_limit',
                'contents.content_type_id',
                'content_types.type',
                'smart_contract.tx_hash as smart_contract_tx_hash',
                'smart_contract.id as smart_contract_id',
                'smart_contract.block_no as smart_contract_block_no',
                'smart_contract.contract_address as smart_contract_contract_address',
                'smart_contract.address as smart_contract_address',
                'smart_contract.status_contract as smart_contract_status_contract',
                'smart_contract.contract_verified_at as smart_contract_verfied_at',
                'smart_contract.created_at as smart_contract_created_at',
                'smart_contract.tx_id as smart_contract_tx_id',
                'organization.name as organization_name'
            )
            ->orderBy('smart_contract.created_at', 'desc')
            ->get();

        // dd($user_data);

        if ($request->ajax()) {
            $table = DataTables::of($user_data)->addIndexColumn();

            $table->addColumn('status', function ($row) {
                if ($row->smart_contract_status_contract === 1) {
                    $button = '
                                <button class="btn btn-icon btn-sm btn-success-transparent rounded-pill ms-2"
                                    data-bs-toggle="modal" data-bs-target="#modalView-' . $row->id . '">
                                    <i class="ri-eye-line fw-bold"></i>
                                </button>';
                    // $button = '<span class="badge bg-success p-2 fw-bold">SUCCESS</span>
                    //             <button class="btn btn-icon btn-sm btn-success-transparent rounded-pill ms-2"
                    //                 data-bs-toggle="modal" data-bs-target="#modalView-' . $row->id . '">
                    //                 <i class="ri-eye-line fw-bold"></i>
                    //             </button>';
                } elseif ($row->smart_contract_status_contract === 0) {
                    $button =  '<span class="badge bg-danger p-2 fw-bold">FAILED</span>';
                } elseif ($row->smart_contract_status_contract === 2) {
                    $button =  '<span class="badge bg-warning p-2 fw-bold">WAITING FOR ETHEREUM</span>';
                } elseif ($row->smart_contract_status_contract === '' || $row->smart_contract_status_contract === null) {
                    $button =  '<span class="p-2 fw-bold">-</span>';
                }
                return $button;
            });

            $table->addColumn('network', function ($row) {
                return '<span class="text-dark p-2 fw-bold">Sepolia Network</span';
            });

            $table->addColumn('tx_hash', function ($row) {
                if ($row->smart_contract_status_contract === 1) {
                    $shortenedTxHash = strlen($row->smart_contract_tx_hash) > 15
                        ? substr($row->smart_contract_tx_hash, 0, 18) . '...'
                        : $row->smart_contract_tx_hash;

                    $button = '
                    <div class="d-flex align-items-center">
                        <span class="p-2 fw-bold">
                            ' . $shortenedTxHash . '
                        </span>
                        <button class="btn btn-light btn-sm ms-1 copy-btn" data-copy="' . $row->smart_contract_tx_hash . '" title="Copy to clipboard">
                            <i class="bi bi-clipboard"></i>
                        </button>
                        <a href="https://sepolia.etherscan.io/tx/' . $row->smart_contract_tx_hash . '"
                           target="_blank"
                           class="text-dark text-decoration-none fw-bold ms-1 bg-light btn btn-sm"
                           title="View on Etherscan">
                           <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    </div>
                    <script>
                        document.querySelectorAll(".copy-btn").forEach(button => {
                            button.addEventListener("click", () => {
                                const textToCopy = button.getAttribute("data-copy");
                                navigator.clipboard.writeText(textToCopy)
                                    .then(() => toastr.success("Copied: " + textToCopy))
                                    .catch(err => console.error("Failed to copy: ", err));
                            });
                        });
                    </script>
                ';
                } elseif ($row->smart_contract_status_contract === 0) {
                    $button =  '<span class="p-2 fw-bold">-</span>';
                } elseif ($row->smart_contract_status_contract === 2) {
                    $button =  '<span class="p-2 fw-bold">-</span>';
                } elseif ($row->smart_contract_status_contract === '' || $row->smart_contract_status_contract === null) {
                    $button =  '<span class="p-2 fw-bold">-</span>';
                }
                return $button;
            });
            $table->addColumn('block_id', function ($row) {
                if ($row->smart_contract_status_contract === 1) {

                    $button = '
                    <span class="p-2 fw-bold">
                        ' . $row->smart_contract_block_no . '
                    </span>
                    <button class="btn btn-light btn-sm ms-1 copy-btn" data-copy="' . $row->smart_contract_block_no . '">
                        <i class="bi bi-clipboard"></i>
                    </button>
                    <script>
                        document.querySelectorAll(".copy-btn").forEach(button => {
                            button.addEventListener("click", () => {
                                const textToCopy = button.getAttribute("data-copy");
                                navigator.clipboard.writeText(textToCopy)
                                    .then(() => toastr.success("Copied: " + textToCopy))
                                    .catch(err => console.error("Failed to copy: ", err));
                            });
                        });
                    </script>
                ';
                } elseif ($row->smart_contract_status_contract === 0) {
                    $button =  '<span class="p-2 fw-bold">-</span>';
                } elseif ($row->smart_contract_status_contract === 2) {
                    $button =  '<span class="p-2 fw-bold">-</span>';
                } elseif ($row->smart_contract_status_contract === '' || $row->smart_contract_status_contract === null) {
                    $button =  '<span class="p-2 fw-bold">-</span>';
                }
                return $button;
            });
            $table->addColumn('blockchain_id', function ($row) {
                if ($row->smart_contract_status_contract === 1) {

                    $button = '
                    <span class="p-2 fw-bold">
                        ' . $row->smart_contract_tx_id . '
                    </span>
                    <button class="btn btn-light btn-sm ms-1 copy-btn" data-copy="' . $row->smart_contract_tx_id . '">
                        <i class="bi bi-clipboard"></i>
                    </button>
                          <a href="https://sepolia.etherscan.io/address/' . $row->smart_contract_contract_address . '#readContract#F2"
                           target="_blank"
                           class="text-dark text-decoration-none fw-bold ms-1 bg-light btn btn-sm"
                           title="View on Etherscan">
                           <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    <script>
                        document.querySelectorAll(".copy-btn").forEach(button => {
                            button.addEventListener("click", () => {
                                const textToCopy = button.getAttribute("data-copy");
                                navigator.clipboard.writeText(textToCopy)
                                    .then(() => toastr.success("Copied: " + textToCopy))
                                    .catch(err => console.error("Failed to copy: ", err));
                            });
                        });
                    </script>
                ';
                } elseif ($row->smart_contract_status_contract === 0) {
                    $button =  '<span class="p-2 fw-bold">-</span>';
                } elseif ($row->smart_contract_status_contract === 2) {
                    $button =  '<span class="p-2 fw-bold">-</span>';
                } elseif ($row->smart_contract_status_contract === '' || $row->smart_contract_status_contract === null) {
                    $button =  '<span class="p-2 fw-bold">-</span>';
                }
                return $button;
            });

            $table->addColumn('log', function ($row) {
                if ($row->smart_contract_status_contract === 1) {
                    $button = '
                                <button class="btn btn-icon btn-sm btn-success-transparent rounded-pill ms-2"
                                    data-bs-toggle="modal" data-bs-target="#viewLogs-' . $row->id . '">
                                    <i class="ri-eye-line fw-bold"></i>
                                </button>';
                } elseif ($row->smart_contract_status_contract === 0) {
                    $button =  '<span class="badge bg-danger p-2 fw-bold">FAILED</span>';
                } elseif ($row->smart_contract_status_contract === 2) {
                    $button =  '<span class="badge bg-warning p-2 fw-bold">WAITING FOR ETHEREUM</span>';
                } elseif ($row->smart_contract_status_contract === '' || $row->smart_contract_status_contract === null) {
                    $button =  '<span class="p-2 fw-bold">-</span>';
                }
                return $button;
            });

            $table->rawColumns(['status', 'network', 'tx_hash', 'block_id', 'blockchain_id', 'log']);
            return $table->make(true);
        }
        return view('admin.blockchain.index', [
            'content_data' => $user_data,
        ]);
    }
    public function getLogs($id)
    {
        // sleep(3);
        // Validate that $id is an integer
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid smart contract ID.'], 400);
        }

        // Fetch logs from the database, ordered by created_at ascending
        $logs = DB::table('smart_contract_logs')
            ->where('smart_contract_id', $id)
            ->orderBy('id', 'desc')
            ->get();

        // Check if logs exist
        if ($logs->isEmpty()) {
            return response()->json(['message' => 'No logs found for this smart contract.'], 404);
        }

        return response()->json(['logs' => $logs], 200);
    }
}
