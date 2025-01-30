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
                <a href="{{ route('brand.index')}}" class="btn btn-primary btn-sm mb-3 float-end"><i data-feather="plus"></i><strong>Back</strong></a>

                    <h3 class="fw-bold mb-3">Update Brand</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 col-lg-12">
                        <form action="{{ route('brand.update',$brand->id) }}" method="POST" id="editBrandForm" name="editBrandForm">
                            @csrf
                            @method('PUT')
                        <div class="form-group">
                          <label for="name"><strong>Name</strong></label>
                          <input
                            type="text"
                            value="{{ $brand->name}}"
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
                            value="{{ $brand->slug }}"
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
                                <option {{ ($brand->status == 1) ? 'selected' : '' }} value="1">Active</option>
                                <option {{ ($brand->status == 0) ? 'selected' : '' }} value="0">Block</option>
                             </select>
                          </div>
                        
                    
                  <div class="card-action">
                    <button type="submit" href="{{ url('admin/backend/Brands/list') }}" class="btn btn-primary">Update</button>
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
            // $("#editBrandForm").submit(function(event) {
            //     event.preventDefault();
            //     var element = $(this);
            //     var url = '{{ route("brand.update","ID")}}'
            //     var newUrl = url.replace("ID",id);

            //      $("button[type=submit]").prop('disabled',true);
            //     $.ajax({
            //         url: newUrl,
            //         type: 'put',
            //         data: element.serializeArray(),
            //         dataType: 'json',
            //         success: function(response){
            //      $("button[type=submit]").prop('disabled',false);


            //           if(response["status"] == true) {

            //             window.location.href="{{ route('list.index') }}";

            //             $("#name").removeClass('is-invalid')
            //                 .siblings('p')
            //                 .removeClass('invalid-feedback').html("");

            //             $("#slug").removeClass('is-invalid')
            //                 .siblings('p')
            //                 .removeClass('invalid-feedback').html("");

            //            } else{

            //             if(response['notFound'] == true) {
            //             window.location.href="{{ route('brand.index') }}";
            //             }

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

        </script>
@endsection


        