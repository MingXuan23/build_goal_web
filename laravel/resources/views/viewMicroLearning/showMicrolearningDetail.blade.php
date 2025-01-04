@extends('mainLayout')
@section('content')
    <div class="main-content landing-main px-0">
        <div class="landing-banner" id="home">
            <section class="section pb-0">
                <div class="container main-banner-container">
                    <div class="row justify-content-center text-center">
                        <div class="col-xxl-7 col-xl-7 col-lg-8">
                            <div class="">
                                <h6 class="landing-banner-heading mb-3"><span class="text-secondary fw-bold">14+
                                    </span>Content for Course and Tranning</h6>
                                <p class="fs-18 mb-5 op-8 fw-normal text-fixed-white">Register &amp; get free access to
                                    create your content and <br>submit your content with few easy steps.</p>
                                <div class="mb-3 custom-form-group">
                                    <input type="text" class="form-control form-control-lg shadow-sm"
                                        placeholder="your keyword...." aria-label="Recipient's username">
                                    <div class="custom-form-btn bg-transparent">
                                        <button class="btn btn-primary border-0" type="button"><i
                                                class="bi bi-search me-sm-2"></i> <span>Search</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-8 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="row g-3 mt-4">
                        @foreach ($contents as $content)
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card custom-card" style="width: 100%;">
                                    <!-- Display image or fallback -->
                                    @if ($content->image)
                                        <!-- <img src="{{ asset($content->image) }}" class="card-img-top" alt="{{ $content->name }}" style="height: 180px; object-fit: cover;"> -->
                                        <img src="{{ asset('asset1/images/' . basename($content->image)) }}"
                                            class="card-img-top" alt="{{ $content->name }}"
                                            onerror="console.log('Image failed to load:', this.src);"
                                            style="height: 180px; object-fit: cover;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center card-img-top bg-primary text-white"
                                            style="height: 180px; font-size: 48px; font-weight: bold;">
                                            {{ strtoupper(substr($content->name, 0, 1)) }}
                                        </div>
                                    @endif

                                    <div class="card-body">
                                        <h6 class="card-title fw-semibold">{{ $content->name }}</h6>
                                        <p class="card-text text-muted">{{ $content->content_type_name }}</p>
                                        <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#contentModal"
                                            onclick="showContentPreview('{{ $content->content }}', '{{ $content->name }}', '{{ $content->desc }}')">
                                            Read More
                                        </a>

                                    </div>
                                    <div class="card-footer">
                                        <span class="card-text">Last updated
                                            {{ \Carbon\Carbon::parse($content->created_at)->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


        <!-- <div class="modal fade" id="viewContent" tabindex="-1"
              aria-labelledby="viewContent" data-bs-keyboard="false"
              aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable modal-lg">
                 <div class="modal-content">
                    <div class="modal-header">
                       <h6 class="modal-title" id="staticBackdropLabel1">How to be a backend Software Engineer
                       </h6>
                       <button type="button" class="btn-close" data-bs-dismiss="modal"
                          aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                       <iframe src="https://en.wikipedia.org/wiki/Abdul_Rashid_Hassan" width="100%" height="500px" frameborder="0" title="About Page"></iframe>

                       <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                          Libero
                          ipsum quasi, error quibusdam debitis maiores hic eum? Vitae
                          nisi
                          ipsa maiores fugiat deleniti quis reiciendis veritatis.
                       </p>
                       <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ea
                          voluptatibus, ipsam quo est rerum modi quos expedita facere,
                          ex
                          tempore fuga similique ipsa blanditiis et accusamus
                          temporibus
                          commodi voluptas! Nobis veniam illo architecto expedita quam
                          ratione quaerat omnis. In, recusandae eos! Pariatur,
                          deleniti
                          quis ad nemo ipsam officia temporibus, doloribus fuga
                          asperiores
                          ratione distinctio velit alias hic modi praesentium aperiam
                          officiis eaque, accusamus aut. Accusantium assumenda,
                          commodi
                          nulla provident asperiores fugit inventore iste amet aut
                          placeat
                          consequatur reprehenderit. Ratione tenetur eligendi, quis
                          aperiam dolores magni iusto distinctio voluptatibus minus a
                          unde
                          at! Consequatur voluptatum in eaque obcaecati, impedit
                          accusantium ea soluta, excepturi, quasi quia commodi
                          blanditiis?
                          Qui blanditiis iusto corrupti necessitatibus dolorem fugiat
                          consequuntur quod quo veniam? Labore dignissimos reiciendis
                          accusamus recusandae est consequuntur iure.
                       </p>
                       <p>Lorem ipsum dolor sit amet.</p>
                    </div>
                    <div class="modal-footer">
                       <button type="button" class="btn btn-danger"
                          data-bs-dismiss="modal">Close</button>
                    </div>
                 </div>
              </div>
           </div> -->

        <!-- Modal for Read More -->
        <!-- Modal for Read More -->
        <div class="modal fade" id="contentModal" tabindex="-1" aria-labelledby="contentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="contentModalLabel">Content Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalContent">
                        <!-- Content preview will be dynamically inserted here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- End:: Section-11 -->
        <div class="text-center landing-main-footer py-3 bg-light">
            <span class="text-dark  mb-0">All
                rights
                reserved Copyright © <span id="year">2024</span> xBug - Protected with Advanced Security
            </span>
        </div>
    </div>
    <script>
        function showContentPreview(formattedContent, title, description) {
            // Update the modal title
            document.getElementById('contentModalLabel').innerText = title;

            // Build the preview content
            let contentHtml = `
            <h1>${title}</h1>
            <p><em>${description}</em></p>
            <hr>
         `;

            const contentSections = formattedContent.split('\n\n');
            contentSections.forEach((section, index) => {
                const headerMatch = section.match(/\*\*\*(.*?)\*\*\*/); // Match header in ***
                if (headerMatch) {
                    const header = headerMatch[1]; // Extract header
                    const body = section.replace(/\*\*\*(.*?)\*\*\*/, '').trim(); // Remove header and extract body

                    // Append formatted section to preview
                    contentHtml += `
                  <div class="preview-section">
                     <h2>Step ${index + 1}: ${header}</h2>
                     <p>${body}</p>
                  </div>
               `;
                }
            });

            // Insert content into modal body
            document.getElementById('modalContent').innerHTML = contentHtml;
        }
    </script>
@endsection
