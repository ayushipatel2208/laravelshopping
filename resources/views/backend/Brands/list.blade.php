@extends('backend.layouts.app')
@section('content-page')
    <div class="container">
        <div class="page-inner">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                         <div class="card-header">
                            <a href="{{ url('admin/backend/Brands/brand') }}" class="btn btn-primary btn-sm mb-3 float-end"><i
                                data-feather="plus"></i><strong>Add Brands</strong></a>
                            <div class="card-title">Brands Table</div>
                            
                         </div>
                            <form action="" method="get">
                                @csrf
                                <div class="card-tools">
                                    <button type="button" onclick="window.location.href='{{ route('brand.index') }}'"
                            class="btn btn-primary btn-sm mt-2 ms-3 mb-15">Reset</button>
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
                            </form>
                             <div class="card-body">
                              <div class="table-responsive">
                                  
                                <table id="basic-datatables" class="table table-hover text-nowrap">
                                    @method('DELETE')
                                    <thead>
                                        <tr>
                                            <th class="text-center" scope="col">Id</th>
                                            <th class="text-center" scope="col">Name</th>
                                            <th class="text-center" scope="col">Slug</th>
                                            <th class="text-center" width="100" scope="col">Status</th>
                                            <th class="text-center" width="100" scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($brands as $brand)
                                            <tr>
                                                <td class="text-center">{{ $brand->id }}</td>
                                                <td class="text-center">{{ $brand->name }}</td>
                                                <td class="text-center">{{ $brand->slug }}</td>
                                                <td>
                                                    @if ($brand->status == 1)
                                                        <svg class="text-success-500 h-6 w-6 text-success"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            aria-hidden="true">
                                                            <path stroke-linescap="round" stroke-linejoin="round"
                                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="text-danger h-6 w-6" 
                                                        xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" aria-hidden="true" fill="none">
                                                            <circle cx="12" cy="12" r="9" stroke="CurrentColor" stroke-width="2" fill="none"></circle>
                                                            <path stroke-linescap="round" stroke-linejoin="round"
                                                                d="M6 18L18 6M6 6l12 12">
                                                            </path>
                                                        </svg>
                                                    @endif
                                                </td>
                                                <td>
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
                                                    <a href="{{ url('admin/backend/Brands/edit/' . $brand->id) }}"
                                                        class="btn btn-primary btn-sm">Edit</a>
                                                        <a href="{{ route('brand.delete', $brand->id) }}" 
                                                            class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete this brand?');">Delete</a>
                                                         
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($brands->isNotEmpty())
                                        @else
                                            <tr>
                                                <td colspan="5">Records Not Found</td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                                <div class="card-footer clearfix">
                                    {{ $brands->links() }}
                                </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
            
         <script>
            // function deletesubCategory(id){
            //     var url = '{{ route("sub_category.delete", "ID") }}';
            //     var newUrl = url.replace("ID",id);
                
            //     if(confirm("Are you sure you want to delete")){
            //         $.ajax({
            //         url: newUrl,
            //         type: 'delete',
            //         data: {},
            //         dataType: 'json',
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            //         },
            //         success: function(response) {
            //               window.location.href = "{{ route('sub_table.index') }}";

            //             // if(response["status"]) {
            //             //     window.location.href = "{{ route('sub_table.index') }}";
            //             // } 
            //         }
            //     });
            //     }
            // }
         </script>
    @endsection
