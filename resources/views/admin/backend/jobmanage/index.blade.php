@extends('layouts.app')
@section('content')
    <div class="content pb-0">
        <div class="mb-4">
            <h4 class="mb-1">Job Post Lists<span class="badge badge-soft-primary ms-2">{{ $jobPosts->count() }}</span></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Job Post Lists</li>
                </ol>
            </nav>
        </div>

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                {{-- <div class="input-icon input-icon-start position-relative">
                    <span class="input-icon-addon text-dark"><i class="ti ti-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search">
                </div> --}}
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <x-create-button href="{{ route('jobmanage.create') }}">
                    Create Job Post
                </x-create-button>
            </div>
        </div>

        <div class="card border-0 rounded-0">

            <div class="card-header">
                <h5 class="card-title">Job Information</h5>
            </div>
            <div class="card-body">
                <div class="table-search d-flex align-items-center">
                    <div class="search-input">
                        <a href="javascript:void(0);" class="btn-searchset"><i
                                class="isax isax-search-normal fs-12"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="datatable"
                        class="table jobTable table-hover dt-responsive table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th class="text-center" style="background-color: #9dd2e7">#</th>
                                <th class="text-center" style="background-color: #9dd2e7">Job Code</th>
                                <th class="text-center" style="background-color: #9dd2e7">Country</th>
                                <th class="text-center" style="background-color: #9dd2e7">Company Name </th>
                                <th class="text-center" style="background-color: #9dd2e7"> Job Title </th>
                                <th class="text-center" style="background-color: #9dd2e7">Total </th>
                                <th class="text-center" style="background-color: #9dd2e7">Male  </th>
                                <th class="text-center" style="background-color: #9dd2e7">Female  </th>
                                {{-- <th class="text-center" style="background-color: #9dd2e7">Age Limit </th> --}}
                                <th class="text-center" style="background-color: #9dd2e7">Description </th>
                                <th class="text-center" style="background-color: #9dd2e7">Deadline </th>
                                <th class="text-center" style="background-color: #9dd2e7">Status</th>
                                <th class="text-center" style="background-color: #9dd2e7">Job Image</th>
                                <th class="text-center" style="background-color: #9dd2e7">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('.jobTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                paging: true,
                ajax: {
                    url: "{{ route('job-datatable') }}",
                    type: "GET"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                    },

                    {
                        data: 'job_code',
                        name: 'job_code',
                        className: 'text-center',
                    },
                    {
                        data: 'country',
                        name: 'country',
                        className: 'text-center',
                    },
                    {
                        data: 'company_name',
                        name: 'company_name',
                        className: 'text-center',
                    },
                    {
                        data: 'title',
                        name: 'title',
                        className: 'text-center',
                    },

                    {
                        data: 'total_count',
                        name: 'total_count',
                        className: 'text-center',
                    },
                    {
                        data: 'male_count',
                        name: 'male_count',
                        className: 'text-center',
                    },
                    {
                        data: 'female_count',
                        name: 'female_count',
                        className: 'text-center',
                    },

                    // {
                    //     data: 'age_limit',
                    //     name: 'age_limit',
                    //     className: 'text-center',
                    // },

                    {
                        data: 'description',
                        name: 'description',
                        className: 'text-center',
                    },
                    {
                        data: 'deadline',
                        name: 'deadline',
                        className: 'text-center',
                    },

                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center',
                    },
                    {
                        data: 'job_image',
                        name: 'job_image',
                        className: 'text-center',
                    },

                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },

                ],
            });


            $(document).on('click', '.toggle-description', function() {

                let parent = $(this).parent();

                parent.find('.short-text').toggleClass('d-none');
                parent.find('.full-text').toggleClass('d-none');

                if ($(this).text() === 'Show More') {
                    $(this).text('Show Less');
                } else {
                    $(this).text('Show More');
                }
            });

            $(document).on('click', '.deleteBtn', function(event) {
                event.preventDefault();
                var url = $(this).data('url');

                Swal.fire({
                    title: "Are you sure?",
                    text: "Delete thie Data!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                table.ajax.reload();
                                toastr.success(response.message);
                            },
                            error: function(response) {
                                toastr.error('Delete failed!');
                            }

                        });
                    }
                });


            });


        });
    </script>
@endpush
