@extends('layouts.app')
@section('content')
    <div class="content pb-0">
        <div class="mb-4">
            <h4 class="mb-1">Countries</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('countrymanage.index')}}">Countries</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Country</li>
                </ol>
            </nav>
        </div>


        <div class="row justify-content-center">

            <div class="col-lg-12 md-12">
                <div class="card border-0 rounded-0">

                    <div class="card-header">
                        <h5 class="card-title">Country Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('countrymanage.store') }}" method="POST" id="submit-form"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fs-14">Enter Name</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="ti ti-user"></i></div>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="">

                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fs-14">Enter Code</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="ti ti-flag-check"></i></div>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror"
                                        name="code" placeholder="">
                                    @error('code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            

                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="mb-2">
                                        <label for="validationDefault02" class="form-label">Flag Photo:</label>
                                        <input type="file" class="form-control" name="flag" id="flag_image">
                                    </div>

                                    <div class="mb-2">
                                        <label for="validationDefault02" class="form-label"></label>
                                        <img id="showImage"
                                            src="{{ !empty($country_data->flag) ? asset('upload/flag_images/' . $country_data->flag) : asset('upload/no_image.jpg') }}"
                                            class="img-thumbnail mb-2" style="width:70px;height:70px;object-fit:cover;"
                                            alt="image profile">
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
    {!! JsValidator::formRequest('App\Http\Requests\Backend\CountryManage\CountryStoreRequest', '#submit-form') !!}

    <script type="text/javascript">
        $(document).ready(function() {
            $('#flag_image').on('change', function() {
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
        });
    </script>
@endpush
