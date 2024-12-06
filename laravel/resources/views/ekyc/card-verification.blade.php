
@php
    $useragent = $_SERVER['HTTP_USER_AGENT'];

    $is_mobile =
        preg_match(
            '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',
            $useragent,
        ) ||
        preg_match(
            '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/',
            substr($useragent, 0, 4),
        );

@endphp

<?php if (!$is_mobile): ?>
<?php
// Flash error message ke sesi sebelum redirect
session()->flash('error', 'Please login from a mobile device.');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Restricted</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body>
    <script>
        Swal.fire({
            icon: 'info',
            title: '',
            text: 'The e-KYC verification process can only be completed on a mobile device. Please login from a mobile device.',
            customClass: {
                title: 'custom-title',
                content: 'custom-content'
            },
            confirmButtonText: 'OK'
        }).then(() => {
            // Redirect ke login page
            window.location.href = "<?php echo e(route('login')); ?>?error=XxXxXxXxXxXx";
        });
    </script>
</body>

</html>
<?php exit(); ?>
<?php endif; ?>
<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>e-KYC | Card Verification</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- [Favicon] icon -->
    {{-- <link rel="icon" href="../../asset1/images/logo-test-white.png" type="image/x-icon" /> --}}
    <!-- [Font] Family -->
    <link rel="stylesheet" href="../../asset1/fonts/inter/inter.css" id="main-font-link" />
    <!-- [phosphor Icons] https://phosphoricons.com/ -->
    {{-- <link rel="stylesheet" href="../../asset1/fonts/phosphor/duotone/style.css" /> --}}
    <!-- [Tabler Icons] https://tablericons.com -->
    {{-- <link rel="stylesheet" href="../../asset1/fonts/tabler-icons.min.css" /> --}}
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="../../asset1/fonts/feather.css" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="../../asset1/fonts/fontawesome.css" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    {{-- <link rel="stylesheet" href="../../asset1/fonts/material.css" /> --}}
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="../../asset1/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="../../asset1/css/style-preset.css" />
    <link rel="stylesheet" href="../../asset1/css/landing.css" />



    <link rel="stylesheet" href="../../asset1/css/plugins/uppy.min.css" />

    <style>
        .custom-title {
            font-size: 14px;

        }

        .custom-content {
            font-size: 12px;

        }
    </style>

</head>
<!-- [Head] end -->

<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr"
    data-pc-theme_contrast="" data-pc-theme="light" data-pc-direction="ltr"
    style="background-color: rgba(255,253,255,255)" class="landing-page">
    <!-- [ Pre-loader ] start -->
    <div class="page-loader">
        <div class="bar"></div>
    </div>
    <!-- [ Pre-loader ] End -->

    <nav class="navbar navbar-expand-md navbar-light default shadow shadow-sm">
        <div class="container d-flex justify-content-center">
            <a class="navbar-brand" href="index.html">
                {{-- <img src="../../asset1/images/logo-test.png" class="img-fluid" width="80" height="60"
                    alt="logo" /> --}}
                <span class="fw-bold text-primary">xBug</span>
            </a>
        </div>
    </nav>


    <!-- Page 1 Start -->
    <div class="pc-container overflow-hidden page-1 mt-5">
        <div class="container">
            <!-- [ Main Content ] start -->
            <div class="row justify-content-center align-items-center">
                <div class="col-sm-12">
                    <div class="d-flex justify-content-center">
                        <img src="../../asset1/images/3333.png" alt="home-image" class="img-fluid" width="360"
                            height="360">
                    </div>
                </div>
                <div class="col-sm-12 mt-3">
                    <div class="d-flex justify-content-center">
                        <h1 class="wow fadeInUp" data-wow-delay="0.1s">
                            <span class="hero-text-gradient">Let's verify e-KYC</span>
                        </h1>
                    </div>
                </div>
                <div class="col-sm-3 p-3">
                    <div class="d-flex justify-content-center">
                        <p class="text-center">Please submit the following documents to verify your profile.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-lg-4 col-md-6">
                    <div class="card border border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avtar bg-light-primary">
                                        <i class="fas fa-id-card f-18"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <small class="text-muted">Step 1</small>
                                            <h5 class="mb-1">Upload a picture of your MyKad</h5>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="mb-0">To check your personal informations are correct</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-lg-4 col-md-6">
                    <div class="card border border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avtar bg-light-primary">
                                        <i class="fas fa-camera f-18"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <small class="text-muted">Step 2</small>
                                            <h5 class="mb-1">Take a selfie of yourself</h5>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="mb-0">To match your face with MyKad</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-lg-4 col-md-6 p-4">
                    <div class="d-grid mt-3">
                        <button id="btn-upd" class="btn btn-primary p-3">
                            Start Verification
                        </button>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->

            <!-- [ footer apps ] start -->
            <footer class="mt-auto py-3 text-center shadow shadow-md">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col my-1 wow fadeInUp" data-wow-delay="0.4s">
                            <span class="p-2"><span class="text-muted">All
                                    rights
                                    reserved Copyright © </span><span id="year"
                                    class="text-muted">2024</span><span class="fw-bold"> xBug</span> <span
                                    class="text-muted">Protected with Advanced
                                    Security</span>
                            </span>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- [ footer apps ] End -->
        </div>
    </div>
    <!-- Page 1 End -->

    <!-- Page 2 Start -->
    <div class="pc-container overflow-hidden page-2 mt-5">
        <div class="container">
            <!-- [ Main Content ] start -->
            <div class="row justify-content-center align-items-center">
                <div class="col-sm-12">
                    <div class="d-flex justify-content-center">
                        <img src="../../asset1/images/3333.png" alt="home-image" class="img-fluid" width="360"
                            height="360">
                    </div>
                </div>
                <div class="col-sm-12 mt-3">
                    <div class="d-flex justify-content-center">
                        <h1 class="wow fadeInUp" data-wow-delay="0.1s">
                            <span class="hero-text-gradient">Upload your MyKad</span>
                        </h1>
                    </div>

                </div>
                <div class="col-sm-3 p-4">
                    <div class="d-flex justify-content-center">
                        <p class="text-center">
                            Please make sure that all details on your MyKad are clearly visible in the camera frame, and
                            that your camera is in focus.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center align-items-center">
                <div class="col-lg-4 col-md-6 ">

                    <div class="card border border-0">
                        <div class="card-body">
                            <div class="pc-uppy" id="pc-uppy-1"> </div>
                            <div class="d-grid mt-3">
                                <button id="uploadButton" class="btn btn-primary">Upload MyKad</button>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="loading" id="loading">
                                    <img src="../../asset1/images/loading-4.gif" width="300" height="200"
                                        alt="Loading" />
                                    <p class="fw-bold text-center">Verifying MyKad...</p>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <!-- [ Main Content ] end -->

            <!-- [ footer apps ] start -->
            <footer class="mt-auto py-3 text-center shadow shadow-sm">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col my-1 wow fadeInUp" data-wow-delay="0.4s">
                            <span class="p-2 "><span class="text-muted">All
                                    rights
                                    reserved Copyright © </span><span id="year"
                                    class="text-muted">2024</span><span class="fw-bold"> xBug</span> <span
                                    class="text-muted">Protected with Advanced
                                    Security</span>
                            </span>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- [ footer apps ] End -->
        </div>
    </div>
    <!-- Page 2 End -->


    <!-- Required Js -->
    <script src="../../asset1/js/plugins/popper.min.js"></script>
    <script src="../../asset1/js/plugins/simplebar.min.js"></script>
    <script src="../../asset1/js/plugins/bootstrap.min.js"></script>
    <script src="../../asset1/js/fonts/custom-font.js"></script>
    <script src="../../asset1/js/pcoded.js"></script>
    <script src="../../asset1/js/plugins/feather.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../../asset1/js/plugins/uppy.min.js"></script>
    <script src="../../asset1/js/plugins/sweetalert2.all.min.js"></script>

    <script>
        $('.page-2').hide();

        $('#btn-upd').on('click', function() {
            $('.page-1').hide();
            $('.page-2').show();

        });
    </script>

    <!-- [Page Specific JS] start -->



    <script type="module">
        // Function for displaying uploaded files
        const onUploadSuccess = (elForUploadedFiles) => (file, response) => {
            const url = response.uploadURL;
            const fileName = file.name;

            const li = document.createElement('li');
            const a = document.createElement('a');
            a.href = url;
            a.target = '_blank';
            a.appendChild(document.createTextNode(fileName));
            li.appendChild(a);

            document.querySelector(elForUploadedFiles).appendChild(li);
        };

        import {
            Uppy,
            Dashboard,
            Webcam,
            XHRUpload
        } from 'https://releases.transloadit.com/uppy/v3.23.0/uppy.min.mjs';

        const loadingElement = document.getElementById('loading');
        const uplElement = document.getElementById('pc-uppy-1');
        const uplBtn = document.getElementById('uploadButton');
        let base64Image = null; // To store the converted base64 image
        // let base64Image = null;

        loadingElement.style.display = 'none';

        // Uppy setup
        const uppy = new Uppy({
                debug: true,
                autoProceed: true,
                restrictions: {
                    maxNumberOfFiles: 1,
                    allowedFileTypes: ['image/*']
                }
            })
            .use(Dashboard, {
                target: '#pc-uppy-1',
                inline: true,
                showProgressDetails: true,
                showRemoveButtonAfterComplete: true,
                proudlyDisplayPoweredByUppy: false,
                hideUploadButton: true,
                height: 350,
            })
            .use(Webcam, {
                target: Dashboard,
                modes: ['picture'],
                facingMode: 'environment'
            });

        // Convert file to Base64 on 'file-added'
        uppy.on('file-added', (file) => {
            const reader = new FileReader();
            reader.onload = () => {
                base64Image = reader.result.split(',')[1];
            };
            reader.readAsDataURL(file.data);
        });

        $('#uploadButton').on('click', function() {

            if (!base64Image) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Please select an image!',
                    customClass: {
                        title: 'custom-title',
                        content: 'custom-content' // Optional: to adjust content size as well
                    }
                });
                return;
            }
            submitToServer(base64Image);

        });

        // Submit the Base64 image to the server
        function submitToServer(base64Image) {
            loadingElement.style.display = 'block';
            uplElement.style.display = 'none';
            uplBtn.style.display = 'none';


            fetch('{{ env("API_EKYC_URL") }}/process-card/{{ $data }}', {
                    method: 'POST',
                    body: JSON.stringify({
                        image: base64Image
                    }),
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization' : 'API_KEY_1a2b3c4d5e-ali'
                    },
                })
                .then((response) => response.json())
                .then((data) => {
                    loadingElement.style.display = 'none';
                    uplElement.style.display = 'display';
                    const idno = '{{ $data }}';
                    if (data.success) {
                        const idnoserver = data.data.IDENTITY_NO;
                        const result = idnoserver.replace(/-/g, "");
                        if (result != idno) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error: Your IC No does not match with your registered IC NO.',
                                confirmButtonText: 'Okay',
                                customClass: {
                                    title: 'custom-title',
                                    content: 'custom-content'
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });

                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: `${data.message}\n\nCARD TYPE: ${data.data.CARD_TYPE}\nIDENTITY NO: ${data.data.IDENTITY_NO}`,
                                confirmButtonText: 'Next Step',
                                customClass: {
                                    title: 'custom-title',
                                    content: 'custom-content'
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    const currentUrl = window.location.href;

                                    let redirectUrl;
                                    redirectUrl = '/face-verification?id=:filename'.replace(
                                        ':filename',
                                        encodeURIComponent(data.filename)
                                    );

                                    window.location.href = redirectUrl;
                                }
                            });



                        }

                    } else {
                        uplElement.style.display = 'block';
                        uplBtn.style.display = 'block';

                        Swal.fire({
                            icon: 'error',
                            title: 'Verification failed: ' + data.message,
                            customClass: {
                                title: 'custom-title',
                                content: 'custom-content'
                            }
                        });
                    }
                })
                .catch((error) => {
                    loadingElement.style.display = 'none';
                    uplElement.style.display = 'block';
                    uplBtn.style.display = 'block';

                    Swal.fire({
                        icon: 'error',
                        title: 'Error sending image to server.',
                        customClass: {
                            title: 'custom-title',
                            content: 'custom-content'
                        }
                    });
                });
        }
    </script>

</body>
<!-- [Body] end -->

</html>
