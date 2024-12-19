<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="horizontal" data-nav-style="menu-click" data-menu-position="fixed" data-theme-mode="color" style="--primary-rgb: 17,28,67;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Job Listings</title>
    <meta name="Description" content="Job listing page">
    <meta name="Author" content="Your Company">
    <link rel="icon" href="../../assets/images/brand-logos/favicon.ico" type="image/x-icon">
    <link id="style" href="../../assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/styles.css" rel="stylesheet">
    <link href="../../assets/css/icons.css" rel="stylesheet">
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
        <div class="main-content landing-main px-0">
            <div class="container">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <h1 class="mb-4">Job Listings</h1>
                        <h6 id="total-jobs" class="mb-4"></h6>
                        
                        <form id="search-form" class="mb-4">
                            <div class="input-group">
                                <input type="text" id="search-input" class="form-control" placeholder="Search for jobs...">
                                <div class="input-wrapper">
                                    <input type="text" id="location-input" class="form-control" placeholder="Start typing location..." autocomplete="off">
                                    <ul id="location-suggestions" class="list-group mt-2" style="display: none;"></ul>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Search</button>
                        </form>

                        <div class="row" id="job-cards"></div>

                        <nav aria-label="Page navigation">
                            <ul class="pagination" id="pagination"></ul>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="text-center landing-main-footer py-3 bg-light">
                <span class="text-dark mb-0">All rights reserved Copyright © <span id="year">2024</span> xBug - Protected with Advanced Security</span>
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
                            <div class="col-md-4 mb-3">
                                <div class="card custom-card">
                                    <div class="card-header d-block">
                                        <div class="d-sm-flex d-block align-items-center">
                                            <div class="me-2">
                                                <span class="avatar bg-light avatar-md mb-1">
                                                    <img src="${job.logo_url}" alt="" width="60px" height="60px">
                                                </span>
                                            </div>
                                            <div class="flex-fill">
                                                <a href="javascript:void(0)">
                                                    <span class="fs-14 fw-semibold">${job.job_title}</span>
                                                </a>
                                                <span class="d-block text-success">${job.company_name}</span>
                                            </div>
                                            <div class="text-sm-center">
                                                <span class="d-sm-block">Posted ${job.posted_date}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <span class="mb-1 fw-semibold">Location: </span>
                                            <span class="text-muted mb-0">${job.location}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="mb-1 fw-semibold">Work Type: </span>
                                            <span class="text-muted mb-0">${job.work_type}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="mb-1 fw-semibold">Salary: </span>
                                            <span class="text-muted mb-0">${job.salary}</span>
                                        </div>
                                    </div>
                                    <div class="card-footer d-sm-flex d-block align-items-center justify-content-between">
                                        <div><span class="text-muted me-2">Status:</span><span class="badge bg-success-transparent">Available</span></div>
                                        <div class="mt-sm-0 mt-2">
                                            <a href="${job.job_link}" class="btn btn-primary-light" target="_blank">View Job</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
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
        }

        $(document).ready(function () {
            fetchJobs(1);

            $('#search-form').submit(function(event) {
                event.preventDefault();
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
