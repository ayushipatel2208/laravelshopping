@extends('backend.layouts.app')
@section('content-page')
    {{-- <div class="container">
        <div class="page-inner">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                         <div class="card-header">
                            <div class="card-title">Category Table</div>
                            <a href="{{ url('admin/backend/category') }}" class="btn btn-primary btn-sm mb-3 float-end"><i
                                    data-feather="plus"></i><strong>Add Category</strong></a>
                         </div>
                            <form action="" method="get">
                                <div class="card-tools">
                                    <div class="input-group input-group float-end mt-2" style="width: 250px;">
                                        <input value="{{ Request::get('keyword') }}" type="text" name="keyword"
                                            class="form-control float-end" placeholder="Search">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form> --}}
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
                                    <a href="{{ url('admin/backend/category') }}"
                                        class="btn btn-primary btn-sm mb-3 float-end"><i data-feather="plus"></i><strong>Add
                                            Category</strong></a>

                                    <h3 class="fw-bold mb-3">Category Table</h3>
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
                                    <button type="button" onclick="window.location.href='{{ route('category.index') }}'"
                                        class="btn btn-primary btn-sm mb-15 mt-2 ms-3">Reset</button>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <div class="card-title">
                                            </div>
                                            <table class="table table-hover text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" scope="col">Id</th>
                                                        <th class="text-center" scope="col">Name</th>
                                                        <th class="text-center" scope="col">Slug</th>
                                                        <th class="text-center" scope="col">Status</th>
                                                        <th class="text-center" scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($categories as $item)
                                                        <tr>
                                                            <td class="text-center">{{ $item->cat_id }}</td>
                                                            <td class="text-center">{{ $item->name }}</td>
                                                            <td class="text-center">{{ $item->slug }}</td>
                                                            <td>
                                                                @if ($item->status == 1)
                                                                    <svg class="text-success-500 h-6 w-6 text-success"
                                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="2"
                                                                        stroke="currentColor" aria-hidden="true">
                                                                        <path stroke-linescap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                        </path>
                                                                    </svg>
                                                                @else
                                                                    <svg class="text-danger h-6 w-6"
                                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="2"
                                                                        stroke="currentColor" aria-hidden="true"
                                                                        fill="none">
                                                                        <circle cx="12" cy="12" r="9"
                                                                            stroke="CurrentColor" stroke-width="2"
                                                                            fill="none"></circle>
                                                                        <path stroke-linescap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M6 18L18 6M6 6l12 12">
                                                                        </path>
                                                                    </svg>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                {{-- <td>
                                                    <a href="{{ url('category.edit',$item->cat_id) }}"></a>
                                                    <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                    aria-hidden="true">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.
                                                    83-2.828z"></path>
                                                    </svg>
                                                </a>
                                                <a href="#" class="text-danger w-4 h-4 mr-1">
                                                    <svg wire:loading.remove.delay="" wire:target=""
                                                    class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/
                                                    2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.
                                                    382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0
                                                    100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1
                                                    1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0
                                                    00-1-1z" clin-rule="evenodd"></path>
                                                    </svg>
                                                </a> --}}
                                                                <a href="{{ url('admin/backend/edit/' . $item->cat_id) }}"
                                                                    class="btn btn-primary btn-lg mt-0">Edit</a>
                                                                <a href="#" title="Delete"
                                                                    onclick="event.preventDefault(); confirmDelete('{{ $item->cat_id }}');"
                                                                    class="btn btn-danger btn-lg mt-0"
                                                                    style="margin-top: -15px;">
                                                                    Delete
                                                                </a>

                                                                <!-- Delete Button -->
                                                                <form id="delete-form-{{ $item->cat_id }}"
                                                                    action="{{ route('category.delete', $item->cat_id) }}"
                                                                    method="POST" style="display: none;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    @if ($categories->isNotEmpty())
                                                    @else
                                                        <tr>
                                                            <td colspan="5">Records Not Found</td>
                                                        </tr>
                                                    @endif

                                                </tbody>
                                            </table>
                                            <div class="card-footer clearfix">
                                                {{ $categories->links() }}
                                            </div>
                                        </div>
                                    </div>
                                    
                            </div>
                        </div>
    </section>
    <!-- /.card -->
    </section>


                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <script>
                        function confirmDelete(id) {
                            // Display a confirmation dialog
                            if (confirm("Are you sure you want to delete this item? This action cannot be undone.")) {
                                // If confirmed, submit the delete form
                                document.getElementById('delete-form-' + id).submit();
                            }
                        }


                        // Show SweetAlert2 confirmation dialog
                    </script>
                    <script>
                        // //             function deleteproduct(id) {
                        // //     var url = '{{ route('category.delete', 'ID') }}';
                        // //     var newUrl = url.replace("ID", id);

                        // //     if (confirm("Are you sure you want to delete")) {
                        // //         $.ajax({
                        // //             url: newUrl,
                        // //             type: 'DELETE',
                        // //             dataType: 'json',
                        // //             headers: {
                        // //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        // //             },
                        // //             success: function(response) {
                        // //                 if (response["status"] == true) {
                        // //                     alert(response["message"]);
                        // //                     window.location.href = "{{ route('category.index') }}";
                        // //                 } else {
                        // //                     window.location.href = "{{ route('category.index') }}";
                        // //                     alert("Error: " + response["message"]);
                        // //                 }
                        // //             },
                        // //             error: function(xhr, status, error) {
                        // //                 alert("Error: " + error);
                        // //             }
                        // //         });
                        // //     }
                        // // }

                        // // function deletesubCategory(id){
                        // //                 var url = '{{ route('category.delete', 'ID') }}';
                        // //                 var newUrl = url.replace("ID",id);

                        // //                 if(confirm("Are you sure you want to delete")){
                        // //                     $.ajax({
                        // //                     url: newUrl,
                        // //                     type: 'DELETE',
                        // //                     data: {},
                        // //                     dataType: 'json',
                        // //                     headers: {
                        // //                         'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        // //                     },
                        // //                     success: function(response) {
                        // //                          window.location.href = "{{ route('category.index') }}";

                        // //                         if(response["status"]) {
                        // //                             window.location.href = "{{ route('category.index') }}";
                        // //                         } 
                        // //                     }
                        // //                 });
                        // //                 }
                        // //             }

                        // function deleteproduct(id) {
                        //     var url = '{{ route('category.delete', 'ID') }}';
                        //     var newUrl = url.replace("ID", id);

                        //     if (confirm("Are you sure you want to delete")) {
                        //         $.ajax({
                        //             url: newUrl,
                        //             type: 'DELETE',
                        //             dataType: 'json',
                        //             headers: {
                        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        //             },
                        //             success: function(response) {
                        //                 if (response["status"] == true) {
                        //                     alert(response["message"]);
                        //                     window.location.href = "{{ route('category.index') }}";
                        //                 } else {
                        //                     window.location.href = "{{ route('category.index') }}";
                        //                     alert("Error: " + response["message"]);
                        //                 }
                        //             },
                        //             error: function(xhr, status, error) {
                        //                 alert("Error: " + error);
                        //             }
                        //         });
                        //     }
                        // }
                    </script>
                @endsection
