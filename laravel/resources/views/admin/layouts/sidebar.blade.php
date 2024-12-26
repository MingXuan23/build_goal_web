<aside class="app-sidebar sticky" id="sidebar">
    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="" class="header-logo">
            <h5 class="fw-bold text-light">xBug</h5>
        </a>
    </div>
    <!-- End::main-sidebar-header -->
    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll ">
        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Main</span></li>
                <!-- End::slide__category -->
                <!-- Start::slide -->
                <li class="slide">
                    <a href="/admin/dashboard" class="side-menu__item">
                        <i class="bx bx-home side-menu__icon"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item ">
                        <i class='bx bxs-user-detail side-menu__icon' ></i>
                        <span class="side-menu__label">User Management</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="/admin/user" class="side-menu__item">User Web</a>
                        </li>
                        <li class="slide">
                            <a href="/admin/user-mobile" class="side-menu__item">User Mobile</a>
                        </li>
                        <li class="slide">
                            <a href="/admin/add-user" class="side-menu__item">Add User</a>
                        </li>
                    </ul>
                </li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item ">
                        <i class='bx bx-align-left side-menu__icon'></i>
                        <span class="side-menu__label ">Content</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="/admin/view-content" class="side-menu__item">Applied Content</a>
                        </li>
                        <li class="slide">
                            <a href="/admin/view-xbug-stand" class="side-menu__item">Applied xBUG Stand</a>
                        </li>
                        <!-- <li class="slide">
                            <a href="/organization/apply-content" class="side-menu__item">Apply Content</a>
                        </li> -->
                    </ul>
                </li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item ">
                        <i class='bx bxs-book-content side-menu__icon'></i>
                        <span class="side-menu__label ">Content User</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="/admin/content-user" class="side-menu__item">Viewed & Click Content</a>
                        </li>
                        <li class="slide">
                            <a href="/admin/content-user-enrolled" class="side-menu__item">Enrolled Content</a>
                        </li>
                    </ul>
                </li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item ">
                        <i class="bx bx-mail-send side-menu__icon"></i>
                        <span class="side-menu__label ">Email Notifications</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="/admin/email" class="side-menu__item">Send Email</a>
                        </li>
                        <li class="slide">
                            <a href="/admin/email-notification-logs" class="side-menu__item">Notification Logs</a>
                        </li>
                    </ul>
                </li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item ">
                        <i class='bx bxs-select-multiple side-menu__icon'></i>
                        <span class="side-menu__label ">e-KYC Logs</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="/admin/card-logs" class="side-menu__item">Card Log</a>
                        </li>
                        <li class="slide">
                            <a href="/admin/face-logs" class="side-menu__item">Face Log</a>
                        </li>

                    </ul>
                </li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item ">
                        <i class="bx bxs-envelope side-menu__icon"></i>
                        <span class="side-menu__label ">Email Logs</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="/admin/email-logs" class="side-menu__item">email logs</a>
                        </li>
                    </ul>
                </li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item ">
                        <i class='bx bxs-cog side-menu__icon'></i>
                        <span class="side-menu__label ">Setting</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="/admin/package" class="side-menu__item">Package</a>
                        </li>
                    </ul>
                </li>
                <li class="slide__category mt-4"><span class="category-name">xBug GPT</span></li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item ">
                        <img src="../../assets/images/gpt.png" alt="" width="28px" height="28px">
                        <span class="side-menu__label mx-2">xBug GPT</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="/admin/chatbot" class="side-menu__item">ChatBot</a>
                        </li>
                    </ul>
                </li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item ">
                        <i class='bx bxs-cog side-menu__icon mx-1'></i>
                        <span class="side-menu__label mx-2">setting</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="/admin/gpt-model" class="side-menu__item">Model</a>
                        </li>
                        <li class="slide">
                            <a href="/admin/gpt-usage" class="side-menu__item">Usage</a>
                        </li>
                        <li class="slide">
                            <a href="/admin/gpt-log" class="side-menu__item">Logs</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>
        </nav>
        <!-- End::nav -->
    </div>
    <!-- End::main-sidebar -->
</aside>
