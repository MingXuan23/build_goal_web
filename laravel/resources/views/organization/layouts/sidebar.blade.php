<aside class="app-sidebar sticky" id="sidebar">
    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="" class="header-logo">
            <h5 class="fw-bold text-light">xBUG</h5>
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll"
         data-intro="Hi, Welcome to xBUG Dashboard Panel! This is the main part of your sidebar, containing the navigation menu."
         data-step="2">
        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>

            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category">
                    <span class="category-name">Main</span>
                </li>
                <!-- End::slide__category -->

                <!-- Start::slide (Dashboard)-->
                <li class="slide"
                    data-intro="This menu directs you to the main Dashboard."
                    data-step="3">
                    <a href="/organization/dashboard" class="side-menu__item">
                        <i class="bx bx-home side-menu__icon"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                <!-- End::slide (Dashboard) -->

                @if (Auth::user()->ekyc_status === 1) 
                <!-- Start::Content Menu -->
                <li class="slide has-sub"
                    data-intro="Here you can manage content, such as viewing or applying content."
                    data-step="4">
                    <a href="javascript:void(0);" class="side-menu__item ">
                        <i class='bx bx-align-left side-menu__icon'></i>
                        <span class="side-menu__label">Content</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <!-- Child Menu Content -->
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="/organization/content-management" class="side-menu__item">View Content</a>
                        </li>
                        <li class="slide">
                            <a href="/organization/apply-content" class="side-menu__item">Apply Content</a>
                        </li>
                        <li class="slide">
                            <a href="/organization/MicroLearning" class="side-menu__item">MicroLearning Resource</a>
                        </li>
                    </ul>
                </li>
                <!-- End::Content Menu -->

                <!-- Start::Content Activity Menu -->
                <li class="slide has-sub"
                    data-intro="This menu displays content-related activities, such as content that users have viewed or enrolled in."
                    data-step="5">
                    <a href="javascript:void(0);" class="side-menu__item ">
                        <i class='bx bxs-bar-chart-alt-2 side-menu__icon'></i>
                        <span class="side-menu__label">Content Activity</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <!-- Child Menu Activity -->
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="/organization/content-user" class="side-menu__item">Viewed & Click Content</a>
                        </li>
                        <li class="slide">
                            <a href="/organization/content-user-enrolled" class="side-menu__item">Enrolled Content</a>
                        </li>
                    </ul>
                </li>

                {{-- <li class="slide has-sub"
                    data-intro="This menu displays content-related activities, such as content that users have viewed or enrolled in."
                    data-step="5">
                    <a href="javascript:void(0);" class="side-menu__item ">
                        <i class='bx bxs-wallet-alt side-menu__icon'></i>
                        <span class="side-menu__label">Smart Contract</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <!-- Child Menu Activity -->
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="{{route('showContentBlockchainOrg')}}" class="side-menu__item">Deploy Smart Contract</a>
                        </li>
                    </ul>
                </li> --}}
                <!-- End::Content Activity Menu -->

                <!-- Start::Transaction History Menu -->
                <li class="slide has-sub"
                    data-intro="Menu for your transaction history, including premium content, xBug Card, and xBug Ai."
                    data-step="6">
                    <a href="javascript:void(0);" class="side-menu__item ">
                        <i class='bx bxs-bank side-menu__icon'></i>
                        <span class="side-menu__label ">Transaction History</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <!-- Child Menu Transaction -->
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="/organization/transaction-history-promote-content" class="side-menu__item">Promote Content</a>
                        </li>
                        <li class="slide">
                            <a href="/organization/transaction-history-xbug-card" class="side-menu__item">xBug Card</a>
                        </li>
                        <li class="slide">
                            <a href="/organization/transaction-history-xbug-ai" class="side-menu__item">xBug Ai</a>
                        </li>
                    </ul>
                </li>
                <!-- End::Transaction History Menu -->

                <!-- Start::Notifications Menu -->
                <li class="slide__category mt-1">
                    <span class="category-name">System</span>
                </li>
                <li class="slide has-sub"
                    data-intro="Menu to display your latest notifications."
                    data-step="7">
                    <a href="javascript:void(0);" class="side-menu__item ">
                        <i class='bx bxs-notification side-menu__icon'></i>
                        <span class="side-menu__label">Notifications</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <!-- Child Menu Notifications -->
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="/organization/notifications" class="side-menu__item">Your Notifications</a>
                        </li>
                    </ul>
                </li>
                <!-- End::Notifications Menu -->

                <!-- Start::xBUG Ai Menu -->
                <li class="slide__category">
                    <span class="category-name">xBUG Ai (Premium)</span>
                </li>
                <li class="slide has-sub"
                    data-intro="xBUG Ai is a premium feature for AI chatbot."
                    data-step="8">
                    <a href="javascript:void(0);" class="side-menu__item ">
                        <img src="../../assets/images/gpt.png" alt="xBUG Ai Logo" width="28px" height="28px">
                        <span class="side-menu__label mx-2">xBUG Ai</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <!-- Child Menu xBUG Ai -->
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="/organization/chatbot" class="side-menu__item">ChatBot</a>
                        </li>
                    </ul>
                </li>
                <!-- End::xBUG Ai Menu -->
                @endif
            </ul>

            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>
        </nav>
        <!-- End::nav -->
    </div>
    <!-- End::main-sidebar -->
</aside>
