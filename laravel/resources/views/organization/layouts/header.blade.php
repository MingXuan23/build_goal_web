<header class="app-header ">
    <!-- Start::main-header-container -->
    <div class="main-header-container container-fluid">
        <!-- Start::header-content-left -->
        <div class="header-content-left "
             data-intro="Click this to show or hide the sidebar."
             data-step="9">
            <div class="header-element">
                <!-- Start::header-link -->
                <a aria-label="Hide Sidebar"
                    class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle"
                    data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
                <!-- End::header-link -->
            </div>
        </div>
        <!-- End::header-content-left -->

        <div class="header-content-right">
            <div class="header-element"
                 data-intro="This section shows your e-KYC status."
                 data-step="13">
                <a href="javascript:void(0);" class="header-link dropdown-toggle">
                    @if (Auth::user()->ekyc_status === 0)
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="bg-danger-transparent rounded p-2 d-flex align-items-center">
                                <i class="bi bi-patch-exclamation-fill text-danger fs-5 me-2"></i>
                                <span class="fw-bold">Pending e-KYC</span>
                            </div>
                        </div>
                    @else
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="rounded d-flex align-items-center p-2">
                                <i class="ri-checkbox-circle-line text-success fs-5 me-1"></i>
                                <span class="fw-bold text-success">e-KYC Verified</span>
                            </div>
                        </div>
                    @endif
                </a>
            </div>
            <div class="header-element header-fullscreen">
                <!-- Start::header-link -->
                <a href="/" class="header-link">
                    <i class="bx bxs-home header-link-icon"></i>
                </a>
                <!-- End::header-link -->
            </div>

            <!-- Role Selection Dropdown -->
            @php
                // Data peran
                $rolesMap = [
                    1 => 'admin',
                    2 => 'organization',
                    3 => 'content-creator',
                    5 => 'mobile-user',
                ];

                $userRoles = is_string(Auth::user()->role) ? json_decode(Auth::user()->role, true) : Auth::user()->role;

                if (!is_array($userRoles)) {
                    $userRoles = [];
                }

                $roleNames = array_map(fn($role) => $rolesMap[$role] ?? 'unknown', $userRoles);

                $currentUrl = request()->url();
                $selectedRole = null;

                if (str_contains($currentUrl, '/organization') && in_array(2, $userRoles)) {
                    $selectedRole = 2;
                } elseif (str_contains($currentUrl, '/admin') && in_array(1, $userRoles)) {
                    $selectedRole = 1;
                } elseif (str_contains($currentUrl, '/content-creator') && in_array(3, $userRoles)) {
                    $selectedRole = 3;
                } elseif (str_contains($currentUrl, '/mobile-user') && in_array(5, $userRoles)) {
                    $selectedRole = 5;
                }
            @endphp

            <div class="header-element"
                 data-intro="Manage your roles and access different xBug APP here."
                 data-step="15">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown"
                    data-bs-auto-close="outside" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <i class="ms-2 bx bx-grid-alt header-link-icon"></i>
                    </div>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                    <div class="p-3 d-flex">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 fs-17 fw-semibold">App</p>
                        </div>
                    </div>
                    <div>
                        <hr class="dropdown-divider">
                    </div>
                    <ul class="list-unstyled mb-0" id="header-notification-scroll">
                        <li class="dropdown-item">
                            <div class="d-flex align-items-center">
                                <div class="pe-2">
                                    <span class="avatar avatar-md text-success avatar-rounded">
                                        <i class="bx bxs-user-circle fs-34"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 d-flex align-items-center justify-content-between p-2">
                                    <div>
                                        <span class="mb-0 fw-semibold p-2">
                                            <a
                                                href="/organization/dashboard">xBUG WEB</a>
                                        </span>
                                    </div>
                                    <div>
                                        <a  href="/organization/dashboard"
                                            class="min-w-fit-content text-muted me-1 dropdown-item-close1" >
                                            <i class="bx bx-right-arrow-alt fs-22"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-item">
                            <div class="d-flex align-items-center">
                                <div class="pe-2">
                                    <span class="avatar avatar-md text-dark avatar-rounded">
                                        <i class="bx bxs-user-circle fs-34"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 d-flex align-items-center justify-content-between p-2">
                                    <div>
                                        <span class="mb-0 fw-semibold p-2">
                                            <a
                                                href="{{env('XBUG_BLOCKCHAIN_URL')}}/smart-contract-redirect">xBUG Blockchain WEB</a>
                                        </span>
                                    </div>
                                    <div>
                                        <a  href="{{env('XBUG_BLOCKCHAIN_URL')}}/smart-contract-redirect"
                                            class="min-w-fit-content text-muted me-1 dropdown-item-close1">
                                            <i class="bx bx-right-arrow-alt fs-22"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="p-3 mt-2 d-flex">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 fs-17 fw-semibold">Role</p>
                        </div>
                    </div>
                    <div>
                        <hr class="dropdown-divider">
                    </div>
                    <ul class="list-unstyled mb-0" id="header-notification-scroll">
                        @foreach ($userRoles as $role)
                            @php
                                $roleClass = '';
                                switch ($role) {
                                    case 1:
                                        $roleClass = 'bg-danger-transparent'; // Admin
                                        break;
                                    case 2:
                                        $roleClass = 'bg-warning-transparent'; // Organization
                                        break;
                                    case 3:
                                        $roleClass = 'bg-info-transparent'; // Content Creator
                                        break;
                                    case 5:
                                        $roleClass = 'bg-success-transparent'; // Mobile User
                                        break;
                                }
                            @endphp
                            <li class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <div class="pe-2">
                                        <span class="avatar avatar-md {{ $roleClass }} avatar-rounded">
                                            <i class="bx bxs-user-circle fs-34"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 d-flex align-items-center justify-content-between p-2">
                                        <div>
                                            <span class="mb-0 fw-semibold p-2">
                                                <a
                                                    href="{{ url('/' . $rolesMap[$role] . '/dashboard') }}">{{ ucfirst($rolesMap[$role]) }}</a>
                                            </span>
                                        </div>
                                        <div>
                                            <a href="{{ url('/' . $rolesMap[$role] . '/dashboard') }}"
                                                class="min-w-fit-content text-muted me-1 dropdown-item-close1">
                                                <i class="bx bx-right-arrow-alt fs-22"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <div class="p-2 empty-header-item border-top"></div>
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

            <div class="header-element"
                 data-intro="Access your profile and logout options here."
                 data-step="17">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile"
                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div class="me-sm-2 me-0">
                            <img src="../assets/images/user/avatar-1.jpg" alt="img" width="32" height="32"
                                class="rounded-circle">
                        </div>
                        <div class="d-sm-block d-none">
                            <p class="fw-bold mb-0 lh-1">
                                {{ implode(' ', array_slice(explode(' ', Auth::user()->name), 0, 2)) }}</p>
                            <span class="op-7 fw-semibold d-block fs-11">Organization</span>
                        </div>
                    </div>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
                    aria-labelledby="mainHeaderProfile">
                    <li><a class="dropdown-item d-flex" href="/organization/profile"><i
                                class="ti ti-user-circle fs-18 me-2 op-7"></i>Profile</a></li>
                    <li>
                        <a class="dropdown-item d-flex" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ti ti-logout fs-18 me-2 op-7"></i>
                            LogOut
                        </a>

                        <!-- Form Logout -->
                        <form id="logout-form" action="{{ route('organization.logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End::main-header-container -->
</header>
