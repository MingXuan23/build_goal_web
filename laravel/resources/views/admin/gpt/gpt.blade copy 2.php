@extends('admin.layouts.main')
@section('container')
    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container">
            <!-- Start::row-1 -->
            <div class="main-chart-wrapper p-2 gap-2 d-lg-flex">
                <!-- Chat Info Panel -->
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
                                <li class="checkforactive">
                                    <a href="javascript:void(0);" onclick="changeTheInfo(this,'xBug Ai','5','online')">
                                        <div class="d-flex align-items-top">
                                            <div class="me-1 lh-1">
                                                <span class="avatar avatar-md online me-2 avatar-rounded">
                                                    <img src="../../assets/images/gpt.png" alt="img">
                                                </span>
                                            </div>
                                            <div class="flex-fill">
                                                <p class="mb-0 fw-semibold">
                                                    xBug Ai<span class="float-end text-muted fw-normal fs-11"></span>
                                                </p>
                                                <p class="fs-12 mb-0">
                                                    <span class="chat-msg text-truncate">
                                                        {{ $status_model == 1 ? 'online' : 'offline' }} now</span>
                                                    <span class="chat-read-icon float-end align-middle">
                                                        <i class="ri-check-double-fill"></i>
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
                            <p class="mb-0 fw-semibold fs-14">
                                <a href="javascript:void(0);" class="chatnameperson responsive-userinfo-open">xBug Ai</a>
                            </p>
                            <p
                                class="text-muted mb-0 chatpersonstatus {{ $status_model == 1 ? 'text-success fw-bold' : 'text-danger fw-bold' }}">
                                {{ $status_model == 1 ? 'online' : 'offline' }}
                            </p>
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
                                    <li><a class="dropdown-item" href="javascript:void(0);">Clear Chat</a></li>
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
                        <ul class="list-unstyled">
                            <li class="chat-day-label">
                                <span>Recent</span>
                            </li>
                            <li class="chat-item-start">
                                <div class="chat-list-inner">
                                    <div class="chat-user-profile">
                                        <span class="avatar avatar-md online avatar-rounded chatstatusperson">
                                            <img class="chatimageperson" src="../../assets/images/gpt.png" alt="img">
                                        </span>
                                    </div>
                                    <div class="ms-3">
                                        <span class="chatting-user-info">
                                            <span class="chatnameperson">xBug Ai</span>
                                            <span class="msg-sent-time">now</span>
                                        </span>
                                        @if ($status_model == 1)
                                            <div class="main-chat-msg">
                                                <div>
                                                    <p class="mb-0">Hi {{ Auth::user()->name }}, how can I assist you
                                                        today? &#128512;</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="main-chat-msg">
                                                <div class="bg-danger-transparent fw-bold">
                                                    <p class="mb-0">Hi {{ Auth::user()->name }}, Sorry, xBug GPT is
                                                        currently unavailable. Contact us by email [help-center@xbug.online]
                                                        for more information.</p>
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
            <!--End::row-1 -->
        </div>
    </div>

    <script>
        let changeTheInfo = (element, name, img, status) => {
            document.querySelectorAll(".checkforactive").forEach((ele) => {
                ele.classList.remove("active")
            })
            element.closest("li").classList.add("active")
            document.querySelectorAll(".chatnameperson").forEach((ele) => {
                ele.innerText = name
            })
            let image = `../../assets/images/gpt.png`
            document.querySelectorAll(".chatimageperson").forEach((ele) => {
                ele.src = image
            })

            document.querySelectorAll(".chatstatusperson").forEach((ele) => {
                ele.classList.remove("online")
                ele.classList.remove("offline")
                ele.classList.add(status)
            })



            document.querySelector(".chatpersonstatus").innerText = status

            document.querySelector(".main-chart-wrapper").classList.add("responsive-chat-open")
        }
    </script>
    <script>
        $(document).ready(function() {
            const CHAT_STORAGE_KEY = "xBugChatHistory"; // Kunci penyimpanan local storage untuk chat history
            loadChatHistory(); // Muat chat history dari local storage saat halaman dimuat

            $('#send-btn').on('click', function(e) {
                e.preventDefault();
                sendMessage();
            });

            $('#chat-input').on('keypress', function(e) {
                if (e.which == 13 && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });

            function sendMessage() {
                let message = $('#chat-input').val();
                if (message.trim() === '') {
                    alert('Please enter a message.');
                    return;
                }
                $('#loading-btn').show();

                // Tambahkan pesan user ke chat area
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
                </li>
            `;
                $('#main-chat-content ul').append(userMessageHtml);

                saveMessageToStorage("user", message); // Simpan pesan user ke local storage
                $('#chat-input').val('');
                $('#main-chat-content').scrollTop($('#main-chat-content')[0].scrollHeight);

                // Kirim pesan ke server
                $.ajax({
                    url: "{{ route('sendMessageAdmin') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        message: message
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            let formattedMessage = response.message;

                            const aiMessageHtml = `
                            <li class="chat-item-start">
                                <div class="chat-list-inner">
                                    <div class="chat-user-profile">
                                        <span class="avatar avatar-md online avatar-rounded chatstatusperson">
                                            <img class="chatimageperson" src="../../assets/images/gpt.png" alt="img">
                                        </span>
                                    </div>
                                    <div class="ms-3">
                                        <span class="chatting-user-info">
                                            <span class="chatnameperson">xBug Ai</span>
                                            <span class="msg-sent-time">now</span>
                                        </span>
                                        <div class="main-chat-msg">
                                            <div class="response-text"></div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        `;
                            $('#main-chat-content ul').append(aiMessageHtml);
                            $('#main-chat-content').scrollTop($('#main-chat-content')[0].scrollHeight);

                            saveMessageToStorage("ai",
                            formattedMessage); // Simpan respons AI ke local storage
                            displayResponse(formattedMessage);
                            $('#loading-btn').hide();
                        }
                    },
                    error: function(response) {
                        let formattedMessage = response.responseJSON.message || "Something went wrong!";
                        const errorHtml = `
                        <li class="chat-item-start">
                            <div class="chat-list-inner">
                                <div class="chat-user-profile">
                                    <span class="avatar avatar-md online avatar-rounded chatstatusperson">
                                        <img class="chatimageperson" src="../../assets/images/gpt.png" alt="img">
                                    </span>
                                </div>
                                <div class="ms-3">
                                    <span class="chatting-user-info">
                                        <span class="chatnameperson">xBug Ai</span>
                                        <span class="msg-sent-time">now</span>
                                    </span>
                                    <div class="main-chat-msg">
                                        <div class="response-text bg-danger-transparent fw-bold">
                                            <span class="text-danger">${formattedMessage}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    `;
                        $('#main-chat-content ul').append(errorHtml);
                        $('#main-chat-content').scrollTop($('#main-chat-content')[0].scrollHeight);

                        saveMessageToStorage("ai",
                        formattedMessage); // Simpan respons error ke local storage
                        $('#loading-btn').hide();
                    }
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
                const chatHistory = JSON.parse(localStorage.getItem(CHAT_STORAGE_KEY)) || [];
                chatHistory.push({
                    sender,
                    message
                });
                localStorage.setItem(CHAT_STORAGE_KEY, JSON.stringify(chatHistory));
            }

            function loadChatHistory() {
                const chatHistory = JSON.parse(localStorage.getItem(CHAT_STORAGE_KEY)) || [];
                chatHistory.forEach(chat => {
                    const chatHtml = chat.sender === "user" ?
                        `<li class="chat-item-end">
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
                    </li>` :
                        `<li class="chat-item-start">
                        <div class="chat-list-inner">
                            <div class="chat-user-profile">
                                <span class="avatar avatar-md online avatar-rounded chatstatusperson">
                                    <img class="chatimageperson" src="../../assets/images/gpt.png" alt="img">
                                </span>
                            </div>
                            <div class="ms-3">
                                <span class="chatting-user-info">
                                    <span class="chatnameperson">xBug Ai</span>
                                    <span class="msg-sent-time">Previous</span>
                                </span>
                                <div class="main-chat-msg">
                                    <div>${chat.message}</div>
                                </div>
                            </div>
                        </div>
                    </li>`;
                    $('#main-chat-content ul').append(chatHtml);
                });
                $('#main-chat-content').scrollTop($('#main-chat-content')[0].scrollHeight);
            }
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