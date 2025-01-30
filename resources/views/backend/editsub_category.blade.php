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

                    <h3 class="fw-bold mb-3">Edit Sub Category</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 col-lg-12">
                        <form id="subCategoryForm" name="subCategoryForm" action="{{route('sub_category.update', $subCategory->sub_id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="sub_id" id="sub_id" value="{{ $subCategory->sub_id }}">
                            <div class="form-group">
                              <label for="category"><strong>Category</strong></label>
                              <select name="cat_id" id="cat_id" class="form-control">
                                <option value="">Select A Category</option>
                                @foreach ($categories as $item)
                                {{-- <option {{ ($subCategory->sub_id == $item->sub_id) ? 'selected': ''}} value="{{ $item->sub_id }}">{{ $item->name }}</option> --}}
                                <option {{ ($subCategory->cat_id == $item->cat_id) ? 'selected': '' }} value="{{ $item->cat_id }}">{{ $item->name }}</option>
                                @endforeach
                          
                              </select>
                              <p></p>
                        <div class="form-group">
                          <label for="name"><strong>Name</strong></label>
                          <input
                            type="text"
                            value="{{ $subCategory->name }}"
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
                            value="{{ $subCategory->slug }}"
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
                                <option {{ ($subCategory->status == 1) ? 'selected' : '' }} value="1">Active</option>
                                <option {{ ($subCategory->status == 0) ? 'selected' : '' }} value="0">Block</option>
                             </select>
                             <p></p>
                          </div>

                          <div class="form-group">
                            <label for="status"><strong>Show on Home</strong></label>
                             <select name="showHome" id="showHome" class="form-control">
                                <option {{ ($subCategory->showHome == 'Yes') ? 'selected' : '' }} value="Yes">Yes</option>
                                <option {{ ($subCategory->showHome == 'No') ? 'selected' : '' }} value="No">No</option>
                             </select>
                          </div>
                        
                    
                  <div class="card-action">
                    <button type="submit" class="btn btn-primary">Update</button>
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
<script>
//   $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });
         $("#subCategoryForm").submit(function(event) {
                 event.preventDefault();
                 var element = $("#subCategoryForm");
                 var id = $("#sub_id").val();
                 var url = '{{ route("sub_category.update", "ID") }}';
                var newUrl = url.replace("ID",id);
                  $("button[type=submit]").prop('disabled',true);
                 $.ajax({
                     url: newUrl,
                     type: 'post',
                     data: element.serializeArray(),
                     dataType: 'json',
                     headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
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
                         return false;
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

                    }
        //             error: function(xhr, status, error) {
        //     console.error('AJAX request failed: ' + error);
        // }
                  });
            });
</script>
        
@endsection


        