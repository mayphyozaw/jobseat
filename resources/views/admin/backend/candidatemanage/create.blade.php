@extends('layouts.app')
@section('title', isset($candidate) ? 'Edit Candidate' : 'Add Candidate')
@section('page-title', isset($candidate) ? 'Edit Candidate / ပြင်ဆင်ရန်' : 'Add Candidate / ထည့်သွင်း')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <form method="POST" action="{{ route('candidatemanage.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="card mb-3">
                    <div class="card-header"><i class="bi bi-person me-2"></i>Personal Info / ကိုယ်ရေးအချက်အလက်</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Full Name / အမည် <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="full_name"
                                    class="form-control @error('full_name') is-invalid @enderror">
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Phone Number / ဖုန်းနံပါတ် <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">NRC Number / မှတ်ပုံတင်နံပါတ်</label>
                                <input type="text" name="nrc_number"
                                    class="form-control @error('nrc_number') is-invalid @enderror"
                                    placeholder="e.g. 12/OKHANA(N)123456">
                                @error('nrc_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Passport Number / ပတ်စ်ပို့နံပါတ်</label>
                                <input type="text" name="passport_number"
                                    class="form-control @error('passport_number') is-invalid @enderror">
                                @error('passport_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Date of Birth / မွေးသက္ကရာဇ်</label>
                                <input type="date" name="date_of_birth" class="form-control" id="date_of_birth">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-medium">Age / အသက်</label>
                                <input type="text" name="age" class="form-control" id="age" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Gender / ကျား | မ</label>
                                <select name="gender" class="form-control select2">
                                    <option value="">Select / ရွေးချယ်ရန်</option>
                                    <option value="male">Male /ကျား</option>
                                    <option value="female">Female / မ</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-medium">Address / နေရပ်လိပ်စာ</label>
                                <textarea name="address" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-medium">Notes / မှတ်ချက်</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header"><i class="bi bi-file-image me-2"></i>Documents Upload / စာရွက်စာတမ်းများ
                        တင်သွင်းရန်</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">NRC Front / မှတ်ပုံတင် (ရှေ့)</label>
                                <div class="mb-1">
                                    @if (isset($candidate) && $candidate->nrc_front_path)
                                        <div class="mb-1">
                                            <img src="{{ asset('upload/candidates/' . $candidate->nrc_front_path) }}"
                                                class="img-thumbnail" style="max-height:80px;">
                                        </div>
                                    @endif
                                    {{-- <img src="{{ asset('upload/candidates/' . $candidate->nrc_front_path) }}"
                                        class="img-thumbnail" style="max-height:80px;"> --}}

                                </div>

                                <input type="file" name="nrc_front_path" class="form-control" accept="image/*">
                            </div>


                            <div class="col-md-6">
                                <label class="form-label fw-medium">NRC Back / မှတ်ပုံတင် (နောက်)</label>
                                @if (isset($candidate) && $candidate->nrc_back_path)
                                    <div class="mb-1">
                                        <img src="{{ asset('upload/candidates/' . $candidate->nrc_back_path) }}"
                                            class="img-thumbnail" style="max-height:80px;">
                                    </div>
                                @endif
                                <input type="file" name="nrc_back_path" class="form-control" accept="image/*">
                            </div>


                            <div class="col-md-6">
                                <label class="form-label fw-medium">Passport / ပတ်စ်ပို့</label>
                                @if (isset($candidate) && $candidate->passport_path)
                                    <div class="mb-1">
                                        <img src="{{ asset('upload/candidates/' . $candidate->passport_path) }}"
                                            class="img-thumbnail" style="max-height:80px;">
                                    </div>
                                @endif
                                <input type="file" name="passport_path" class="form-control" accept="image/*">
                            </div>


                            <div class="col-md-6">
                                <label class="form-label fw-medium">Photo / ဓာတ်ပုံ</label>
                                @if (isset($candidate) && $candidate->photo_path)
                                    <div class="mb-1">
                                        <img src="{{ asset('upload/candidates/' . $candidate->photo_path) }}"
                                            class="img-thumbnail rounded-circle"
                                            style="max-height:80px;width:80px;object-fit:cover;">
                                    </div>
                                @endif
                                <input type="file" name="photo_path" class="form-control" accept="image/*">
                            </div>


                        </div>
                    </div>
                </div>

                @if (!isset($candidate)) 
                <div class="card mb-3">
                    <div class="card-header"><i class="bi bi-briefcase me-2"></i>Assign to Job Order / အလုပ်ခေါ်စာသို့
                        သတ်မှတ်ရန် (Optional)</div>
                    <div class="card-body">
                        <select name="job_post_id" class="form-control select2">
                            <option value="">— Don't assign yet —</option>
                            @foreach ($jobPosts as $jo)
                                <option value="{{ $jo->id }}"
                                    {{ old('job_post_id') == $jo->id ? 'selected' : '' }}>
                                    {{ $jo->job_post_id }} — {{ $jo->title }} ({{ $jo->country->name }})
                                    [{{ $jo->remainingQuota() }} remaining]
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif

                <div class="d-flex gap-2 m-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check2 me-1"></i>
                         {{ isset($candidate) ? 'Update Candidate' : 'Add Candidate' }}
                    </button>
                    <a href="{{ route('candidatemanage.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('.select2').select2({
            width: '100%'
        });
    </script>
    <script>
        document.getElementById('date_of_birth').addEventListener('change', function() {

            let dob = new Date(this.value);
            let today = new Date();

            let age = today.getFullYear() - dob.getFullYear();

            let monthDiff = today.getMonth() - dob.getMonth();

            if (
                monthDiff < 0 ||
                (monthDiff === 0 && today.getDate() < dob.getDate())
            ) {
                age--;
            }

            document.getElementById('age').value = age;
        });
    </script>
@endpush
