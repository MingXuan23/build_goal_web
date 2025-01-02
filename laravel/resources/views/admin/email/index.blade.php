@extends('admin.layouts.main')

@section('container')
    <style>
        .wrap-text {
            white-space: normal !important;
            word-wrap: break-word;
        }
    </style>
    <div class="main-content app-content">
        <div class="container">
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Email</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Email</li>
                        </ol>
                    </nav>
                </div>
            </div>
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill fs-4"></i>
                    </svg>
                    <div class="ms-3"> {{ session('success') }} </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
                    <i class="bi bi-dash-circle-fill fs-4"></i>
                    <div class="ms-3"> {!! session('error') !!} </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
                        <i class="bi bi-dash-circle-fill fs-4"></i>
                        <div class="ms-3"> {{ $error }} </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endforeach
            @endif
            <!-- Button to send email to all users -->
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title">Send New Notification Email</div>
                    <button class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#modalSendToAll">
                        Send Email to Specific Roles
                    </button>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Ic No</th>
                                    <th>Telno</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Send Email</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            @foreach ($datas as $data)
                <form action="{{ route('sendEmail') }}" method="post">
                    @csrf
                    <div class="modal modal-lg fade" id="modalSend-{{ $data->id }}" tabindex="-1"
                        aria-labelledby="modalSendLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="modalSendLabel">Send Email To -
                                        {{ strtoupper($data->name) }}</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body px-4">
                                    <div class="row">
                                        <div class="col-xl-6 mb-2">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" placeholder="Enter Content Name"
                                                    value="[help-center@xbug.online]" name="from" disabled>
                                                <label for="contentName">From</label>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 mb-2">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" placeholder="Enter Content Name"
                                                    value="{{ $data->email }}" name="to_email">
                                                <label for="contentName">To</label>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 mb-2">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" placeholder="Enter Content Name"
                                                    value="" name="subject">
                                                <label for="contentName">Subject</label>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 mb-5">
                                            <div class="mb-5" id="editor-{{ $data->id }}" class="ql-container"></div>
                                            <!-- Quill editor -->
                                            <input class="mb-5" type="hidden" name="content"
                                                id="content-{{ $data->id }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer mt-5">
                                    <button type="button" class="btn btn-danger mt-5"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary mt-5">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endforeach

            <form action="{{ route('sendEmailToAll') }}" method="post">
                @csrf
                <div class="modal modal-lg fade" id="modalSendToAll" tabindex="-1"
                    aria-labelledby="modalSendToAllLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="modalSendToAllLabel">Send Email To Specific Roles
                                </h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-4">
                                <div class="row">
                                    <div class="mb-2">
                                        <span class="mb-3 h6 fw-normal">Select Roles You Want to Send: </span>
                                        <div class="form-check mb-3 form-check-lg d-flex">
                                            @foreach ($roles as $role)
                                                <input class="form-check-input" type="checkbox" name="roles[]"
                                                    value="{{ $role->id }}"
                                                    id="{{ $role->role }}-{{ $role->id }}">
                                                <label class="form-check-label me-5"
                                                    for="{{ $role->role }}-{{ $role->id }}">
                                                    {{ ucfirst(str_replace('_', ' ', $role->role)) }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-xl-12 mb-2">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" placeholder="Enter Content Name"
                                                value="[help-center@xbug.online]" name="from" disabled>
                                            <label for="contentName">From</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 mb-2">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" placeholder="Enter Content Name"
                                                value="" name="subject">
                                            <label for="contentName">Subject</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 mb-5">
                                        <div class="mb-5" id="editor" class="ql-container"></div>
                                        <!-- Quill editor -->
                                        <input class="mb-5" type="hidden" name="content" id="content">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer mt-5">
                                <button type="button" class="btn btn-danger " data-bs-dismiss="modal">Cancel</button>
                                <!-- Butang di modalSendToAll -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalSendToAllConfirm">
                                    Send to All Users
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal pengesahan -->
                <div class="modal modal-sm fade" id="modalSendToAllConfirm" tabindex="-1"
                    aria-labelledby="modalSendToAllConfirmLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="modalSendToAllConfirmLabel">Confirmation Email</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to send this email to all users?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Confirm Send</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- Quill.js -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#modalSendToAll').on('shown.bs.modal', function() {
                if (!$('#editor').data('quill')) {
                    var quill = new Quill('#editor', {
                        theme: 'snow',
                        modules: {
                            toolbar: [
                                [{
                                    'header': '1'
                                }, {
                                    'header': '2'
                                }, {
                                    'font': []
                                }],
                                [{
                                    'list': 'ordered'
                                }, {
                                    'list': 'bullet'
                                }],
                                ['bold', 'italic', 'underline'],
                                [{
                                    'align': []
                                }],
                                ['link', 'image', 'video'],
                                [{
                                    'indent': '-1'
                                }, {
                                    'indent': '+1'
                                }],
                                [{
                                    'direction': 'rtl'
                                }],
                                ['clean']
                            ],
                        },
                        placeholder: 'Type your message here...',
                    });
                    $('#editor').data('quill', quill);
                }
            });

            // Fungsi untuk menangkap konten Quill dan menyimpannya dalam input tersembunyi ketika form dihantar
            $('form').on('submit', function() {
                var content = $('#editor').data('quill').root.innerHTML;
                $('#content').val(content);
            });
        });

        $(document).ready(function() {
            $('.modal').on('shown.bs.modal', function() {
                var modalId = $(this).attr('id');
                var editorId = '#editor-' + modalId.split('-')[1];

                if (!$(editorId).data('quill')) {
                    var quill = new Quill(editorId, {
                        theme: 'snow',
                        modules: {
                            toolbar: [
                                [{
                                    'header': '1'
                                }, {
                                    'header': '2'
                                }, {
                                    'font': []
                                }],
                                [{
                                    'list': 'ordered'
                                }, {
                                    'list': 'bullet'
                                }],
                                ['bold', 'italic', 'underline'],
                                [{
                                    'align': []
                                }],
                                ['link', 'image', 'video'],
                                [{
                                    'indent': '-1'
                                }, {
                                    'indent': '+1'
                                }],
                                [{
                                    'direction': 'rtl'
                                }],
                                ['clean']
                            ],
                        },
                        placeholder: 'Type your message here...',
                    });
                    $(editorId).data('quill', quill);
                }
            });

            $('.btn-primary').on('click', function() {
                var modalId = $(this).closest('.modal').attr('id');
                var editorId = '#editor-' + modalId.split('-')[1];
                var content = $(editorId).data('quill').root.innerHTML;
                $('#content-' + modalId.split('-')[1]).val(content);
            });

            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('showEmail') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        render: (data, type, row) => {
                            return `<div class="wrap-text fw-bold">${data.toUpperCase()}</div>`;
                        }
                    },
                    {
                        data: 'icNo',
                        name: 'icNo'
                    },
                    {
                        data: 'telno',
                        name: 'telno'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role_names',
                        name: 'role_names'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        text: 'Copy Data'
                    },
                    {
                        extend: 'csv',
                        text: 'Export CSV'
                    },
                    {
                        extend: 'excel',
                        text: 'Export Excel'
                    },
                    {
                        extend: 'pdf',
                        text: 'Export PDF'
                    },
                    {
                        extend: 'print',
                        text: 'Print Data'
                    }
                ],
                language: {
                    emptyTable: "No logs available"
                }
            });
        });
    </script>
@endsection
