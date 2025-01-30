@extends('backend.layouts.app')
@section('content-page')
    {{-- <section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Products</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="create-product.html" class="btn btn-primary">New Product</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section> --}}

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
                        <div class="col-md-15">
                            <div class="card">
                                <div class="card-header">
                                    <a href="{{ url('admin/backend/Products/product') }}"
                                        class="btn btn-primary btn-sm mb-3 float-end"><i data-feather="plus"></i><strong>Add
                                            Product</strong></a>

                                    <h3 class="fw-bold mb-3">Product Table</h3>
                                </div>
                                <!-- Main content -->
                                <section class="content">
                                    <!-- Default box -->
                                    <div class="container-fluid">
                                        {{-- <div class="card"> --}}
                                        {{-- <div class="card-header"> --}}

                                        <div class="card-tools">
                                            <form action="" method="get">
                                                @csrf
                                                <div class="card-tools">
                                                    <div class="input-group input-group float-end mt-2"
                                                        style="width: 250px;">
                                                        <input value="{{ Request::get('keyword') }}" type="text"
                                                            name="keyword" class="form-control float-end"
                                                            placeholder="Search">

                                                        <div class="input-group-append">
                                                            <button type="submit" class="btn btn-default">
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <button type="button" onclick="window.location.href='{{ route('product.index') }}'"
                                        class="btn btn-primary btn-sm mb-15 mt-2 ms-3">Reset</button>
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th width="60" class="text-center">ID</th>
                                                    <th width="80" class="text-center">Product Image</th>
                                                    <th class="text-center">Product</th>
                                                    <th class="text-center">Price</th>
                                                    <th class="text-center">Qty</th>
                                                    <th class="text-center">SKU</th>
                                                    <th class="text-center" width="100">Status</th>
                                                    <th class="text-center" width="100">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>


                                                @foreach ($products as $product)
                                                    @php
                                                        $productImage = $product->product_images->first();
                                                    @endphp
                                                    <tr>
                                                        <td class="text-center">{{ $product->pro_id }}</td>
                                                        <td>
                                                            @if (!empty($productImage->image))
                                                                <img src="{{ asset('uploads/product/small/' . $productImage->image) }}"
                                                                    class="img-thumbnail" width="50" />
                                                            @else
                                                                <img src="{{ asset('backend/assets/img/blogpost.jpg') }}"
                                                                    class="img-thumbnail" width="50" />
                                                            @endif
                                                        </td>
                                                        <td class="text-center"><a href="#">{{ $product->title }}</a>
                                                        </td>
                                                        <td class="text-center"> ${{ $product->price }}</td>
                                                        <td class="text-center">{{ $product->qty }} Left in Stock</td>
                                                        <td class="text-center">{{ $product->sku }}</td>
                                                        <td>
                                                            @if ($product->status == 1)
                                                                <svg class="text-success-500 h-6 w-6 text-success"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="2"
                                                                    stroke="currentColor" aria-hidden="true">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                    </path>
                                                                </svg>
                                                            @else
                                                                <svg class="text-danger h-6 w-6"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="2"
                                                                    stroke="currentColor" aria-hidden="true" fill="none">
                                                                    <circle cx="12" cy="12" r="9"
                                                                        stroke="CurrentColor" stroke-width="2"
                                                                        fill="none"></circle>
                                                                    <path stroke-linescap="round" stroke-linejoin="round"
                                                                        d="M6 18L18 6M6 6l12 12">
                                                                    </path>
                                                                </svg>
                                                            @endif

                                                        </td>
                                                        <td>
                                                            <a href="{{ url('admin/backend/Products/edit/' . $product->pro_id) }}"
                                                                class="btn btn-primary btn-sm">Edit</a>
                                                            <a href="{{ url('admin/backend/Products/delete/') }}"
                                                                onclick="deleteproduct({{ $product->pro_id }})"
                                                                class="btn btn-danger btn-sm">Delete</a>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                @if ($products->isNotEmpty())
                                                @else
                                                    <tr>
                                                        <td>Records Not Found</td>
                                                    </tr>
                                                @endif


                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer clearfix">
                                        {{ $products->links() }}
                                    </div>
                            </div>
                        </div>
    </section>
    <!-- /.card -->
    </section>

    <script>
        function deleteproduct(id) {
            var url = '{{ route('product.delete', 'ID') }}';
            var newUrl = url.replace("ID", id);

            if (confirm("Are you sure you want to delete")) {
                $.ajax({
                    url: newUrl,
                    type: 'DELETE',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response["status"] == true) {
                            alert(response["message"]);
                            window.location.href = "{{ route('product.index') }}";
                        } else {
                            window.location.href = "{{ route('product.index') }}";
                            alert("Error: " + response["message"]);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Error: " + error);
                    }
                });
            }
        }
    </script>
@endsection
