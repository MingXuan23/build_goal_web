@extends('admin.layouts.main')
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
                                      <p class="text-muted mb-0 chatpersonstatus {{($status_model == 1) ? 'text-success fw-bold' : 'text-danger fw-bold'}} ">{{($status_model == 1) ? 'online' : 'offline'}}</p>
                            </p>
                            <div id="loading-btn" class="text-center" style="display: none;">
                                <button class="btn btn-success btn-loader mx-auto">
                                    <span class="me-2">Loading</span>
                                    <span class="loading"><i class="ri-loader-4-line fs-16 btn-loader"></i></span>
                                </button>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap rightIcons">
                            <button aria-label="button" type="button" class="btn btn-icon btn-outline-light my-1 ms-2">
                                <i class="ti ti-phone"></i>
                            </button>
                        </div>
                    </div>
                    <div class="chat-content" id="main-chat-content" style="overflow-y: scroll;">
                        <ul class="list-unstyled">
                            {{-- <li class="chat-day-label">
                                <span class=" bg-success-transparent text-success">Today</span>
                            </li>                         --}}
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
                                        @if ($status_model == 1)
                                        <div class="main-chat-msg">
                                            <div>
                                                <p class="mb-0">Hi {{Auth::user()->name}}, how can I assist you today? &#128512;</p>
                                            </div>
                                        </div>
                                        @else
                                        <div class="main-chat-msg">
                                            <div class="bg-danger-transparent fw-bold">
                                                <p class="mb-0">Hi {{Auth::user()->name}}, Sorry, xBug GPT is currently Unvailable. Contact Us By Email [help-center@xbug.online] For Information Or Inform Us</p>
                                            </div>
                                        </div>
                                        @endif
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

            $('#chat-input').val('');

            $('#main-chat-content').scrollTop($('#main-chat-content')[0].scrollHeight);

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

                        $('#main-chat-content').scrollTop($('#main-chat-content')[0].scrollHeight);

                        displayResponse(formattedMessage);
                        $('#loading-btn').hide();
                    }
                },
                error: function(response) {
                    let formattedMessage = response.responseJSON.message;
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
                                        <div class="main-chat-msg ">
                                            <div class="response-text bg-danger-transparent fw-bold"><span class="text-danger"></span></div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        `);
                        $('#main-chat-content').scrollTop($('#main-chat-content')[0].scrollHeight);
                        displayResponse(formattedMessage);
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
    });
</script>

@endsection
