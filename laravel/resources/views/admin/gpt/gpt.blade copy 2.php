@extends('admin.layouts.main')
@section('container')
    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container">
            <div class="main-chart-wrapper p-2 gap-2 d-lg-flex">
                <div class="chat-info border">
                    <div class="chat-search p-3 border-bottom">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0" placeholder="Search Chat"
                                aria-describedby="button-addon2">
                            <button aria-label="button" class="btn btn-light" type="button" id="button-addon2"><i
                                    class="ri-search-line text-muted"></i></button>
                        </div>
                    </div>
                    <ul class="nav nav-tabs tab-style-2 nav-justified mb-0 border-bottom d-flex" id="myTab1"
                        role="tablist">
                        <li class="nav-item border-end me-0" role="presentation">
                            <button class="nav-link active h-100" id="users-tab" data-bs-toggle="tab"
                                data-bs-target="#users-tab-pane" type="button" role="tab"
                                aria-controls="users-tab-pane" aria-selected="true"><i
                                    class="ri-history-line me-1 align-middle d-inline-block"></i>Recent</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active border-0 chat-users-tab" id="users-tab-pane" role="tabpanel"
                            aria-labelledby="users-tab" tabindex="0">
                            <ul class="list-unstyled mb-0 mt-2 chat-users-tab" id="chat-msg-scroll">
                                <li class="pb-0">
                                    <p class="text-muted fs-11 fw-semibold mb-2 op-7">ACTIVE CHATS</p>
                                </li>
                                <li class="checkforactive">
                                    <a href="javascript:void(0);" onclick="changeTheInfo(this,'Sujika','5','online')">
                                        <div class="d-flex align-items-top">
                                            <div class="me-1 lh-1">
                                                <span class="avatar avatar-md online me-2 avatar-rounded">
                                                    <img src="../assets/images/faces/5.jpg" alt="img">
                                                </span>
                                            </div>
                                            <div class="flex-fill">
                                                <p class="mb-0 fw-semibold">
                                                    Sujika sdsds<span
                                                        class="float-end text-muted fw-normal fs-11">1:32PM</span>
                                                </p>
                                                <p class="fs-12 mb-0">
                                                    <span class="chat-msg text-truncate">Need to go for
                                                        lunch?</span>
                                                    <span class="chat-read-icon float-end align-middle"><i
                                                            class="ri-check-double-fill"></i></span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane fade border-0 chat-groups-tab" id="groups-tab-pane" role="tabpanel"
                            aria-labelledby="groups-tab" tabindex="0">
                        </div>
                        <div class="tab-pane fade border-0 chat-calls-tab" id="calls-tab-pane" role="tabpanel"
                            aria-labelledby="calls-tab" tabindex="0">
                            <ul class="list-unstyled mb-0 mt-2 chat-calls-tab">
                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="me-1 lh-1">
                                            <span class="avatar avatar-md online me-2 avatar-rounded">
                                                <img src="../assets/images/faces/5.jpg" alt="img">
                                            </span>
                                        </div>
                                        <div class="flex-fill my-auto">
                                            <p class="mb-0 fw-semibold">
                                                Sujika
                                                <span class="ms-1 incoming-call-success"><i
                                                        class="ti ti-arrow-down-left"></i></span>
                                            </p>
                                            <p class="fs-12 mb-0">
                                                <span class="text-muted text-truncate">Today,12:47PM</span>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="main-chat-area border">
                    <div class="d-flex align-items-center p-2 border-bottom">
                        <div class="me-2 lh-1">
                            <span class="avatar avatar-lg online me-2 avatar-rounded chatstatusperson">
                                <img class="chatimageperson" src="../assets/images/faces/2.jpg" alt="img">
                            </span>
                        </div>
                        <div class="flex-fill">
                            <p class="mb-0 fw-semibold fs-14">
                                <a href="javascript:void(0);" class="chatnameperson responsive-userinfo-open">Emiley
                                    ddJackson</a>
                            </p>
                            <p class="text-muted mb-0 chatpersonstatus">online</p>
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
                                class="btn btn-icon btn-outline-light my-1 ms-2 responsive-chat-close">
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                    </div>
                    <div class="chat-content" id="main-chat-content">
                        <ul class="list-unstyled">
                            <li class="chat-day-label">
                                <span>Today</span>
                            </li>
                        </ul>
                    </div>
                    <div class="chat-footer">
                        <input class="form-control" placeholder="Type your message here..." type="text">
                        <a aria-label="anchor" class="btn btn-primary btn-icon btn-send" href="javascript:void(0)">
                            <i class="ri-send-plane-2-line"></i>
                        </a>
                    </div>
                </div>

            </div>
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
            let image = `../assets/images/faces/${img}.jpg`
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
@endsection
