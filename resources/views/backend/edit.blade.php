@extends('backend.layouts.app')
@section('content-page')
    
<section class="content">
<div class="container-fluid">
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                <a href="{{url('admin/backend/list')}}" class="btn btn-primary btn-sm mb-3 float-end"><i data-feather="plus"></i><strong>Back</strong></a>

                    <h3 class="fw-bold mb-3">Edit Category</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 col-lg-12">
                        <form action="{{ route('category.update', $category->cat_id) }}" method="POST" id="categoryForm" name="categoryForm">
                        {{-- <form method="POST" id="categoryForm" name="categoryForm"> --}}
                            @csrf
                            @method('PUT')
                      {{-- <input type="hidden" value="{{ $category->cat_id }}" name="cat_id" id="category"> --}}
                        <div class="form-group">
                          <label for="name">Name</label>
                          <input
                            type="text"
                            class="form-control"
                            id="name"
                            value="{{ $category->name }}"
                            name="name"
                            placeholder="Name"
                          />
                           <p></p>
                        </div>
                        <div class="form-group">
                          <label for="slug">Slug</label>
                          <input
                            type="text"
                            readonly
                            class="form-control"
                            id="slug"
                            value="{{ $category->slug }}"
                            name="slug"
                            placeholder="Slug"
                          />
                          <p></p>
                        </div>

                        <div class="col-md-6">
                          <div class="mb-3">
                            <input type="hidden" id="image_id" name="image_id" value="">
                            {{-- <input type="hidden" id="image_id" name="image_id" value=""> --}}
                            <label for="image">Image</label>
                            <div id="image" name="image" class="dropzone dz-clickable">
                              <div class="dz-message needsclick">
                                <br>Drop files here or click to upload.<br><br><br>
                              </div>
                            </div>
                          </div>
                          @if(!empty($category->image))
                          <div>
                            <img width="250" src="{{ asset('/uploads/category/'.$category->image)}}" alt="">
                          </div>
                          @endif
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                             <select name="status" id="status" class="form-control">
                                <option {{ ($category->status == 1) ? 'selected' : '' }} value="1">Active</option>
                                <option {{ ($category->status == 0) ? 'selected' : '' }} value="0">Block</option>
                             </select>
                          </div>
                        
                          <div class="form-group">
                            <label for="status"><strong>Show on Home</strong></label>
                             <select name="showHome" id="showHome" class="form-control">
                                <option {{ ($category->showHome == 'Yes') ? 'selected' : '' }} value="Yes">Yes</option>
                                <option {{ ($category->showHome == 'No') ? 'selected' : '' }} value="No">No</option>
                             </select>
                          </div>

                  <div class="card-action">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ url('backend/index') }}" class="btn btn-danger">Cancel</a>
                  </div>
                   </form>
                
                </div>
                </div>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
</section>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('backend/assets/js/plugin/dropzone/dropzone.min.js')}}"></script>
        <script>
            // $("#categoryForm").submit(function(event) {
            //     // event.preventDefault();

            //     var element = $(this);
            //     var url = '{{ route("category.update", "ID") }}';
            //     var newUrl = url.replace("ID", id);

            //      $("button[type=submit]").prop('disabled',true);
            //     $.ajax({
            //         url: newUrl,
            //         type: 'put',
            //         data: element.serializeArray(),
            //         dataType: 'json',
            //         success: function(response){
            //      $("button[type=submit]").prop('disabled',false);


            //           if(response["status"] == true) {

            //             window.location.href="{{ route('category.index') }}";

            //             $("#name").removeClass('is-invalid')
            //                 .siblings('p')
            //                 .removeClass('invalid-feedback').html("");

            //             $("#slug").removeClass('is-invalid')
            //                 .siblings('p')
            //                 .removeClass('invalid-feedback').html("");

            //            } else{

            //               var errors = response['errors'];
            //             if(errors['name']){
            //                 $("#name").addClass('is-invalid')
            //                 .siblings('p')
            //                 .addClass('invalid-feedback').html(errors['name']);
            //             }else{
            //                 $("#name").removeClass('is-invalid')
            //                 .siblings('p')
            //                 .removeClass('invalid-feedback').html("");
            //             }

            //             if(errors['slug']){
            //                 $("#slug").addClass('is-invalid')
            //                 .siblings('p')
            //                 .addClass('invalid-feedback').html(errors['slug']);
            //             }else{
            //                 $("#slug").removeClass('is-invalid')
            //                 .siblings('p')
            //                 .removeClass('invalid-feedback').html("");
            //             }

            //          }//, error: function(jqXHR, exception){
            //         //      console.log("Somthing Went Wrong");

            //         //     }
            //           }

                        
            //     });
            // });

            $("#name").change(function(){
              element = $(this);
               $("button[type=submit]").prop('disabled',true);
              $.ajax({
                    url: '{{ route("admin/getSlug") }}',
                    type: 'get',
                    data: {title: element.val()},
                    dataType: 'json',
                    success: function(response){
                 $("button[type=submit]").prop('disabled',false);
                      console.log(response);
                      if(response["status"] == true) {
                        $("#slug").val(response["slug"]);
                      }

                    },
                    error: function(xhr, status, error) {
            console.error('AJAX request failed: ' + error);
        }

                  });
            });

            Dropzone.autoDiscover = false;
            const dropzone = $("#image").dropzone({
              init: function() {
                this.on('addedfile', function(file) {
                  if (this.files.length > 1) {
                    this.removeFile(this.files[0]);
                  }
                });
              },
              url: "{{ route('temp-images.create') }}",
              maxFiles: 1,
              paramName: 'image',
              addRemoveLinks: true,
              acceptedFiles: "image/jpeg,image/png,image/gif",
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }, success: function(file, response){
                $("#image_id").val(response.image_id);
              }
            });

        </script>
@endsection


        