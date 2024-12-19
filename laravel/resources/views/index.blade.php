<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Job Listings</h1>
        <h6 id="total-jobs" class="mb-4"></h6>
        
        <form id="search-form" class="mb-4">
            <input type="text" id="search-input" class="form-control" placeholder="Search for jobs..." />

            <div class="input-wrapper mb-4 mt-3">
                <input type="text" id="location-input" class="form-control" placeholder="Start typing location..." autocomplete="off">
                <ul id="location-suggestions" class="list-group mt-2" style="display: none;"></ul>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Search</button>
        </form>
        
        <div class="row" id="job-cards">
        </div>
    
        <nav aria-label="Page navigation">
            <ul class="pagination" id="pagination">
            </ul>
        </nav>
    </div>

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
                            <div class="card">
                                <div class="card-body">
                                    <img src="${job.logo_url}" width="60px" height="60px" />
                                    <h5 class="card-title">${job.job_title}</h5>
                                    <p class="card-text"> Company: ${job.company_name}</p>
                                    <p class="card-text">Location: ${job.location}</p>
                                    <p class="card-text">Salary: ${job.salary}</p>
                                    <p class="card-text">Work Type: ${job.work_type}</p>
                                    <p class="card-text">Job Type: ${job.classifications}</p>
                                    <p class="card-text">Posted: ${job.posted_date}</p>
                                    <p class="card-text">Job Description: ${job.job_description}</p>
                                    <a href="${job.job_link}" class="btn btn-primary" target="_blank">View Job</a>
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
                <a class="page-link" href="javascript:void(0);" onclick="fetchJobs(${endPage+1})">Next</a>
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
            if (searchQuery) {
                fetchJobs(1);
            } else {
                fetchJobs(1); 
            }
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
                    },
                    error: function() {
                        $('#location-suggestions').hide();
                    }
                });
            } else {
                $('#location-suggestions').hide();
            }
        });

        $(document).on('click', '.suggestion-item', function() {
            let selectedLocation = $(this).data('location');
            $('#location-input').val(selectedLocation);
            $('#location-suggestions').hide();
        });
    });
    </script>
</body>
</html>
