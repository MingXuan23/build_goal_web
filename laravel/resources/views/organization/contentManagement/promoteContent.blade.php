@extends('organization.layouts.main')
@section('container')

<!-- Start::app-content -->
<div class="main-content app-content">
   <div class="container">
      <!-- Page Header -->
      <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
         <h1 class="page-title fw-semibold fs-18 mb-0">Promote Your Content Here</h1>
         <div class="ms-md-1 ms-0">
            <nav>
               <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="#">Pages</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Promote Content</li>
               </ol>
            </nav>
         </div>
      </div>
      <!-- Page Header Close -->
      <!-- Start::row-1 -->
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">Increase Your Content Views</h4>
               </div>
               <div class="card-body">
                  <!-- Promotion Form -->
                  <form action="#" method="POST">
                     @csrf
                     <!-- Content Details -->
                     <div class="mb-3">
    <label for="content_id" class="form-label">Content ID</label>
    <input type="text" class="form-control" id="content_id" name="content_id" value="{{ $content->id }}" readonly>
</div>

<div class="mb-3">
    <label for="content_name" class="form-label">Content Name</label>
    <input type="text" class="form-control" id="content_name" name="content_name" value="{{ $content->name }}" readonly>
</div>

                     <!-- Package Selection -->
                     <div class="mb-3">
                        <label for="package" class="form-label">Choose Package </label>
                        <select class="form-select" id="package" name="Package" required>
                           <option value="" disabled selected>Choose Package  (package will be extracted from the database)</option>
                           <option value="1">Package A (Target Users: 50 - 100, Price: RM 100)</option>
                           <option value="2">Package B (Target Users: 101 - 200, Price: RM 200)</option>
                           <option value="3">Package C (Target Users: 201 - 300, Price: RM 300)</option>
                        </select>
                     </div>
      
                    
                     <!-- State Selection -->
                     <!-- <style>
                        .tags-input {
                        display: flex;
                        flex-wrap: wrap;
                        min-height: 48px;
                        padding: 0 8px;
                        border: 1px solid #ddd;
                        border-radius: 6px;
                        align-items: center;
                        gap: 8px;
                        background: white;
                        }
                        .tags-input:focus-within {
                        border-color: #4a90e2;
                        box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
                        }
                        .tag {
                        display: flex;
                        align-items: center;
                        padding: 4px 8px;
                        background: #f0f0f0;
                        border-radius: 4px;
                        font-size: 14px;
                        gap: 4px;
                        }
                        .tag .remove {
                        cursor: pointer;
                        color: #666;
                        font-weight: bold;
                        padding: 0 4px;
                        }
                        .tag .remove:hover {
                        color: #ff4444;
                        }
                        .tags-input input {
                        border: none;
                        outline: none;
                        padding: 8px 0;
                        flex: 1;
                        min-width: 120px;
                        font-size: 14px;
                        }
                        .suggestions {
                        position: absolute;
                        top: 100%;
                        left: 0;
                        right: 0;
                        background: white;
                        border: 1px solid #ddd;
                        border-radius: 4px;
                        margin-top: 4px;
                        max-height: 200px;
                        
                        overflow-y: auto;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                        z-index: 1000;
                        }
                        .suggestion-item {
                        padding: 8px 16px;
                        cursor: pointer;
                        }
                        .suggestion-item:hover {
                        background: #f5f5f5;
                        }
                        .container {
                        max-width: 600px;
                        margin: 40px auto;
                        padding: 20px;
                        }
                        .input-wrapper {
                        position: relative;
                        }
                     </style>
                     <div class="input-wrapper">
                        <div class="tags-input" id="tagsInput">
                           <input type="text" placeholder="Select which state(s) you want to promote">
                        </div>
                     </div>
                     <script>
                        class TagsInput {
                           constructor(element, availableItems) {
                              this.container = element;
                              this.tags = [];
                              this.suggestions = [];
                              this.input = this.container.querySelector('input');
                              this.suggestionsPanel = null;
                              this.availableItems = availableItems;
                        
                              this.init();
                           }
                        
                           init() {
                              this.input.addEventListener('input', () => this.handleInput());
                              this.input.addEventListener('keydown', (e) => this.handleKeydown(e));
                              document.addEventListener('click', (e) => this.handleClickOutside(e));
                           }
                        
                           handleInput() {
                              const value = this.input.value.trim().toLowerCase();
                        
                              if (value) {
                                 this.suggestions = this.availableItems
                                    .filter(item => !this.tags.includes(item))
                                    .filter(item => item.toLowerCase().includes(value));
                                 this.showSuggestions();
                              } else {
                                 this.hideSuggestions();
                              }
                           }
                        
                           showSuggestions() {
                              if (this.suggestionsPanel) {
                                 this.suggestionsPanel.remove();
                              }
                        
                              if (this.suggestions.length === 0) {
                                 return;
                              }
                        
                              this.suggestionsPanel = document.createElement('div');
                              this.suggestionsPanel.className = 'suggestions';
                        
                              this.suggestions.forEach(suggestion => {
                                 const item = document.createElement('div');
                                 item.className = 'suggestion-item';
                                 item.textContent = suggestion;
                                 item.addEventListener('click', () => this.addTag(suggestion));
                                 this.suggestionsPanel.appendChild(item);
                              });
                        
                              this.container.parentNode.appendChild(this.suggestionsPanel);
                           }
                        
                           hideSuggestions() {
                              if (this.suggestionsPanel) {
                                 this.suggestionsPanel.remove();
                                 this.suggestionsPanel = null;
                              }
                           }
                        
                           addTag(text) {
                              if (text && !this.tags.includes(text)) {
                                 const tag = document.createElement('span');
                                 tag.className = 'tag';
                                 tag.innerHTML = `
                                    ${text}
                                    <span class="remove">×</span>
                                 `;
                        
                                 tag.querySelector('.remove').addEventListener('click', () => this.removeTag(tag, text));
                        
                                 this.container.insertBefore(tag, this.input);
                                 this.tags.push(text);
                                 this.input.value = '';
                                 this.hideSuggestions();
                        
                                 // Log the current selected items
                                 console.log('Selected items:', this.tags);
                              }
                           }
                        
                           removeTag(tagElement, text) {
                              tagElement.remove();
                              this.tags = this.tags.filter(tag => tag !== text);
                        
                              // Log the current selected items
                              console.log('Selected items:', this.tags);
                           }
                        
                           handleKeydown(e) {
                              if (e.key === 'Enter' && this.suggestions.length > 0) {
                                 e.preventDefault();
                                 this.addTag(this.suggestions[0]);
                              }
                           }
                        
                           handleClickOutside(e) {
                              if (!this.container.contains(e.target) && !this.suggestionsPanel?.contains(e.target)) {
                                 this.hideSuggestions();
                              }
                           }
                        }
                        
                        // Initialize the tags input with server-provided states
                        document.addEventListener('DOMContentLoaded', () => {
                           
                           const tagsInput = new TagsInput(document.getElementById('tagsInput'), availableStates);
                        });
                     </script> -->
                     <!-- Submit Button -->
                     <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary me-2">Pay</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <!--End::row-1 -->
   </div>
</div>
@endsection