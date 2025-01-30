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
                <a href="{{url('admin/backend/sub_table')}}" class="btn btn-primary btn-sm mb-3 float-end"><i data-feather="plus"></i><strong>Back</strong></a>

                    <h3 class="fw-bold mb-3">Add Sub Category</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 col-lg-12">
                        <form action="{{route('sub_category.store')}}" method="POST">
                            @csrf
                            <div class="form-group">
                              <label for="category"><strong>Category</strong></label>
                              <select name="cat_id" id="cat_id" class="form-control">
                                <option value="">Select A Category</option>
                                @foreach ($category as $item)
                                <option value="{{ $item->cat_id }}">{{ $item->name }}</option> 
                                @endforeach
                              </select>
                              <p></p>
                        <div class="form-group">
                          <label for="name"><strong>Name</strong></label>
                          <input
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            placeholder="Name"
                          />
                        <p></p>
                        </div>
                        <div class="form-group">
                          <label for="slug"><strong>Slug</strong></label>
                          <input
                            type="text"
                            readonly
                            class="form-control"
                            id="slug"
                            name="slug"
                            placeholder="Slug"
                          />
                        <p></p>
                        </div>

                        {{-- <div class="col-md-6">
                          <div class="mb-3">
                            <input type="hidden" id="image_id" name="image_id" value="">
                            <label for="image">Image</label>
                            <div id="image" name="image" class="dropzone dz-clickable">
                              <div class="dz-message needsclick">
                                <br>Drop files here or click to upload.<br><br><br>
                              </div>
                            </div>
                          </div>
                        </div> --}}

                        <div class="form-group">
                            <label for="status"><strong>Status</strong></label>
                             <select name="status" id="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Block</option>
                             </select>
                             <p></p>
                          </div>

                          <div class="form-group">
                            <label for="status"><strong>Show on Home</strong></label>
                             <select name="showHome" id="showHome" class="form-control">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                             </select>
                          </div>
                        
                    
                  <div class="card-action">
                    <button type="submit" href="{{ url('admin/backend/sub_table') }}" class="btn btn-primary">Submit</button>
                    <a href="{{ url('admin/backend/sub_table') }}" class="btn btn-danger">Cancel</a>
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
        </div>
</section>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
         $("#subCategoryForm").submit(function(event) {
                 event.preventDefault();
                 var element = $("#subCategoryForm");
                  $("button[type=submit]").prop('disabled',true);
                 $.ajax({
                     url: '{{ route("sub_category.store") }}',
                     type: 'post',
                     data: element.serializeArray(),
                     dataType: 'json',
                     success: function(response){
                  $("button[type=submit]").prop('disabled',false);


                       if(response["status"] == true) {

                          window.location.href="{{ route('sub_table.index') }}";

                          $("#name").removeClass('is-invalid')
                              .siblings('p')
                              .removeClass('invalid-feedback').html("");

                          $("#slug").removeClass('is-invalid')
                              .siblings('p')
                              .removeClass('invalid-feedback').html("");

                              $("#category").removeClass('is-invalid')
                              .siblings('p')
                              .removeClass('invalid-feedback').html("");

                        } else{

                         if(response['notFound'] == true) {
                         window.location.href="{{ route('sub_table.index') }}";
                         }

                           var errors = response['errors'];
                         if(errors['name']){
                             $("#name").addClass('is-invalid')
                           .siblings('p')
                             .addClass('invalid-feedback').html(errors['name']);
                         }else{
                             $("#name").removeClass('is-invalid')
                             .siblings('p')
                             .removeClass('invalid-feedback').html("");
                         }

                        if(errors['slug']){
                             $("#slug").addClass('is-invalid')
                             .siblings('p')
                             .addClass('invalid-feedback').html(errors['slug']);
                         }else{
                             $("#slug").removeClass('is-invalid')
                             .siblings('p')
                             .removeClass('invalid-feedback').html("");
                         }

                        if(errors['cat_id']){
                             $("#cat_id").addClass('is-invalid')
                             .siblings('p')
                             .addClass('invalid-feedback').html(errors['cat_id']);
                         }else{
                             $("#cat_id").removeClass('is-invalid')
                             .siblings('p')
                             .removeClass('invalid-feedback').html("");
                         }

                      }//, error: function(jqXHR, exception){
                     //      console.log("Somthing Went Wrong");

                     //     }
                       }

                        
               });
           }); 

           $("#name").change(function() {
    var element = $(this);
    var submitButton = $("button[type=submit]");
    
    // Disable the submit button initially
    submitButton.prop('disabled', true);
    
    // Clear the slug field before making the AJAX request
    $("#slug").val('');

    $.ajax({
        url: '{{ route("admin/getSlug") }}',
        type: 'get',
        data: { title: element.val() },
        dataType: 'json',
        success: function(response) {
            if (response.status === true && response.slug) {
                // Populate the slug field and enable the submit button
                $("#slug").val(response.slug);
                submitButton.prop('disabled', false);
            } else {
                // Keep the button disabled if no slug is returned
                alert('Slug generation failed. Please try again.');
                submitButton.prop('disabled', true);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed: ' + error);
            // Keep the button disabled on error
            submitButton.prop('disabled', true);
            alert('An error occurred. Please check the console for details.');
        }
    });
});
</script>
        
@endsection


        