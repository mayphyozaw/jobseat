@extends('layouts.app')
@section('content')
    <div class="content pb-0">
        <div class="mb-4">
            <h4 class="mb-1">Users</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                </ol>
            </nav>
        </div>


        <div class="row justify-content-center">

            <div class="col-lg-12 md-12">
                <div class="card border-0 rounded-0">

                    <div class="card-header">
                        <h5 class="card-title">Personal Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('usermanage.update', $user->id) }}" method="POST" id="submit-form"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label fs-14">Enter Name</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="ti ti-user"></i></div>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{$user->name}}">

                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fs-14">Enter Email</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="ti ti-mail"></i></div>
                                    <input type="email" class="form-control"
                                        name="email" value="{{ $user->email }}">

                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fs-14">Enter Password</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="ti ti-lock"></i></div>
                                    <input type="password" class="form-control" name="password">

                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fs-14">Enter Phone</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="ti ti-phone-call"></i></div>
                                    <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address:</label>
                                <textarea name="address" class="form-control">
                                    {{ $user->address }}
                                </textarea>
                            </div>

                            {{-- <div class="row">
                                
                                <div class="col-lg-4 col-md-12">
                                    <div class="mb-3">
                                        <label for="validationDefault01" class="form-label"> Roles & Designations </label>
                                        <select class="form-select" name="role" id="example-select">
                                            <option value="" selected>Select Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"> {{ $role->name }} </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div> --}}


                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="mb-2">
                                        <label for="validationDefault02" class="form-label">Profile Photo:</label>
                                        <input type="file" class="form-control" name="photo" id="user_image">
                                    </div>

                                    <div class="mb-2">
                                        <label for="validationDefault02" class="form-label"></label>
                                        <img id="showImage"
                                            src="{{ !empty($user->photo) ? asset('upload/user_images/' . $user->photo) : asset('upload/no_image.jpg') }}"
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
    {!! JsValidator::formRequest('App\Http\Requests\Backend\UserManage\UserUpdateRequest', '#submit-form') !!}

    <script type="text/javascript">
        $(document).ready(function() {
            $('#user_image').on('change', function() {
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
