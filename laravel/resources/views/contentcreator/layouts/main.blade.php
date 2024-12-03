<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="color" data-header-styles="light"
    data-menu-styles="color" data-toggled="close" style="--primary-rgb: 17,28,67;">

<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> xBug </title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords"
        content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">
    <!-- Favicon -->
    <link rel="icon" href="../../assets/images/brand-logos/favicon.ico" type="image/x-icon">
    <!-- Choices JS -->
    <script src="../../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <!-- Main Theme Js -->
    <script src="../../assets/js/main.js"></script>
    <!-- Bootstrap Css -->
    <link id="style" href="../../assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Style Css -->
    <link href="../../assets/css/styles.min.css" rel="stylesheet">
    <!-- Icons Css -->
    <link href="../../assets/css/icons.css" rel="stylesheet">
    <!-- Node Waves Css -->
    <link href="../../assets/libs/node-waves/waves.min.css" rel="stylesheet">
    <!-- Simplebar Css -->
    <link href="../../assets/libs/simplebar/simplebar.min.css" rel="stylesheet">
    <!-- Color Picker Css -->
    <link rel="stylesheet" href="../../assets/libs/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="../../assets/libs/@simonwep/pickr/themes/nano.min.css">
    <!-- Choices Css -->
    <link rel="stylesheet" href="../../assets/libs/choices.js/public/assets/styles/choices.min.css">
    <link rel="stylesheet" href="../../assets/libs/jsvectormap/css/jsvectormap.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
</head>

<body>
    <!-- Start Switcher -->

    @include('contentcreator.layouts.switcher')
    <!-- End Switcher -->
    <!-- Loader -->
    <div id="loader">
        <img src="../../assets/images/media/loader.svg" alt="">
    </div>
    <!-- Loader -->
    <div class="page">
        <!-- app-header -->
        @include('contentcreator.layouts.header')

        <!-- /app-header -->
        <!-- Start::app-sidebar -->
        @include('contentcreator.layouts.sidebar')

        <!-- End::app-sidebar -->

        @yield('container')

        <!-- Footer start -->
        @include('contentcreator.layouts.footer')

        <!-- Footer End -->
    </div>
    <!-- Scroll To Top -->
    <div class="scrollToTop">
        <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
    </div>

    <script>
        function changeRole(select) {
            const role = select.value;
            if (role) {
                window.location.href = `/${role}/dashboard`;
            }
        }
    </script>
    <script>
        // Function to toggle fullscreen
        // Function to toggle fullscreen
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                // Request fullscreen for the document
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) { // Firefox
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) { // Chrome, Safari
                    document.documentElement.webkitRequestFullscreen();
                } else if (document.documentElement.msRequestFullscreen) { // IE/Edge
                    document.documentElement.msRequestFullscreen();
                }

                // Switch icons visibility
                document.querySelector('.full-screen-open').classList.add('d-none');
                document.querySelector('.full-screen-close').classList.remove('d-none');

                // Save fullscreen state
                localStorage.setItem('isFullscreen', 'true');
            } else {
                // Exit fullscreen
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.mozCancelFullScreen) { // Firefox
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) { // Chrome, Safari
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) { // IE/Edge
                    document.msExitFullscreen();
                }

                // Switch icons visibility
                document.querySelector('.full-screen-open').classList.remove('d-none');
                document.querySelector('.full-screen-close').classList.add('d-none');

                // Save fullscreen state
                localStorage.setItem('isFullscreen', 'false');
            }
        }

        // Check fullscreen state on page load with a slight delay
        window.addEventListener('load', function() {
            setTimeout(function() {
                if (localStorage.getItem('isFullscreen') === 'true') {
                    // If fullscreen was enabled before, enter fullscreen again
                    if (document.documentElement.requestFullscreen) {
                        document.documentElement.requestFullscreen();
                    } else if (document.documentElement.mozRequestFullScreen) { // Firefox
                        document.documentElement.mozRequestFullScreen();
                    } else if (document.documentElement.webkitRequestFullscreen) { // Chrome, Safari
                        document.documentElement.webkitRequestFullscreen();
                    } else if (document.documentElement.msRequestFullscreen) { // IE/Edge
                        document.documentElement.msRequestFullscreen();
                    }

                    // Switch icons visibility
                    document.querySelector('.full-screen-open').classList.add('d-none');
                    document.querySelector('.full-screen-close').classList.remove('d-none');
                }
            }, 100); // Slight delay to ensure fullscreen request is processed
        });

        // Optional: Listen for fullscreen change events to toggle icons
        document.addEventListener('fullscreenchange', function() {
            if (document.fullscreenElement) {
                document.querySelector('.full-screen-open').classList.add('d-none');
                document.querySelector('.full-screen-close').classList.remove('d-none');
                localStorage.setItem('isFullscreen', 'true');
            } else {
                document.querySelector('.full-screen-open').classList.remove('d-none');
                document.querySelector('.full-screen-close').classList.add('d-none');
                localStorage.setItem('isFullscreen', 'false');
            }
        });
    </script>
    <div id="responsive-overlay"></div>
    <!-- Scroll To Top -->
    <!-- Popper JS -->
    <script src="../../assets/libs/@popperjs/core/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Defaultmenu JS -->
    <script src="../../assets/js/defaultmenu.min.js"></script>
    <!-- Node Waves JS-->
    <script src="../../assets/libs/node-waves/waves.min.js"></script>
    <!-- Sticky JS -->
    <script src="../../assets/js/sticky.js"></script>
    <!-- Simplebar JS -->
    <script src="../../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../../assets/js/simplebar.js"></script>
    <!-- Color Picker JS -->
    <script src="../../assets/libs/@simonwep/pickr/pickr.es5.min.js"></script>
    <!-- Apex Charts JS -->
    <script src="../../assets/libs/apexcharts/apexcharts.min.js"></script>
    <!-- JSVector Maps JS -->
    <script src="../../assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
    <!-- JSVector Maps MapsJS -->
    <script src="../../assets/libs/jsvectormap/maps/world-merc.js"></script>
    <!-- Date & Time Picker JS -->
    <script src="../../assets/libs/flatpickr/flatpickr.min.js"></script>
    <!-- Sales-Dashboard JS -->
    {{-- <script src="../../assets/js/sales-dashboard.js"></script> --}}
    <!-- Custom-Switcher JS -->
    <script src="../../assets/js/custom-switcher.min.js"></script>
    <!-- Custom JS -->
    <script src="../../assets/js/custom.js"></script>

    <script src="../../assets/js/jQuery.js"></script>
    <script src="../assets/js/hrm-dashboard.js"></script>

    <!-- Internal Datatables JS -->
    <script src="../../assets/js/datatables.js"></script>

        <!-- Datatables Cdn -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.6/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>



</body>

</html>
