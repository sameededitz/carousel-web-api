@extends('layout.admin-layout')
@section('title')
    Affiliate Applications | Admin
@endsection
@section('admin_content')
    @if (session('status'))
        <div class="row py-3">
            <div class="col-6">
                <x-alert :type="session('status', 'info')" :message="session('message', 'Operation completed successfully.')" />
            </div>
        </div>
    @endif

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24 bread-crumb">
        <h6 class="fw-semibold mb-0"></h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin-home') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Applications</li>
        </ul>
    </div>

    <div class="card basic-data-table">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">All Submitted Applications</h5>
        </div>
        <div class="card-body scroll-sm" style="overflow-x: scroll">
            <table class="table display responsive bordered-table mb-0" id="myTable" data-page-length='10'>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col">Referral Code</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    {{-- Data will be populated by jQuery --}}
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('admin_scripts')
    <script>
        $('#myTable').DataTable({
            responsive: true,
            ajax: {
                url: '{{ route('get-applications') }}', // Replace with your GET route
                type: 'GET',
                dataSrc: ''
            },
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'status',
                    render: function(data) {
                        return `<span title="${data}">${data.charAt(0).toUpperCase() + data.slice(1)}</span>`;
                    }
                },
                {
                    data: 'referral_code',
                    render: function(data) {
                        return data ? data : 'No referral code';
                    }
                },
                {
                    data: null,
                    render: function(data) {
                        let approveButton = data.status === 'pending' ?
                            `<button class="w-32-px me-4 h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center approve" data-id="${data.id}">
                                <iconify-icon icon="lucide:check"></iconify-icon>
                            </button>` :
                            '';
                        let cancelButton = data.status === 'pending' ?
                            `<button class="w-32-px me-4 h-32-px bg-warning-focus text-warning-main rounded-circle d-inline-flex align-items-center justify-content-center cancel" data-id="${data.id}">
                                <iconify-icon icon="lucide:x"></iconify-icon>
                            </button>` :
                            '';
                        return `
                            <div class="d-flex align-items-center">
                                ${approveButton}
                                ${cancelButton}
                                <button class="w-32-px me-4 h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center delete" data-id="${data.id}">
                                    <iconify-icon icon="lucide:trash-2"></iconify-icon>
                                </button>
                            </div>
                        `;
                    }
                }
            ]
        });

        $('#myTable').on('click', '.approve', function() {
            let id = $(this).data('id');
            if (!id) {
                showAlert('Invalid application ID.', 'danger');
                return;
            };
            $.ajax({
                url: `/admin/application/${id}/approve`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 400 || response.status === false) {
                        showAlert(response.message, 'danger');
                    } else {
                        $('#myTable').DataTable().ajax.reload();
                        showAlert(response.message, 'success');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    showAlert('An error occurred while processing your request.', 'error');
                }
            });
        });

        $('#myTable').on('click', '.cancel', function() {
            let id = $(this).data('id');
            if (!id) {
                showAlert('Invalid application ID.', 'danger');
                return;
            };
            $.ajax({
                url: `/admin/application/${id}/cancel`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 400 || response.status === false) {
                        showAlert(response.message, 'danger');
                    } else {
                        $('#myTable').DataTable().ajax.reload();
                        showAlert(response.message, 'success');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    showAlert('An error occurred while processing your request.', 'error');
                }
            });
        });

        $('#myTable').on('click', '.delete', function() {
            let id = $(this).data('id');
            if (!id) {
                showAlert('Invalid application ID.', 'danger');
                return;
            };
            $.ajax({
                url: `/admin/application/${id}/delete`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 400 || response.status === false) {
                        showAlert(response.message, 'danger');
                    } else {
                        $('#myTable').DataTable().ajax.reload();
                        showAlert(response.message, 'success');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    showAlert('An error occurred while processing your request.', 'error');
                }
            })
        })

        function showAlert(message, type) {
            let alertHtml =
                `<div class="alert-box row py-2"><div class="col-6"><x-alert :type="'${type}'" :message="'${message}'" /></div></div>`;
            $('.alert-box').remove();
            $('.bread-crumb').before(alertHtml);
        }
    </script>
@endsection
