<header class="app-header ">
    <!-- Start::main-header-container -->
    <div class="main-header-container container-fluid">
        <!-- Start::header-content-left -->
        <div class="header-content-left ">
            <div class="header-element">
                <!-- Start::header-link -->
                <a aria-label="Hide Sidebar"
                    class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle"
                    data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
                <!-- End::header-link -->
            </div>
        </div>
        <div class="header-content-right">
            {{-- <div class="header-element header-theme-mode p-3 mt-1">
             <!-- Start::header-link|layout-setting -->
             <b>
                <svg class="me-1 text-primary" xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-emoji-laughing-fill" viewBox="0 0 16 16">
                   <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16M7 6.5c0 .501-.164.396-.415.235C6.42 6.629 6.218 6.5 6 6.5s-.42.13-.585.235C5.164 6.896 5 7 5 6.5 5 5.672 5.448 5 6 5s1 .672 1 1.5m5.331 3a1 1 0 0 1 0 1A5 5 0 0 1 8 13a5 5 0 0 1-4.33-2.5A1 1 0 0 1 4.535 9h6.93a1 1 0 0 1 .866.5m-1.746-2.765C10.42 6.629 10.218 6.5 10 6.5s-.42.13-.585.235C9.164 6.896 9 7 9 6.5c0-.828.448-1.5 1-1.5s1 .672 1 1.5c0 .501-.164.396-.415.235"/>
                </svg>
             </b>
             <!-- Start::header-link-icon -->
             <span class="text-primary ms-1"><b>Admin</b></span>
             <!-- End::header-link-icon -->
          </div> --}}
            <!-- Start::header-element -->
            <div class="header-element header-theme-mode">
                <!-- Start::header-link|layout-setting -->
                {{-- <a href="javascript:void(0);" class="header-link layout-setting">
                    <span class="light-layout">
                        <!-- Start::header-link-icon -->
                        <i class="bx bx-moon header-link-icon"></i>
                        <!-- End::header-link-icon -->
                    </span>
                    <span class="dark-layout">
                        <!-- Start::header-link-icon -->
                        <i class="bx bx-sun header-link-icon"></i>
                        <!-- End::header-link-icon -->
                    </span>
                </a> --}}
            </div> <div class="header-element">
                <div class="d-flex align-items-center ">
                    <div class="bg-warning-transparent rounded p-2">
                        <i class="bi bi-bookmark-dash-fill text-warning"></i>
                        <span class="fw-bold">pending e-kyc</span>
                        
                    </div>
                </div>
               
            </div>
            <div class="header-element header-fullscreen">
                <!-- Start::header-link -->
                <a onclick="toggleFullscreen();" href="javascript:void(0);" class="header-link">
                    <i class="bx bx-fullscreen full-screen-open header-link-icon"></i>
                    <i class="bx bx-exit-fullscreen full-screen-close header-link-icon d-none"></i>
                </a>
                <!-- End::header-link -->
            </div>
            <!-- End::header-element -->
            {{-- <div class="header-element country-selector">
             <!-- Start::header-link|dropdown-toggle -->
             <a href="javascript:void(0);" class="header-link dropdown-toggle"
                data-bs-auto-close="outside" data-bs-toggle="dropdown">
             <i class="bx bx-cog header-link-icon"></i>
             </a>
             <!-- End::header-link|dropdown-toggle -->
             <ul class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                <li>
                   <a class="dropdown-item d-flex align-items-center" href="./p.php">
                      <span class="avatar avatar-xs lh-1 me-2">
                         <svg class="text-dark" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="currentColor" class="bi bi-person-circle"
                            viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                            <path fill-rule="evenodd"
                               d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                         </svg>
                      </span>
                      Profile
                   </a>
                </li>
                <li>
                   <a class="dropdown-item d-flex align-items-center" href="../logout.php">
                      <span class="avatar avatar-xs lh-1 me-2">
                         <svg xmlns="http://www.w3.org/2000/svg"
                            class="icon icon-tabler icon-tabler-logout-2" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="black"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path
                               d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2">
                            </path>
                            <path d="M15 12h-12l3 -3"></path>
                            <path d="M6 15l-3 -3"></path>
                         </svg>
                      </span>
                      Log Out
                   </a>
                </li>
             </ul>
          </div> --}}

            <div class="header-element">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile"
                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div class="me-sm-2 me-0">
                            <img src="../assets/images/user/avatar-1.jpg" alt="img" width="32" height="32"
                                class="rounded-circle">
                        </div>
                        <div class="d-sm-block d-none">
                            <p class="fw-bold mb-0 lh-1">Khairul Adzhar</p>
                            <span class="op-7 fw-semibold d-block fs-11">Content Creator</span>
                        </div>
                    </div>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
                    aria-labelledby="mainHeaderProfile">
                    <li><a class="dropdown-item d-flex" href="/admin/profile"><i
                                class="ti ti-user-circle fs-18 me-2 op-7"></i>Profile</a></li>
                    <li><a class="dropdown-item d-flex" href="#"><i
                                class="ti ti-logout fs-18 me-2 op-7"></i>Log Out</a></li>
                </ul>
            </div>
            <div class="header-element">
                <!-- Start::header-link|switcher-icon -->
                <a href="javascript:void(0);" class="header-link switcher-icon" data-bs-toggle="offcanvas"
                    data-bs-target="#switcher-canvas">
                    <i class="bx bx-cog header-link-icon"></i>
                </a>
                <!-- End::header-link|switcher-icon -->
            </div>
        </div>
    </div>
    <!-- End::main-header-container -->
</header>
