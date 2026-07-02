@extends('layouts.app')
@section('content')
    <div class="content pb-0">
        <div class="mb-4">
            <h4 class="mb-1">Job Posts</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('jobmanage.index') }}">Job Posts</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Job Posts</li>
                </ol>
            </nav>
        </div>


        <div class="row justify-content-center">

            <div class="col-lg-12 md-12">
                <div class="card border-0 rounded-0">

                    <div class="card-header">
                        <h5 class="card-title">Jobs Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('jobmanage.store') }}" method="POST" id="submit-form"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label class="col-sm-2 form-label">
                                    Country:
                                </label>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <select name="country_id" class="form-control form-select">
                                            <option value="">Select Coutnry</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">
                                                    {{ $country->name }} 
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-sm-2 form-label">
                                    Company Name:
                                </label>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="company_name"
                                            placeholder="Enter Company Name" required>
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-sm-2 form-label">
                                    Job Title:
                                </label>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="title"
                                            placeholder="Enter Job Title" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">

                                <!-- Male Count -->
                                <div class="col-md-4">
                                    <div class="row mb-3">
                                        <label class="col-sm-6 form-label">Male Count:</label>

                                        <div class="col-sm-6">
                                            <div class="input-group">
                                                <button type="button" class="btn btn-outline-primary"
                                                    id="m_minus">-</button>

                                                <input type="number" class="form-control text-center" id="male_count"
                                                    name="male_count" value="0" min="0">

                                                <button type="button" class="btn btn-outline-primary"
                                                    id="m_plus">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Female Count -->
                                <div class="col-md-4">
                                    <div class="row mb-3">
                                        <label class="col-sm-4 form-label">Female Count:</label>

                                        <div class="col sm-4">
                                            <div class="input-group">
                                                <button type="button" class="btn btn-outline-primary"
                                                    id="f_minus">-</button>

                                                <input type="number" class="form-control text-center" id="female_count"
                                                    name="female_count" value="0" min="0">

                                                <button type="button" class="btn btn-outline-primary"
                                                    id="f_plus">+</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>


                            <div class="row mb-3">
                                <label class="col-sm-2 form-label">
                                    Required Workers:
                                </label>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="total_count" value="0"
                                            readonly id="total_count">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 form-label">
                                    Age Limit:
                                </label>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="age_limit" placeholder="Age Limit">
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-sm-2 form-label">
                                    Salary:
                                </label>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="salary" placeholder="Salary">
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-sm-2 form-label">
                                    Deposit Fees:
                                </label>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="deposit_fee"
                                            placeholder="Deposit" value="0">
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-sm-2 form-label">
                                    Deadline:
                                </label>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="deadline">
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-sm-2 form-label">
                                    Status:
                                </label>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <select name="status" class="form-control select2">
                                            <option value="">Select Status</option>
                                            <option value='open'> Open</option>
                                            <option value='closed'> Closed</option>
                                            <option value='paused'> Paused</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 form-label">
                                    Required Documents:
                                </label>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="job_image" id="job_image">
                                    </div>
                                    {{-- <div class="py-1">
                                        <label for="validationDefault02" class="form-label"></label>
                                        <img id="showImage"
                                            src="{{ !empty($job_data->job_image) ? asset('upload/job_images/' . $job_data->job_image) : asset('upload/no_image.jpg') }}"
                                            class="img-thumbnail mb-2" style="width:70px;height:70px;object-fit:cover;"
                                            alt="image country">
                                    </div> --}}
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-sm-2 form-label">
                                    Description:
                                </label>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <textarea name="description" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>


                            <br>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>




    </div>
@endsection
@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\Backend\JobPostManage\JobPostStoreRequest', '#submit-form') !!}
    <script>
        $('.select2').select2({
            width: '100%'
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#job_image').on('change', function() {
                if (this.files && this.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('#showImage')
                            .attr('src', e.target.result)
                            .show();
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });





            document.getElementById('m_plus').onclick = function() {
                let input = document.getElementById('male_count');
                input.value = parseInt(input.value || 0) + 1;
                updateTotalCount();
            };

            document.getElementById('m_minus').onclick = function() {
                let input = document.getElementById('male_count');
                if (parseInt(input.value || 0) > 0) {
                    input.value = parseInt(input.value) - 1;

                }
                updateTotalCount();
            };

            document.getElementById('male_count').addEventListener('input', function() {
                updateTotalCount();
            });


            document.getElementById('f_plus').onclick = function() {
                const input = document.getElementById('female_count');
                input.value = parseInt(input.value || 0) + 1;
                updateTotalCount();
            };

            document.getElementById('f_minus').onclick = function() {
                const input = document.getElementById('female_count');
                if (parseInt(input.value || 0) > 0) {
                    input.value = parseInt(input.value) - 1;
                }
                updateTotalCount();
            };

            document.getElementById('female_count').addEventListener('input', function() {
                updateTotalCount();
            });

            function updateTotalCount() {
                let male_count = parseInt(document.getElementById('male_count').value) || 0;
                let female_count = parseInt(document.getElementById('female_count').value) || 0;

                document.getElementById('total_count').value =
                    male_count + female_count;
            }






        });
    </script>
@endpush
