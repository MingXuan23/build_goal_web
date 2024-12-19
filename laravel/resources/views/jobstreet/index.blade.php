<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="horizontal" data-nav-style="menu-click" data-menu-position="fixed"
    data-theme-mode="color" style="--primary-rgb: 17,28,67;">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> xBug </title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <link rel="icon" href="../../assets/images/brand-logos/favicon.ico" type="image/x-icon">
    <link id="style" href="../../assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/styles.css" rel="stylesheet">
    <link href="../../assets/css/icons.css" rel="stylesheet">
    <link href="../../assets/libs/node-waves/waves.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/libs/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="../../assets/libs/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="../../assets/libs/@simonwep/pickr/themes/nano.min.css">
    <link rel="stylesheet" href="../../assets/libs/choices.js/public/../../assets/styles/choices.min.css">
    <script>
        if (localStorage.ynexlandingdarktheme) {
            document.querySelector("html").setAttribute("data-theme-mode", "dark")
        }
        if (localStorage.ynexlandingrtl) {
            document.querySelector("html").setAttribute("dir", "rtl")
            document.querySelector("#style")?.setAttribute("href", "../../assets/libs/bootstrap/css/bootstrap.rtl.min.css");
        }
    </script>


</head>

<body class="landing-body">


    <div class="landing-page-wrapper">
        <header class="app-header">
            <div class="main-header-container container-fluid">
                <div class="header-content-left">
                    <div class="header-element">
                        <div class="horizontal-logo d-flex justify-content-center align-items-center">
                            <a href="#" class="header-logo">
                               <span class="fw-bold text-primary">xBug</span>
                            </a>
                        </div>
                    </div>
                    <div class="header-element">
                        <a href="javascript:void(0);" class="sidemenu-toggle header-link" data-bs-toggle="sidebar">
                            <span class="open-toggle">
                                <i class="ri-menu-3-line fs-20"></i>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="header-content-right">
                    <div class="header-element align-items-center">
                        <div class="btn-list d-lg-none d-block">
                            <a href="/login" class="btn btn-primary">
                                Sign In
                            </a>                           
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <aside class="app-sidebar sticky" id="sidebar">

            <div class="container-xl">
                <div class="main-sidebar">
                    <nav class="main-menu-container nav nav-pills sub-open">
                        <div class="landing-logo-container">
                            <div class="horizontal-logo">
                                <a href="index.html" class="header-logo">
                                    <h4 class="text-primary fw-bold">xBug</h4>
                                </a>
                            </div>
                        </div>
                        <div class="slide-left" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                                width="24" height="24" viewBox="0 0 24 24">
                                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                            </svg></div>
                        <ul class="main-menu">
                            <li class="slide">
                                <a class="side-menu__item" href="/#home">
                                    <span class="side-menu__label">Home</span>
                                </a>
                            </li>
                            <li class="slide">
                                <a href="/#about" class="side-menu__item">
                                    <span class="side-menu__label">About</span>
                                </a>
                            </li>                            
                            <li class="slide">
                                <a href="/view-microlearning" class="side-menu__item">
                                    <span class="side-menu__label">Content</span>
                                </a>
                            </li>
                            <li class="slide">
                                <a href="/jobstreet" class="side-menu__item">
                                    <span class="side-menu__label">Jobstreet</span>
                                </a>
                            </li>
                        </ul>
                        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                                width="24" height="24" viewBox="0 0 24 24">
                                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z">
                                </path>
                            </svg></div>
                        <div class="d-lg-flex d-none">
                            <div class="btn-list d-lg-flex d-none mt-lg-2 mt-xl-0 mt-0">

                                <a href="/login" class="btn btn-wave btn-primary">
                                    Sign In
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </aside>
        <div class="main-content landing-main px-0">
            <div class="landing-banner" id="home">
                <section class="section pb-0">
                    <div class="container main-banner-container">
                        <div class="row justify-content-center text-center">
                            <div class="col-xxl-7 col-xl-7 col-lg-8">
                                <div class="">
                                    <h6 class="landing-banner-heading mb-3"><span class="text-secondary fw-bold"></span>Job In Jobstreet</h6>
                                    <p class="fs-18 mb-5 op-8 fw-normal text-fixed-white">Register &amp; get free access to create your content and <br>submit your content with few easy steps.</p>
                                    <form id="search-form">
                                        <div class="mb-3 custom-form-group">
                                            <input type="text" class="form-control form-control-lg shadow-sm" placeholder="your keyword...." 
                                                aria-label="Recipient's username" id="search-input">
                                            <div class="custom-form-btn bg-transparent">
                                                <button type="submit" class="btn btn-primary border-0" type="button"><i class="bi bi-search me-sm-2"></i> <span>Search</span></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> 
            </div>

            <div class="container">
                <div id="loading-btn">
                    <button class="btn btn-success btn-loader mx-auto mt-4">
                        <span class="me-2">Please wait, we need to connect to Jobstreet Server....</span>
                        <span class="loading"><i class="ri-loader-4-line fs-16 btn-loader"></i></span>
                    </button>
                </div>
                <div class="row mt-3" style="display: none" id="job-list">
                    <div class="col-md-12">
                        <span id="total-jobs"  class="text-start fw-bold text-primary text-muted"></span>
                        <nav aria-label="Page navigation">
                            <ul class="pagination d-flex justify-content-end text-sm" id="pagination"></ul>
                        </nav>

                        <div class="row" id="job-cards"></div>

                        <nav aria-label="Page navigation">
                            <ul class="pagination d-flex justify-content-end" id="pagination1"></ul>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="text-center landing-main-footer py-3 bg-light" style="display: none" id="footer-section">
                <span class="text-dark  mb-0">All
                    rights
                    reserved Copyright © <span id="year">2024</span> xBug - Protected with Advanced Security
                </span>
            </div>
        </div>
    </div>

    <div class="modal fade" id="jobDetailModal" tabindex="-1" aria-labelledby="jobDetailModalLabel" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="jobDetailModalLabel">Job Title</h6>
                    <span class="text-muted ms-5" id="postDate">posted_date</span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="avatar bg-light avatar-xxl mb-1">
                        <img alt="Logo" id="logoUrl">
                    </span>
                    <p><strong>Company Name:</strong> <span id="companyName">Company Name</span></p>
                    <p><strong>Location:</strong> <span id="jobLocation">Location</span></p>
                    <p><strong>Classifications:</strong> <span id="jobClassifications">Classifications</span></p>
                    <p><strong>Work Type:</strong> <span id="jobWorkType">Work Type</span></p>
                    <p><strong>Salary:</strong> <span id="jobSalary">Salary</span></p>
                    <h6><strong>Job Description:</strong></h6>
                    <p id="jobDescription">Job description will appear here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <a id="viewJobDetailBtn" type="button" class="btn btn-primary" target="_blank">View Detail</a>
                </div>
            </div>
        </div>
    </div>



    <div class="scrollToTop">
        <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
    </div>
    <div id="responsive-overlay"></div>
    <script src="../../assets/libs/@popperjs/core/umd/popper.min.js"></script>
    <script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/libs/@simonwep/pickr/pickr.es5.min.js"></script>
    <script src="../../assets/libs/choices.js/public/../../assets/scripts/choices.min.js"></script>
    <script src="../../assets/libs/swiper/swiper-bundle.min.js"></script>
    <script src="../../assets/js/defaultmenu.min.js"></script>
    <script src="../../assets/js/landing.js"></script>
    <script src="../../assets/libs/node-waves/waves.min.js"></script>
    <script src="../../assets/js/sticky.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>

    <script>
        let searchQuery = '';
        let addressQuery = '';

        function fetchJobs(page) {
            $('#loading-btn').show();
            $('#job-list').hide();
            $('#footer-section').hide();
            let url = '/fetch-jobs?page=' + page;
            if (searchQuery) {
                url += '&query=' + searchQuery;
            }
            if (addressQuery) {
                url += '&address=' + encodeURIComponent(addressQuery);
            }

            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    let cards = '';
                    $('#total-jobs').text('Total Jobs: ' + data.total_jobs);
                    data.jobs.forEach(job => {
                        cards += `
                            <div class="col-md-6 mb-3">
                                <div class="card custom-card bg-light">
                                    <div class="card-header d-block">
                                        <div class="d-sm-flex d-block align-items-center">
                                            <div class="me-2">
                                                ${job.logo_url && job.logo_url !== 'Logo not found.' ? `
                                                    <span class="avatar bg-light avatar-md mb-1">
                                                        <img src="${job.logo_url}" alt="Logo" width="110px" height="110px">
                                                    </span>
                                                ` : ''}
                                            </div>
                                            <div class="flex-fill">
                                                <a href="javascript:void(0)">
                                                    <span class="fs-14 fw-semibold">${job.job_title}</span>
                                                </a>
                                                <span class="d-block text-success">${job.company_name}</span>
                                            </div>
                                            <div class="text-sm-center">
                                                <span class="d-sm-block">${job.posted_date}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <span class="mb-1 fw-semibold">Location : </span>
                                            <span class="text-muted mb-0"> ${ job.location}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="mb-1 fw-semibold">Work Type : </span>
                                            <span class="text-muted mb-0"> ${ job.work_type}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="mb-1 fw-semibold">Salary : </span>
                                            <span class="text-muted mb-0"> ${ job.salary}</span>
                                        </div>
                                    </div>
                                    <div class="card-footer d-sm-flex d-block align-items-center justify-content-between">
                                        <div><span class="text-muted me-2">Status:</span><span class="badge bg-success-transparent">Available</span></div>
                                        <div class="mt-sm-0 mt-2">
                                            <!-- View Job Button, with data attributes to pass the job details to the modal -->
                                            <button class="btn btn-primary-light" data-bs-toggle="modal" data-bs-target="#jobDetailModal" onclick="showJobDetail('${job.job_title}', '${job.company_name}', '${job.location}', '${job.classifications}', '${job.work_type}', '${job.salary}', '${job.job_description}', '${job.job_link}','${job.logo_url}','${job.posted_date}')">View Job</button>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    $('#loading-btn').hide();
                    $('#job-list').show();
                    $('#footer-section').show();
                    $('#job-cards').html(cards);
                    updatePagination(data.current_page, data.total_pages);
                },
                error: function () {
                    $('#job-cards').html('<p class="text-danger">Failed to load jobs.</p>');
                }
            });
        }


        function updatePagination(currentPage, totalPages) {
            let pagination = '';
            const pageLimit = 5;
            const startPage = Math.floor((currentPage - 1) / pageLimit) * pageLimit + 1;
            const endPage = Math.min(startPage + pageLimit - 1, totalPages);

            pagination += `
                <li class="page-item ${currentPage <= 1 ? 'disabled' : ''}">
                    <a class="page-link" href="javascript:void(0);" onclick="fetchJobs(${currentPage - 1})">Previous</a>
                </li>
            `;
            for (let i = startPage; i <= endPage; i++) {
                pagination += `
                    <li class="page-item ${currentPage === i ? 'active' : ''}">
                        <a class="page-link" href="javascript:void(0);" onclick="fetchJobs(${i})">${i}</a>
                    </li>
                `;
            }
            pagination += `
                <li class="page-item ${currentPage >= totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="javascript:void(0);" onclick="fetchJobs(${endPage + 1})">Next</a>
                </li>
            `;
            $('#pagination').html(pagination);
            $('#pagination1').html(pagination);
        }


        function showJobDetail(jobTitle, companyName, location, classifications, workType, salary, description, jobLink,logo_url,post_date) 
        {
            $('#jobDetailModalLabel').text(jobTitle);
            $('#companyName').text(companyName);
            $('#jobLocation').text(location);
            $('#jobClassifications').text(classifications);
            $('#jobWorkType').text(workType);
            $('#jobSalary').text(salary);
            $('#jobDescription').text(description);
            $('#postDate').text(post_date);

            $('#logoUrl').attr('src', logo_url);
            $('#viewJobDetailBtn').attr('href', jobLink);
        }

        $(document).ready(function () {
            fetchJobs(1);

            $('#search-form').submit(function(event) {
                event.preventDefault();
                $('#job-list').hide();
                $('#footer-section').hide();
                $('#loading-btn').show();
                searchQuery = $('#search-input').val().trim().replace(/\s+/g, '-').toLowerCase();
                addressQuery = $('#location-input').val();
                fetchJobs(1);
            });

            $('#location-input').on('input', function() {
                let query = $(this).val().trim();
                if (query.length > 1) {
                    $.ajax({
                        url: '/get-suggested-location?query=' + query,
                        type: 'GET',
                        success: function(data) {
                            let suggestions = data.suggestions;
                            let suggestionsHtml = '';
                            suggestions.forEach(function(suggestion) {
                                suggestionsHtml += `
                                    <li class="list-group-item suggestion-item" data-location="${suggestion.text}">
                                        ${suggestion.text}
                                    </li>
                                `;
                            });
                            $('#location-suggestions').html(suggestionsHtml).show();
                        }
                    });
                } else {
                    $('#location-suggestions').hide();
                }
            });

            $(document).on('click', '.suggestion-item', function() {
                let location = $(this).data('location');
                $('#location-input').val(location);
                $('#location-suggestions').hide();
            });
        });
    </script>

</body>

</html>
