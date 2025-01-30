{{-- 
@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    <h4><i class="icon fa fa-ban"></i>Error!</h4> {{Session::get('error')}}
    @endif
</div>  


@if (Session::has('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    <h4><i class="icon fa fa-check"></i>Success!</h4> {{Session::get('success')}}
    @endif
</div>  --}}

 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        @if(session('success'))
            $.notify({
                // Notification content
                message: "{{ session('success') }}"
            },{
                // Notification options
                type: 'success', // 'success', 'danger', 'info', 'warning'
                allow_dismiss: true,
                delay: 3000,
                placement: {
                    from: "top", // 'top', 'bottom'
                    align: "right" // 'left', 'right', 'center'
                },
                offset: {
                    x: 20, // Horizontal offset
                    y: 70  // Vertical offset
                }
            });
        @elseif(session('warning'))
        $.notify({
            // Notification content
            message: "{{ session('warning') }}"
        },{
            // Notification options
            type: 'warning', // 'success', 'danger', 'info', 'warning'
            allow_dismiss: true,
            delay: 3000,
            placement: {
                from: "top", // 'top', 'bottom'
                align: "right" // 'left', 'right', 'center'
            },
            offset: {
                x: 20, // Horizontal offset
                y: 70  // Vertical offset
            }
        });
        @elseif(session('error'))
            $.notify({
                message: "{{ session('error') }}"
            },{
                type: 'danger',
                allow_dismiss: true,
                delay: 3000,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: {
                    x: 20,
                    y: 70
                }
            });
        @endif
    });
</script>

