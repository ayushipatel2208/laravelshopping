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
                <a href="{{url('admin/backend/Brands/list')}}" class="btn btn-primary btn-sm mb-3 float-end"><i data-feather="plus"></i><strong>Back To Brand Table</strong></a>

                    <h3 class="fw-bold mb-3">Create Brand</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 col-lg-12">
                        <form action="" method="POST" id="createBrandForm" name="createBrandForm">
                            @csrf
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


                        <div class="form-group">
                            <label for="status"><strong>Status</strong></label>
                             <select name="status" id="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Block</option>
                             </select>
                          </div>
                        
                    
                  <div class="card-action">
                    <button type="submit" href="{{ url('admin/backend/Brands/list') }}" class="btn btn-primary">Submit</button>
                    <a href="{{ url('backend/index') }}" class="btn btn-danger">Cancel</a>
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
<script src="{{ asset('backend/assets/js/plugin/dropzone/dropzone.min.js')}}"></script>
        <script>
           $("#createBrandForm").submit(function (event) {
    event.preventDefault();

    var form = $(this);
    $("button[type=submit]").prop('disabled', true);

    $.ajax({
        url: '{{ route("brand.store") }}',
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',
        success: function (response) {
            $("button[type=submit]").prop('disabled', false);

            if (response.status) {
                window.location.href = "{{ route('brand.index') }}";
            } else {
                var errors = response.errors;

                if (errors.name) {
                    $("#name").addClass('is-invalid')
                        .siblings('.invalid-feedback')
                        .html(errors.name);
                } else {
                    $("#name").removeClass('is-invalid')
                        .siblings('.invalid-feedback')
                        .html("");
                }

                if (errors.slug) {
                    $("#slug").addClass('is-invalid')
                        .siblings('.invalid-feedback')
                        .html(errors.slug);
                } else {
                    $("#slug").removeClass('is-invalid')
                        .siblings('.invalid-feedback')
                        .html("");
                }
            }
        },
        error: function (xhr, status, error) {
            console.error("Something went wrong:", error);
            $("button[type=submit]").prop('disabled', false);
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


        