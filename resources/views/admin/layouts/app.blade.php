<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('admin/') }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title') - @yield('comp')</title>
	<meta name="description" content="@yield('comp')">
	<meta name="keywords" content="@yield('comp')">
	<meta name="author" content="@yield('comp')">
	<meta name="robots" content="index, follow">
	<link rel="apple-touch-icon" sizes="180x180" href="{{ getImageUrl(getSetting('favicon')) }}">
	<link rel="icon" href="{{ getImageUrl(getSetting('favicon')) }}" type="image/x-icon">
	<link rel="shortcut icon" href="{{ getImageUrl(getSetting('favicon')) }}" type="image/x-icon">
    @include('admin.layouts.css')
    @stack('css')
    @toastr_css
</head>

<body>

	<div id="global-loader">
		<div class="page-loader"></div>
	</div>

	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
        @include('admin.layouts.header')
		<!-- /Header -->

        @include('admin.layouts.sidebar')

		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content">
				<!-- Breadcrumb -->
				<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
                    {!! generate_breadcrumb() !!}
                    @stack('breadcrumb-buttons')
                </div>
				<!-- /Breadcrumb -->
                @yield('content')

			</div>

            @include('admin.layouts.footer')

		</div>
		<!-- /Page Wrapper -->

	</div>
	<!-- /Main Wrapper -->

    @include('admin.layouts.scripts')
    @stack('scripts')
    @toastr_js
    @toastr_render
    <script>
        function alert_toastr(type, message) {
            switch(type) {
                case 'error':
                    toastr.error(message, 'Error');
                    break;
                case 'success':
                    toastr.success(message, 'Success');
                    break;
                case 'warning':
                    toastr.warning(message, 'Warning');
                    break;
                case 'info':
                    toastr.info(message, 'Information');
                    break;
                default:
                    toastr.info(message, 'Information');
            }
        }
    function _delete(e) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this item?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var $this = $(e);
                var url = $this.attr('url');
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _method: 'DELETE'
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(data) {
                        if (data.res === 'success') {
                            Swal.fire(
                                'Deleted!',
                                data.msg,
                                'success'
                            );
                            $this.closest('tr').remove();
                            window.location.reload();
                        } else {
                            Swal.fire(
                                'Error!',
                                data.msg,
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'There was an issue with the request.',
                            'error'
                        );
                    }
                });
            }
        }).catch(Swal.noop);
        return false;
    }


    $(document).on('click', '[data-toggle="change-status"]', function(event) {
        $('#showModal').modal('hide');
        var baseUrl = $('meta[name="base-url"]').attr('content');
        var url = baseUrl + "/change_status";
            var element = $(this);
            var data = element.attr('data');
            var value = element.attr('value');
            Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to change status ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post({
                            url: url,
                            data: {
                                data: data,
                                value: value,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                element.parent().html(response.html);
                                alert_toastr('success','Saved');
                            },
                            error: function() {
                                Swal.fire('Error', 'Failed to change status. Please try again.', 'error');
                            }
                        });
                    }
                });
                return false;
    });
    var timer;
    $(document).on('input', '.change-indexing', function () {
        clearTimeout(timer);
        var t = $(this);
        timer = setTimeout(function () {
            updateIndexing(t);
        }, 1000);
    });



    function updateIndexing(input) {
        var baseUrl = $('meta[name="base-url"]').attr('content');
        var url = baseUrl + "/change_indexing";
        var data = input.attr('data');
        var value = input.val();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                data: data,
                value: value,
                _token: csrfToken
            },
            success: function (response) {
                if (response.res == 'success') {
                    alert_toastr('success', response.msg);
                } else {
                    alert_toastr('error', response.msg);
                }
            },
            error: function () {
                alert_toastr('error', 'An error occurred.');
            }
        });
    }
    </script>
</body>
</html>
