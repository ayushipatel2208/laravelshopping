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
                                    <a href="{{ route('product.index') }}" class="btn btn-primary btn-sm mb-3 float-end"><i
                                            data-feather="plus"></i><strong>Back</strong></a>

                                    <h3 class="fw-bold mb-3">Edit Product</h3>
                                </div>


                                <section class="content mt-3">
                                    <!-- Default box -->
                                    <div class="container-fluid">
                                        <form action="" method="POST" name="productForm" id="productForm" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="card mb-3">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label for="title">Title</label>
                                                                        <input type="text" value="{{ $product->title }}" name="title" id="title"
                                                                            class="form-control" placeholder="Title">
                                                                         <p class="error"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label for="title">Slug</label>
                                                                        <input type="text" value="{{ $product->slug }}" readonly name="slug"
                                                                            id="slug" class="form-control"
                                                                            placeholder="Slug">
                                                                            <p class="error"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label for="description">Description</label>
                                                                        <textarea name="description" id="description" cols="30" rows="10" class="summernote"
                                                                            placeholder="Description">{{ $product->description }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                     <div class="card mb-3"> 
                                                        <div class="card-body">
                                                            <input type="hidden" id="image_id" name="image_id" value="">
                                                            <h2 class="h4 mb-3">Media</h2>
                                                            <div id="image" name="image" class="dropzone dz-clickable">
                                                                <div class="dz-message needsclick">
                                                                     <br>Drop files here or click to upload.<br><br>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="row" id="product-gallary">
                                                        @if ($productImages->isNotEmpty())
                                                            @foreach ($productImages as $image)
                                                            <div class="col-md-3" id="image-row-{{ $image->pro_id }}">
                                                                <div class="card">
                                                                    <img src="{{ asset('/uploads/product/small/'. $image->image) }}" class="card-img-top" alt="">
                                                                    <input type="hidden" name="image_array[]" value="{{ $image->pro_id }}">
                                                                    <div class="card-body">
                                                                     <a href="javascript:void(0)" onclick="deleteImage({{ $image->pro_id }})" class="btn btn-danger">Delete</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach    

                                                        @endif
                                                    </div>

                                                    <div class="card mb-3">
                                                        <div class="card-body">
                                                            <h2 class="h4 mb-3">Pricing</h2>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label for="price">Price</label>
                                                                        <input type="text" value="{{ $product->price }}" name="price" id="price"
                                                                            class="form-control" placeholder="Price">
                                                                            <p class="error"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label for="compare_price">Compare at Price</label>
                                                                        <input type="text" value="{{ $product->compare_price }}" name="compare_price"
                                                                            id="compare_price" class="form-control"
                                                                            placeholder="Compare Price">
                                                                        <p class="text-muted mt-3">
                                                                            To show a reduced price, move the product’s
                                                                            original price into Compare at price. Enter a
                                                                            lower value into Price.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card mb-3">
                                                        <div class="card-body">
                                                            <h2 class="h4 mb-3">Inventory</h2>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="sku">SKU (Stock Keeping
                                                                            Unit)</label>
                                                                        <input type="text" value="{{ $product->sku }}" name="sku" id="sku"
                                                                            class="form-control" placeholder="sku">
                                                                            <p class="error"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="barcode">Barcode</label>
                                                                        <input type="text" value="{{ $product->barcode }}" name="barcode" id="barcode"
                                                                            class="form-control" placeholder="Barcode">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="hidden" name="track_qty" value="No">
                                                                            <input class="custom-control-input"
                                                                                type="checkbox" id="track_qty"
                                                                                name="track_qty" value="Yes" {{ $product->track_qty == 'Yes' ? 'checked' : '' }}>
                                                                            <label for="track_qty"
                                                                                class="custom-control-label">Track
                                                                                Quantity</label>
                                                                                <p class="error"></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <input type="number" value="{{ $product->qty }}" min="0"
                                                                            name="qty" id="qty"
                                                                            class="form-control" placeholder="Qty">
                                                                            <p class="error"></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card mb-3">
                                                        <div class="card-body">
                                                            <h2 class="h4 mb-3">Product status</h2>
                                                            <div class="mb-3">
                                                                <select name="status" id="status"
                                                                    class="form-control">
                                                                    <option {{  ($product->status == 1) ? 'selected' : '' }} value="1">Active</option>
                                                                    <option {{  ($product->status == 0) ? 'selected' : '' }} value="0">Block</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h2 class="h4 mb-3">Product Category</h2>
                                                            <div class="mb-3">
                                                                <label for="category">Category</label>
                                                                <select name="cat_id" id="cat_id"
                                                                    class="form-control">
                                                                    <option value="">Select A Category</option>
                                                                    @if ($categories->isNotEmpty())
                                                                        @foreach ($categories as $category)
                                                                            <option {{ ($product->cat_id == $category->cat_id) ? 'selected' : '' }} value="{{ $category->cat_id }}">
                                                                                {{ $category->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                <p class="error"></p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="subcategory">Subcategory</label>
                                                                <select name="sub_id" id="sub_id"
                                                                    class="form-control">
                                                                    <option value="">Select A Subcategory</option>
                                                                    @if ($subcategories->isNotEmpty())
                                                                    @foreach ($subcategories as $subcategory)
                                                                        <option {{ ($product->sub_id == $subcategory->sub_id) ? 'selected' : '' }} value="{{ $subcategory->sub_id }}">
                                                                            {{ $subcategory->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card mb-3">
                                                        <div class="card-body">
                                                            <h2 class="h4 mb-3">Product brand</h2>
                                                            <div class="mb-3">
                                                                <select name="id" id="id"
                                                                    class="form-control">
                                                                    <option value="">Select A Brand</option>
                                                                    @if ($brands->isNotEmpty())
                                                                        @foreach ($brands as $brand)
                                                                            <option {{ ($product->id == $brand->id) ? 'selected' : '' }} value="{{ $brand->id }}">
                                                                                {{ $brand->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card mb-3">
                                                        <div class="card-body">
                                                            <h2 class="h4 mb-3">Featured product</h2>
                                                            <div class="mb-3">
                                                                <select name="is_featured" id="is_featured"
                                                                    class="form-control">
                                                                    <option {{ ($product->is_featured == 'No') ? 'selected' : '' }} value="No">No</option>
                                                                    <option {{ ($product->is_featured == 'Yes') ? 'selected' : '' }} value="Yes">Yes</option>
                                                                    <p class="error"></p>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="pb-5 pt-3">
                                                <button type="submit" href="{{ url('admin/backend/Products/list') }}" class="btn btn-primary">Update</button>
                                                <a href="{{ route('product.index') }}" class="btn btn-danger">Cancel</a>
                                            </div>
                                    </div>
                                    </form>
                                    <!-- /.card -->
                                </section>
                                <!-- /.content -->
                                <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <script src="{{ asset('backend/assets/js/plugin/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugin/dropzone/dropzone.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        

        $("#title").change(function() {
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


$("#productForm").submit(function(event) {
    event.preventDefault();
    var formArray = $(this).serializeArray();
    $("button[type=submit]").prop('disabled',true);

    $.ajax({
        url: '{{ route("product.update", $product->pro_id) }}', // Ensure this route is correct
        type: 'put', // Use POST for form submission
        data: formArray,
        dataType: 'json',
        success: function(response) {
            console.log('response');

            $("button[type=submit]").prop('disabled',false);

            if (response['status'] === true) {
                $(".error").removeClass('isvalid-feedback').html('');
                $("input[type='text'], select, input[type='number']").removeClass('is-invalid');

               window.location.href="{{ route('product.index') }}";
                // Success logic here (e.g., redirect or show a message)
            } else {
                var errors = response['errors'] || {};

                $(".error").removeClass('isvalid-feedback').html('');
                $("input[type='text'], select, input[type='number']").removeClass('is-invalid');

                $.each(errors, function(key, value){
                    $(`#${key}`).addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(value);
                });

                // Handle other errors if needed
                if (response['notFound'] === true) {
                    window.location.href = "{{ route('product-subcategory.getSubcategories') }}";
                }
            }
        },
        error: function() {
            console.log("Something went wrong");
        }
    });
});


        $("#cat_id").change(function() {
                var cat_id = $(this).val();

            $.ajax({
                url: '{{ route('product-subcategory.getSubcategories')}}',
                type: 'get',
                data: { cat_id: cat_id },
                dataType: 'json',
                success: function(response) {
                    console.log(response);

                    $("#sub_id").find("option").not(":first").remove();
                   $.each(response["subcategories"], function(key, item) {
               $("#sub_id").append(`<option value="${item.sub_id}">${item.name}</option>`);
                });

                },
                error: function() {
                    console.log("Somthing Went Wrong");
                }
            });
        });

     
//         $(document).ready(function () {
//     Dropzone.autoDiscover = false;

    // const dropzone = new Dropzone("#image", {
    //     url: "{{ route('product-image.update') }}",
    //     maxFiles: 10,
    //     paramName: 'image',
    //     params: {'pro_id': '{{ $product->pro_id }}'},
    //     addRemoveLinks: true,
    //     acceptedFiles: "image/jpeg,image/png,image/gif",
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     },
    //     success: function (file, response) {
    //         if (response.status) {
    //             var html = `
    //                 <div class="col-md-3" id="image-row-${response.image_id}">
    //                     <div class="card">
    //                         <img src="${response.ImagePath}" class="card-img-top" alt="">
    //                         <input type="hidden" name="image_array[]" value="${response.image_id}">
    //                         <div class="card-body">
    //                             <a href="javascript:void(0)" onclick="deleteImage(${response.image_id})" class="btn btn-danger">Delete</a>
    //                         </div>
    //                     </div>
    //                 </div>`;
    //             $('#product-gallary').append(html);
    //         } else {
    //             console.error('Error:', response.message);
    //         }
    //     }
    // });
// });

const dropzone = new Dropzone("#image", {
    url: "{{ route('product-image.update') }}", // Backend route to handle file upload
    maxFiles: 10, // Maximum number of files
    paramName: 'image', // Parameter name for file
    params: { 'pro_id': '{{ $product->pro_id }}' }, // Additional parameters
    addRemoveLinks: true, // Add remove links
    acceptedFiles: "image/jpeg,image/png,image/gif", // Allowed file types
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF Token for security
    },
    success: function (file, response) {
        if (response.status) {
            // Create a Bootstrap card for the uploaded image
            var html = `
                <div class="col-md-3" id="image-row-${response.image_id}">
                    <div class="card">
                        <!-- Display uploaded image -->
                        <img src="${response.imagePath}" class="card-img-top" alt="Uploaded Image">
                        <!-- Hidden input to store the image ID -->
                        <input type="hidden" name="image_array[]" value="${response.image_id}">
                        <div class="card-body text-center">
                            <!-- Button to delete the image -->
                            <a href="javascript:void(0)" onclick="deleteImage(${response.image_id})" class="btn btn-danger btn-sm">Delete</a>
                        </div>
                    </div>
                </div>`;
            // Append the new card to the product gallery
            $('#product-gallary').append(html);
        } else {
            console.error('Error:', response.message); // Log error if upload fails
        }
    },
    error: function (file, errorMessage) {
        console.error('Error during upload:', errorMessage); // Log any errors during upload
    }
});




function deleteImage(id) {
    if (confirm("Are you sure you want to delete this image?")) {
        $.ajax({
            url: '{{ route("product-image.destroy") }}',
            type: 'DELETE',
            data: {
                pro_id: {{ $product->pro_id }},
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status) {
                    alert(response.message);
                    $("#image-row-" + id).remove(); // Remove the image row on success
                } else {
                    alert(response.message);
                }
            },
            error: function () {
                alert("Error deleting image.");
            }
        });
    }
}


    </script>

    @endsection
