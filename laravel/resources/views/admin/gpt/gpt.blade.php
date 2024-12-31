@extends('admin.layouts.main')
@section('container')
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container">
            <div class="main-chart-wrapper p-2 gap-2 d-lg-flex">
                <!-- Panel Kiri: List AI -->
                <div class="chat-info border">
                    <div class="chat-search p-3 border-bottom">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0" placeholder="Search Chat"
                                aria-describedby="button-addon2">
                            <button aria-label="button" class="btn btn-light" type="button" id="button-addon2">
                                <i class="ri-search-line text-muted"></i>
                            </button>
                        </div>
                    </div>
                    <ul class="nav nav-tabs tab-style-2 nav-justified mb-0 border-bottom d-flex" id="myTab1"
                        role="tablist">
                        <li class="nav-item border-end me-0" role="presentation">
                            <button class="nav-link active h-100" id="users-tab" data-bs-toggle="tab"
                                data-bs-target="#users-tab-pane" type="button" role="tab"
                                aria-controls="users-tab-pane" aria-selected="true">
                                <i class="ri-history-line me-1 align-middle d-inline-block"></i>Recent
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active border-0 chat-users-tab" id="users-tab-pane" role="tabpanel"
                            aria-labelledby="users-tab" tabindex="0">
                            <ul class="list-unstyled mb-0 mt-2 chat-users-tab" id="chat-msg-scroll">
                                <li class="pb-0">
                                    <p class="text-muted fs-11 fw-semibold mb-2 op-7">ACTIVE GPT</p>
                                </li>
                                <!-- Pilihan xBug Ai -->
                                <!-- Pilihan xBug Ai -->
                                <li class="checkforactive">
                                    <a href="javascript:void(0);" id="xbug-ai-link"
                                        onclick="changeTheInfo(
            this, 
            'xBug Ai', 
            'gpt.png', 
            '{{ $status_gpt == 1 ? 'online' : 'offline' }}', 
            '{{ route('sendMessageAdmin') }}'
        )">
                                        <div class="d-flex align-items-top">
                                            <div class="me-1 lh-1">
                                                <span
                                                    class="avatar avatar-md {{ $status_gpt == 1 ? 'online' : 'offline' }} me-2 avatar-rounded">
                                                    <img src="../../assets/images/gpt.png" alt="img">
                                                </span>
                                            </div>
                                            <div class="flex-fill">
                                                <p class="mb-0 fw-semibold">
                                                    xBug Ai
                                                </p>
                                                <p class="fs-12 mb-0">
                                                    <span class="chat-msg text-truncate">
                                                        {{ $status_gpt == 1 ? 'online' : 'offline' }} now
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>

                                <!-- Pilihan xBug Analysis Ai -->
                                <li class="checkforactive">
                                    <a href="javascript:void(0);"
                                        onclick="changeTheInfo(
                                        this, 
                                        'xBug Analysis Ai', 
                                        'analysiss_ai.png', 
                                        '{{ $status_analysis == 1 ? 'online' : 'offline' }}', 
                                        '{{ route('sendMessageAdminAnalysis') }}'
                                    )">
                                        <div class="d-flex align-items-top">
                                            <div class="me-1 lh-1">
                                                <span
                                                    class="avatar avatar-md {{ $status_analysis == 1 ? 'online' : 'offline' }} me-2 avatar-rounded">
                                                    <img src="../../assets/images/analysiss_ai.png" alt="img">
                                                </span>
                                            </div>
                                            <div class="flex-fill">
                                                <p class="mb-0 fw-semibold">
                                                    xBug Analysis Ai
                                                </p>
                                                <p class="fs-12 mb-0">
                                                    <span class="chat-msg text-truncate">
                                                        {{ $status_analysis == 1 ? 'online' : 'offline' }} now
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Main Chat Area -->
                <div class="main-chat-area border">
                    <div class="d-flex align-items-center p-2 border-bottom">
                        <div class="me-2 lh-1">
                            <span class="avatar avatar-lg online me-2 avatar-rounded chatstatusperson">
                                <img class="chatimageperson" src="../../assets/images/gpt.png" alt="img">
                            </span>
                        </div>
                        <div class="flex-fill">
                            <!-- Snippet status untuk xBug Ai -->
                            <div id="status-xbug-gpt" style="display: none;">
                                <p class="mb-0 fw-semibold fs-14">xBug Ai</p>
                                <p
                                    class="text-muted mb-0 chatpersonstatus {{ $status_gpt == 1 ? 'text-success fw-bold' : 'text-danger fw-bold' }}">
                                    {{ $status_gpt == 1 ? 'online' : 'offline' }}
                                </p>
                            </div>

                            <!-- Snippet status untuk xBug Analysis Ai -->
                            <div id="status-xbug-analysis" style="display: none;">
                                <p class="mb-0 fw-semibold fs-14">xBug Analysis Ai</p>
                                <p
                                    class="text-muted mb-0 chatpersonstatus {{ $status_analysis == 1 ? 'text-success fw-bold' : 'text-danger fw-bold' }}">
                                    {{ $status_analysis == 1 ? 'online' : 'offline' }}
                                </p>
                            </div>
                        </div>
                        <div id="loading-btn" class="text-center" style="display: none;">
                            <button class="btn btn-success btn-loader mx-auto">
                                <span class="me-2">Loading</span>
                                <span class="loading"><i class="ri-loader-4-line fs-16 btn-loader"></i></span>
                            </button>
                        </div>
                        <div class="d-flex flex-wrap rightIcons">
                            <div class="dropdown ms-2">
                                <button aria-label="button" class="btn btn-icon btn-outline-light my-1 btn-wave waves-light"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item clear-chat-btn" href="javascript:void(0);">Clear Chat</a>
                                    </li>
                                </ul>
                            </div>
                            <button aria-label="button" type="button"
                                class="btn btn-icon btn-outline-light my-1 ms-2 responsive-chat-close"
                                id="close-chat-button">
                                <i class="ri-close-line"></i>
                            </button>

                        </div>
                    </div>
                    <div class="chat-content" id="main-chat-content" style="overflow-y: scroll;">
                        <ul class="list-unstyled" id="chat-ul">
                            <li class="chat-day-label">
                                <span>Recent</span>
                            </li>
                            <!-- Default message untuk xBug Ai -->
                            <li class="chat-item-start default-ai-message" id="default-gpt"
                                style="{{ $status_gpt == 1 ? '' : 'display:none;' }}">
                                <div class="chat-list-inner">
                                    <div class="chat-user-profile">
                                        <span class="avatar avatar-md online avatar-rounded chatstatusperson">
                                            <img class="chatimageperson" src="../../assets/images/gpt.png"
                                                alt="img">
                                        </span>
                                    </div>
                                    <div class="ms-3">
                                        <span class="chatting-user-info">
                                            <span class="chatnameperson">xBug Ai</span>
                                            <span class="msg-sent-time">now</span>
                                        </span>
                                        @if ($status_gpt == 1)
                                            <div class="main-chat-msg">
                                                <div>
                                                    <p class="mb-0">Hi {{ Auth::user()->name }}, how can I assist you
                                                        today?</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="main-chat-msg">
                                                <div class="bg-danger-transparent fw-bold">
                                                    <p class="mb-0">Hi {{ Auth::user()->name }}, Sorry, xBug GPT is
                                                        Currently Unavailable. Please Contact Us By Email
                                                        [help-center@xbug.online] Inform Us or To Get Support.</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </li>

                            <!-- Default message untuk xBug Analysis Ai -->
                            <li class="chat-item-start default-ai-message" id="default-analysis"
                                style="{{ $status_analysis == 1 ? 'display:none;' : '' }}">
                                <div class="chat-list-inner">
                                    <div class="chat-user-profile">
                                        <span class="avatar avatar-md online avatar-rounded chatstatusperson">
                                            <img class="chatimageperson" src="../../assets/images/analysiss_ai.png"
                                                alt="img">
                                        </span>
                                    </div>
                                    <div class="ms-3">
                                        <span class="chatting-user-info">
                                            <span class="chatnameperson">xBug Analysis Ai</span>
                                            <span class="msg-sent-time">now</span>
                                        </span>
                                        @if ($status_analysis == 1)
                                            <div class="main-chat-msg">
                                                <div>
                                                    <p class="mb-0">Hi {{ Auth::user()->name }}, how can I assist you
                                                        today?</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="main-chat-msg">
                                                <div class="bg-danger-transparent fw-bold">
                                                    <p class="mb-0">Hi {{ Auth::user()->name }}, Sorry, xBug Analysis is
                                                        Currently Unavailable. Please Contact Us By Email
                                                        [help-center@xbug.online] Inform Us or To Get Support.</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>

                    <div class="chat-footer">
                        <input class="form-control" id="chat-input" placeholder="Type your message or question here..."
                            type="text">
                        <a aria-label="anchor" id="send-btn" class="btn btn-primary mx-2 btn-icon btn-send"
                            href="javascript:void(0)">
                            <i class="ri-send-plane-2-line"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Default AI
        let currentAI = "xBug Ai";
        let currentImage = "gpt.png";
        let currentRoute = "{{ route('sendMessageAdmin') }}";

        // Key LocalStorage -> misal "ChatHistory_xBug Ai" atau "ChatHistory_xBug Analysis Ai"

        function loadChatHistory(aiName) {
            const key = getLocalStorageKey(aiName || currentAI);
            const chatHistory = JSON.parse(localStorage.getItem(key)) || [];

            chatHistory.forEach(chat => {
                const isUser = (chat.sender === "user");
                let html;
                if (isUser) {
                    html = `
                            <li class="chat-item-end">
                                <div class="chat-list-inner">
                                    <div class="me-3">
                                        <span class="chatting-user-info">
                                            <span class="msg-sent-time">Previous</span> You
                                        </span>
                                        <div class="main-chat-msg">
                                            <div>
                                                <p class="mb-0">${chat.message}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chat-user-profile">
                                        <span class="avatar avatar-md online avatar-rounded">
                                            <img src="../../assets/images/user/avatar-1.jpg" alt="img">
                                        </span>
                                    </div>
                                </div>
                            </li>`;
                } else {
                    html = `
                            <li class="chat-item-start">
                                <div class="chat-list-inner">
                                    <div class="chat-user-profile">
                                        <span class="avatar avatar-md online avatar-rounded chatstatusperson">
                                            <img class="chatimageperson" src="../../assets/images/${currentImage}" alt="img">
                                        </span>
                                    </div>
                                    <div class="ms-3">
                                        <span class="chatting-user-info">
                                            <span class="chatnameperson">${aiName}</span>
                                            <span class="msg-sent-time">Previous</span>
                                        </span>
                                        <div class="main-chat-msg">
                                            <div class="response-text">${chat.message}</div>
                                        </div>
                                    </div>
                                </div>
                            </li>`;
                }
                $('#chat-ul').append(html);
            });
            $('#main-chat-content').scrollTop($('#main-chat-content')[0].scrollHeight);
        }

        function getLocalStorageKey(aiName) {
            return "ChatHistory_" + aiName.replace(/\s+/g, ''); // misal "ChatHistory_xBugAi"
        }

        // Fungsi untuk ganti AI
        function changeTheInfo(element, name, img, status, route) {
            // Highlight list AI
            document.querySelectorAll(".checkforactive").forEach((ele) => {
                ele.classList.remove("active");
            });
            element.closest("li").classList.add("active");

            // Update tampilan AI
            document.querySelectorAll(".chatnameperson").forEach((ele) => {
                ele.innerText = name;
            });

            if (name === 'xBug Ai') {
                document.getElementById('default-gpt').style.display = 'block';
                document.getElementById('default-analysis').style.display = 'none';
            } else if (name === 'xBug Analysis Ai') {
                document.getElementById('default-gpt').style.display = 'none';
                document.getElementById('default-analysis').style.display = 'block';
            }
            if (name === "xBug Ai") {
                document.getElementById("status-xbug-gpt").style.display = "block";
                document.getElementById("status-xbug-analysis").style.display = "none";
            } else if (name === "xBug Analysis Ai") {
                document.getElementById("status-xbug-gpt").style.display = "none";
                document.getElementById("status-xbug-analysis").style.display = "block";
            }
            document.querySelectorAll(".chatimageperson").forEach((ele) => {
                ele.src = "../../assets/images/" + img;
            });
            document.querySelectorAll(".chatstatusperson").forEach((ele) => {
                ele.classList.remove("online", "offline");
                ele.classList.add(status);
            });

            const chatInput = document.getElementById("chat-input");

            // Jika status adalah "offline", maka disable. Jika "online", enable
            if (status === "online") {
                chatInput.disabled = false;
            } else {
                chatInput.disabled = true;
            }
            document.querySelector(".chatpersonstatus").innerText = status;
            document.querySelector(".main-chart-wrapper").classList.add("responsive-chat-open")

            // Update variable global
            currentAI = name;
            currentImage = img;
            currentRoute = route;

            // Bersihkan tampilan chat
            const chatUl = document.getElementById("chat-ul");
            // Sisakan default
            chatUl.querySelectorAll("li:not(.chat-day-label):not(.default-ai-message)").forEach((li) => li.remove());

            // Muat histori chat dari local storage AI yg dipilih
            loadChatHistory(currentAI);
        }

        $(document).ready(function() {
            // Muat histori default
            const xbugAiLink = document.getElementById('xbug-ai-link');
            if (xbugAiLink) {
                xbugAiLink.click();
            }
            loadChatHistory(currentAI);

            $('.clear-chat-btn').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will clear all chat history except the default message and initial AI response!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, clear it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // 1) Hapus data chat dari localStorage
                        //    Jika Anda menggunakan satu key global, gunakan:
                        // localStorage.removeItem(CHAT_STORAGE_KEY);

                        //    Jika Anda menggunakan key dinamis berdasarkan AI (contoh: xBug Ai atau xBug Analysis Ai),
                        //    Anda bisa pakai helper getLocalStorageKey(currentAI):
                        localStorage.removeItem(getLocalStorageKey(currentAI));

                        // 2) Kosongkan elemen dinamis di tampilan chat
                        //    Sisakan 'li.chat-day-label' dan 'li.default-ai-message'
                        $('#chat-ul').find("li:not(.chat-day-label):not(.default-ai-message)")
                            .remove();

                        // 3) Tampilkan notifikasi sukses
                        Swal.fire(
                            'Cleared!',
                            'Chat history has been cleared successfully, default message and initial AI response remain.',
                            'success'
                        );
                    }
                });
            });


            $('#send-btn').on('click', function() {
                sendMessage();
            });

            $('#chat-input').on('keypress', function(e) {
                if (e.which === 13) {
                    sendMessage();
                }
            });

            function sendMessage() {
                const message = $('#chat-input').val().trim();
                if (!message) return;

                $('#chat-input').val('');

                // Tambahkan pesan user ke chat
                const userMessageHtml = `
                    <li class="chat-item-end">
                        <div class="chat-list-inner">
                            <div class="me-3">
                                <span class="chatting-user-info">
                                    <span class="msg-sent-time">Now</span> You
                                </span>
                                <div class="main-chat-msg">
                                    <div>
                                        <p class="mb-0">${message}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-user-profile">
                                <span class="avatar avatar-md online avatar-rounded">
                                    <img src="../../assets/images/user/avatar-1.jpg" alt="img">
                                </span>
                            </div>
                        </div>
                    </li>`;
                $('#chat-ul').append(userMessageHtml);
                $('#main-chat-content').scrollTop($('#main-chat-content')[0].scrollHeight);

                // Simpan ke local storage
                saveMessageToStorage("user", message);
                $('#loading-btn').show();
                // Kirim ke server
                $.post(currentRoute, {
                        _token: "{{ csrf_token() }}",
                        message: message,
                    })
                    .done(function(response) {
                        if (response.status === 'success') {
                            let formattedMessage = response.message;

                            const aiMessageHtml = `
                            <li class="chat-item-start">
                                <div class="chat-list-inner">
                                    <div class="chat-user-profile">
                                        <span class="avatar avatar-md online avatar-rounded chatstatusperson">
                                            <img class="chatimageperson" src="../../assets/images/${currentImage}" alt="img">
                                        </span>
                                    </div>
                                    <div class="ms-3">
                                        <span class="chatting-user-info">
                                            <span class="chatnameperson">${currentAI}</span>
                                            <span class="msg-sent-time">now</span>
                                        </span>
                                        <div class="main-chat-msg">
                                            <div class="response-text"></div>
                                        </div>
                                    </div>
                                </div>
                            </li>`;
                            $('#chat-ul').append(aiMessageHtml);
                            $('#main-chat-content').scrollTop($('#main-chat-content')[0].scrollHeight);

                            // Simpan ke local storage
                            saveMessageToStorage("ai", formattedMessage);

                            // Tampilkan respons
                            displayResponse(formattedMessage);

                            $('#loading-btn').hide();
                        }
                    })
                    .fail(function(response) {
                        let errorMessage = response.responseJSON?.message || 'Something went wrong!';
                        const errorHtml = `
                        <li class="chat-item-start">
                            <div class="chat-list-inner">
                                <div class="chat-user-profile">
                                    <span class="avatar avatar-md online avatar-rounded chatstatusperson">
                                        <img class="chatimageperson" src="../../assets/images/${currentImage}" alt="img">
                                    </span>
                                </div>
                                <div class="ms-3">
                                    <span class="chatting-user-info">
                                        <span class="chatnameperson">${currentAI}</span>
                                        <span class="msg-sent-time">now</span>
                                    </span>
                                    <div class="main-chat-msg">
                                        <div class="response-text bg-danger-transparent fw-bold">
                                            <span class="text-danger">${errorMessage}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>`;
                        $('#chat-ul').append(errorHtml);
                        $('#main-chat-content').scrollTop($('#main-chat-content')[0].scrollHeight);

                        // Simpan ke local storage
                        saveMessageToStorage("ai", errorMessage);

                        $('#loading-btn').hide();
                    });
            }

            function displayResponse(message) {
                const responseContainer = $('#main-chat-content ul li:last-child .response-text');
                let messageIndex = 0;
                let isTag = false;
                let tagBuffer = '';
                let currentTag = '';
                let isBold = false;
                let boldTextBuffer = '';
                let formattedMessage = '';

                responseContainer.html('');

                const intervalId = setInterval(function() {
                    let char = message.charAt(messageIndex);
                    messageIndex++;

                    if (char === '<') {
                        isTag = true;
                        tagBuffer = '<';
                        currentTag = '';
                    } else if (char === '>') {
                        isTag = false;
                        tagBuffer += '>';
                        formattedMessage += tagBuffer;
                        tagBuffer = '';
                    }

                    if (isTag) {
                        tagBuffer += char;
                    } else {
                        if (char === '*' && message.charAt(messageIndex) === '*') {
                            if (isBold) {
                                formattedMessage += '<strong>' + boldTextBuffer + '</strong>';
                                boldTextBuffer = '';
                            }
                            isBold = !isBold;
                            messageIndex++;
                        } else {
                            if (isBold) {
                                boldTextBuffer += char;
                            } else {
                                if (char === '\n') {
                                    formattedMessage += '<br>';
                                } else {
                                    formattedMessage += char;
                                }
                            }
                        }
                    }
                    responseContainer.html(formattedMessage);
                    $('#main-chat-content').scrollTop($('#main-chat-content')[0].scrollHeight);

                    if (messageIndex >= message.length) {
                        clearInterval(intervalId);
                    }
                }, 5);
            }

            function saveMessageToStorage(sender, message) {
                // Key localStorage tergantung AI sekarang
                const key = getLocalStorageKey(currentAI);
                const chatHistory = JSON.parse(localStorage.getItem(key)) || [];

                chatHistory.push({
                    sender,
                    message
                });
                localStorage.setItem(key, JSON.stringify(chatHistory));
            }
            loadChatHistory(currentAI);

        });
    </script>

    <script>
        document.getElementById("close-chat-button").addEventListener("click", function() {
            // Cari elemen tab pengguna aktif
            const usersTab = document.getElementById("users-tab-pane");

            // Hapus class "responsive-chat-open" untuk menyembunyikan chat utama (jika ada)
            document.querySelector(".main-chart-wrapper").classList.remove("responsive-chat-open");

            // Pastikan tab pengguna aktif terlihat
            if (usersTab) {
                usersTab.classList.add("show", "active");
                usersTab.style.display = "block";
            }

            // Nonaktifkan tab lainnya (jika ada tab lain)
            document.querySelectorAll(".tab-pane").forEach((pane) => {
                if (pane !== usersTab) {
                    pane.classList.remove("show", "active");
                    pane.style.display = "none";
                }
            });

            // Opsional: Geser scroll ke atas di tab pengguna aktif
            document.getElementById("chat-msg-scroll").scrollTop = 0;
        });
    </script>
@endsection
