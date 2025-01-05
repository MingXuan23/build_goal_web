@extends('mainLayout')
@section('content')
    <div class="main-content landing-main px-0">
        <div class="landing-banner" id="home">
            <section class="section pb-0 bg-light">
                <div class="container" style="padding: 11px">
                    <div class="row justify-content-center text-center">
                        {{-- <div class="col-xxl-7 col-xl-7 col-lg-8">
                            <div class="">
                                <h6 class="landing-banner-heading mb-3"><span class="text-secondary fw-bold">+ </span>Content
                                    for Course and Tranning</h6>
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
                        </div> --}}
                    </div>
                </div>
            </section>
        </div>
        <div class="container d-flex justify-content-center mt-4 ">
            <div class="card custom-card bg-white-transparent shadow-xl"
                style="width: 100%; max-width: 600px; border: 2px solidrgb(0, 0, 0); border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"">
                <!-- Card Header -->
                <div class="card-header justify-content-between m-0">
                    <div class="card-title text-center">
                        {{ $contents->name }}
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <!-- Display image or fallback -->
                    @if ($contents->image)
                        <img src="{{ asset('storage/' . $contents->image) }}" class="card-img-top"
                            alt="{{ $contents->name }}" onerror="console.log('Image failed to load:', this.src);"
                            style="height: 180px; object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center card-img-top bg-primary text-white mb-3"
                            style="height: 200px; font-size: 48px; font-weight: bold;">
                            {{ strtoupper(substr($contents->name, 0, 1)) }}
                        </div>
                    @endif

                    <!-- Content Information -->
                    <p class="text-muted mb-2 mt-2">{{ $contents->content_type_name }}</p>
                    {{-- <p class="text-muted"><em id="descriptionPreview">{{ Str::limit($contents->desc, 100, '...') }}</em></p> --}}
                    <p class="text-muted"><em id="descriptionPreview">{{ $contents->desc }}</em></p>

                    <!-- Read More Button -->
                    <div id="formattedContent" class="content-preview mt-3"></div>

                    <div class="row">
                        <div class="col-md-12 text-end">
                            <a href="{{ url('/view-content/' . $microLearningSlug) }}" class="btn btn-primary">Back</a>
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="card-footer text-center">
                    <span class="text-muted">Last updated
                        {{ \Carbon\Carbon::parse($contents->created_at)->diffForHumans() }}</span>
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
        <div class="text-center landing-main-footer py-3 bg-light mt-4">
            <span class="text-dark  mb-0">All
                rights
                reserved Copyright © <span id="year">2024</span> xBug - Protected with Advanced Security
            </span>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Fetch the content
            const formattedContent =
                `{{ addslashes($contents->content) }}`; // Replace this with the dynamic content if needed.

            // Function to format the content
            function formatContent(content) {
                let formattedHtml = "";
                const sections = content.split("\n\n"); // Assuming sections are separated by double new lines
                sections.forEach((section, index) => {
                    const headerMatch = section.match(/\*\*\*(.*?)\*\*\*/); // Match header in ***
                    if (headerMatch) {
                        const header = headerMatch[1]; // Extract header
                        const body = section.replace(/\*\*\*(.*?)\*\*\*/, '')
                            .trim(); // Remove header and extract body

                        // Append formatted section to preview
                        formattedHtml += `
                       <div class="preview-section">
                           <h6 class="fw-bold">Step ${index + 1}: ${header}</h6>
                           <p>${body}</p>
                       </div>
                   `;
                    } else {
                        // If no header is found, treat the entire section as normal text
                        formattedHtml += `<p>${section}</p>`;
                    }
                });
                return formattedHtml;
            }

            // Display the formatted content
            const contentHtml = formatContent(formattedContent);
            document.getElementById("formattedContent").innerHTML = contentHtml;
        });
    </script>
@endsection
