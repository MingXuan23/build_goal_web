@extends('organization.layouts.main')
@section('container')
    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container">
            <!-- Start::row-1 -->            
            <div class="main-chart-wrapper p-1 gap-1 d-lg-flex">
                <div class="main-chat-area border">
                    <div class="d-flex align-items-center p-2 border-bottom">
                        <div class="me-2 lh-1">
                            <span class="avatar avatar-lg online me-2 avatar-rounded chatstatusperson">
                                <img class="chatimageperson" src="../../assets/images/gpt.png" alt="img">
                            </span>
                        </div>
                        <div class="flex-fill">
                            <p class="mb-0 fw-semibold fs-14">
                                <a href="javascript:void(0);" class="chatnameperson responsive-userinfo-open">xBug GPT</a>
                                      <p class="text-muted mb-0 chatpersonstatus">online</p>
                            </p>
                        </div>
                        <div class="d-flex flex-wrap rightIcons">
                            <button aria-label="button" type="button" class="btn btn-icon btn-outline-light my-1 ms-2">
                                <i class="ti ti-phone"></i>
                            </button>
                            <button aria-label="button" type="button" class="btn btn-icon btn-outline-light my-1 ms-2">
                                <i class="ti ti-video"></i>
                            </button>
                        </div>
                    </div>
                    <div class="chat-content" id="main-chat-content" style="overflow-y: scroll;">
                        <ul class="list-unstyled">
                            <li class="chat-day-label">
                                <span>Today</span>
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
                                            <span class="chatnameperson">xBug GPT</span> <span class="msg-sent-time">11:48PM</span>
                                        </span>
                                        <div class="main-chat-msg">
                                            <div>
                                                <p class="mb-0">Hi {{Auth::user()->name}}, how can I assist you today? &#128512;</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        
                    </div>
                    <div class="chat-footer">
                        <input id="chat-input" class="form-control" placeholder="Type your message or question here....." type="text">
                        <button id="send-btn" class="btn btn-primary mx-2 btn-icon btn-send" type="submit">
                            <i class="ri-send-plane-2-line"></i>
                        </button>
                    </div>                    
                </div>

            </div>
                     
            <!--End::row-1 -->
        </div>
    </div>

<script>
   $(document).ready(function() {
    $('#send-btn').on('click', function(e) {
        e.preventDefault();

        let message = $('#chat-input').val();
        if (message.trim() === '') {
            alert('Please enter a message.');
            return;
        }

        // Tambahkan pesan user ke chat area
        $('#main-chat-content ul').append(`
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
        `);

        // Kosongkan input setelah pesan terkirim
        $('#chat-input').val('');

        // Scroll ke bawah setelah pesan ditambahkan
        $('#main-chat-content').scrollTop($('#main-chat-content')[0].scrollHeight);

        // AJAX request ke server
        $.ajax({
            url: "{{ route('sendMessage') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                message: message
            },
            success: function(response) {
                if (response.status === 'success') {
                    // Formatkan respons AI menjadi HTML yang lebih terstruktur
                    let formattedMessage = response.message;

                    // Tambahkan balasan AI ke chat area
                    $('#main-chat-content ul').append(`
                        <li class="chat-item-start">
                            <div class="chat-list-inner">
                                <div class="chat-user-profile">
                                    <span class="avatar avatar-md online avatar-rounded chatstatusperson">
                                        <img class="chatimageperson" src="../../assets/images/gpt.png" alt="img">
                                    </span>
                                </div>
                                <div class="ms-3">
                                    <span class="chatting-user-info">
                                        <span class="chatnameperson">xBug GPT</span>
                                        <span class="msg-sent-time">Now</span>
                                    </span>
                                    <div class="main-chat-msg">
                                        <div class="response-text"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    `);

                    // Scroll ke bawah setelah balasan ditambahkan
                    $('#main-chat-content').scrollTop($('#main-chat-content')[0].scrollHeight);

                    // Fungsi untuk menampilkan teks satu persatu dengan format HTML
                    displayResponse(formattedMessage);
                }
            },
            error: function() {
                alert('Failed to send message. Please try again.');
            }
        });
    });

    // Fungsi untuk menampilkan respons satu per satu dengan format HTML
    function displayResponse(message) {
        const responseContainer = $('#main-chat-content ul li:last-child .response-text');
        let messageIndex = 0;
        let isTag = false;
        let tagBuffer = '';
        let currentTag = '';
        let isBold = false;  // Menambahkan status untuk mendeteksi teks yang bold
        let boldTextBuffer = '';
        let formattedMessage = ''; // Buffer untuk format pesan

        // Hapus teks yang ada sebelumnya
        responseContainer.html('');

        // Fungsi untuk menambahkan teks satu karakter pada satu waktu
        const intervalId = setInterval(function() {
            let char = message.charAt(messageIndex);
            messageIndex++;

            // Cek apakah kita sedang berada di dalam tag HTML
            if (char === '<') {
                isTag = true;
                tagBuffer = '<'; // Mulai tag baru
                currentTag = '';
            } else if (char === '>') {
                isTag = false;
                tagBuffer += '>';
                formattedMessage += tagBuffer; // Tampilkan tag HTML secara lengkap
                tagBuffer = ''; // Reset buffer tag
            }

            if (isTag) {
                tagBuffer += char; // Teruskan mengumpulkan tag HTML
            } else {
                // Deteksi dan tangani teks yang berada di dalam tanda **
                if (char === '*' && message.charAt(messageIndex) === '*') {
                    if (isBold) {
                        // Akhiri bold jika sudah dalam tag **
                        formattedMessage += '<strong>' + boldTextBuffer + '</strong>';
                        boldTextBuffer = '';
                    }
                    isBold = !isBold; // Toggle status bold
                    messageIndex++; // Lewati karakter kedua *
                } else {
                    if (isBold) {
                        boldTextBuffer += char; // Simpan karakter dalam buffer bold
                    } else {
                        if (char === '\n') {
                            // Menambahkan <br> untuk line breaks
                            formattedMessage += '<br>';
                        } else {
                            // Tampilkan karakter biasa
                            formattedMessage += char;
                        }
                    }
                }
            }

            // Update isi container dengan pesan yang telah diformat
            responseContainer.html(formattedMessage);

            $('#main-chat-content').scrollTop($('#main-chat-content')[0].scrollHeight); // Scroll ke bawah

            // Hentikan interval setelah semua teks ditampilkan
            if (messageIndex >= message.length) {
                clearInterval(intervalId);
            }
        }, 5); // Kecepatan tampilan (dalam milidetik)
    }


});

</script>

@endsection
