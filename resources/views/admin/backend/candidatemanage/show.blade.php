@extends('layouts.app')
@section('title', $candidate->full_name)
@section('page-title', $candidate->full_name)

@section('content')
    <div class="row g-3">

        {{-- ─── Profile Card ─── --}}
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body text-center pb-2">

                    

                    @if ($candidate->photo_path)
                        <img src="{{ asset('upload/candidates/' . $candidate->photo_path) }}" class="rounded-circle mb-2"
                            style="width:80px;height:80px;object-fit:cover;">
                    @else
                        <div class="mx-auto mb-2 rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                            style="width:80px;height:80px;">
                            <i class="bi bi-person-fill text-primary fs-2"></i>
                        </div>
                    @endif
                    <h5 class="mb-0">{{ $candidate->full_name }}</h5>
                    <div class="text-muted" style="font-size:.85rem;">{{ $candidate->phone }}</div>
                    @if ($candidate->gender)
                        <span
                            class="badge bg-{{ $candidate->gender === 'male' ? 'primary' : 'danger' }}-subtle
                        text-{{ $candidate->gender === 'male' ? 'primary' : 'danger' }} mt-1">
                            {{ ucfirst($candidate->gender) }}
                        </span>
                    @endif
                </div>
                <hr class="my-0">
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <th class="text-muted" style="font-size:.78rem;width:40%">NRC</th>
                            <td style="font-size:.85rem;">{{ $candidate->nrc_number ?? '—' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted" style="font-size:.78rem;">Passport</th>
                            <td style="font-size:.85rem;">{{ $candidate->passport_number ?? '—' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted" style="font-size:.78rem;">DOB</th>
                            <td style="font-size:.85rem;">{{ $candidate->date_of_birth?->format('d M Y') ?? '—' }}</td>
                        </tr>

                        <tr>
                            <th class="text-muted" style="font-size:.78rem;">Age</th>
                            <td style="font-size:.85rem;">{{ $candidate->age ?? '—' }}</td>
                        </tr>

                        @if ($candidate->address)
                            <tr>
                                <th class="text-muted" style="font-size:.78rem;">Address</th>
                                <td style="font-size:.85rem;">{{ $candidate->address }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

            {{-- Documents --}}
            <div class="card mb-3">
                <div class="card-header"><i class="bi bi-file-image me-2"></i>Documents</div>
                <div class="card-body">
                    <div class="row g-2">

                        @foreach ([
            'nrc_front_path' => 'NRC Front',
            'nrc_back_path' => 'NRC Back',
            'passport_path' => 'Passport',
            'photo_path' => 'Photo',
        ] as $field => $label)
                            <div class="col-4 text-center">
                                @if ($candidate->$field)
                                    <a href="{{ asset('upload/candidates/' . $candidate->$field) }}" target="_blank">
                                        <img src="{{ asset('upload/candidates/' . $candidate->$field) }}"
                                            class="img-thumbnail" style="height:60px;object-fit:cover;">
                                    </a>
                                    <div class="text-muted mt-1" style="font-size:.7rem;">{{ $label }}</div>
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                        style="height:60px;">
                                        <i class="bi bi-file-x text-muted"></i>
                                    </div>
                                    <div class="text-muted mt-1" style="font-size:.7rem;">{{ $label }}</div>
                                @endif
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>

            {{-- <div class="d-flex gap-2">
                <a href="{{ route('candidatemanage.edit', $candidate->id) }}" class="btn btn-outline-primary btn-sm flex-grow-1">
                    <i class="bi bi-pencil me-1"></i>
                    Edit
                </a>
                <form method="POST" action="{{ route('candidatemanage.destroy', $candidate->id) }}"
                    onsubmit="return confirm('Delete this candidate?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                </form>
            </div> --}}
        </div>

        {{-- ─── Applications & History ─── --}}
        <div class="col-lg-8">

            {{-- Assign to Job Order --}}
            {{-- <div class="card mb-3" hidden>
                <div class="card-header"><i class="bi bi-briefcase me-2"></i>Assign to Job Order / အလုပ်ခေါ်စာသို့
                    သတ်မှတ်ရန်</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('candidates.assign', $candidate) }}" class="d-flex gap-2">
                        @csrf
                        <select name="job_order_id" class="form-select form-select-sm flex-grow-1" required>
                            <option value="">Select Job Order / အလုပ်ခေါ်စာ ရွေးချယ်ပါ</option>
                            @foreach (\App\Models\JobOrder::where('status', 'open')->get() as $jo)
                                <option value="{{ $jo->id }}">
                                    {{ $jo->order_id }} — {{ $jo->job_title }} ({{ $jo->country }})
                                    [{{ $jo->remainingQuota() }} left]
                                </option>
                            @endforeach
                        </select>
                        <button class="btn btn-sm btn-primary">Assign</button>
                    </form>
                </div>
            </div> --}}

            {{-- Application History --}}
            {{-- <div class="card mb-3" hidden>
                <div class="card-header"><i class="bi bi-clock-history me-2"></i>Application History / လျှောက်ထားမှု
                    မှတ်တမ်း</div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Job Order</th>
                                <th>Country</th>
                                <th>Status</th>
                                <th>Deposit</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($candidate->applications as $app)
                                <tr>
                                    <td>
                                        <a href="{{ route('job-orders.show', $app->jobOrder) }}"
                                            class="text-decoration-none fw-medium">
                                            {{ $app->jobOrder->job_title }}
                                        </a>
                                        <div class="text-muted" style="font-size:.75rem;">{{ $app->jobOrder->order_id }}
                                        </div>
                                    </td>
                                    <td style="font-size:.85rem;">{{ $app->jobOrder->country }}</td>
                                    <td>
                                        {!! $app->status_badge !!}
                                        <div class="myanmar mt-1" style="font-size:.7rem;color:#64748b;">
                                            {{ $app->status_myanmar }}</div>
                                    </td>
                                    <td>
                                        @if ($app->deposit)
                                            <a href="{{ route('deposits.show', $app->deposit) }}">
                                                {!! $app->deposit->status_badge !!}
                                            </a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-muted" style="font-size:.8rem;">{{ $app->created_at->format('d M Y') }}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                data-bs-toggle="dropdown">
                                                Update
                                            </button>
                                            <div class="dropdown-menu p-3" style="min-width:250px;">
                                                <form method="POST" action="{{ route('applications.status', $app) }}">
                                                    @csrf @method('PATCH')
                                                    <select name="status" class="form-select form-select-sm mb-2">
                                                        @foreach (['pending_payment', 'payment_submitted', 'deposit_verified', 'qualified', 'rejected', 'waiting_list', 'confirmed'] as $s)
                                                            <option value="{{ $s }}"
                                                                {{ $app->status === $s ? 'selected' : '' }}>
                                                                {{ ucwords(str_replace('_', ' ', $s)) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" name="notes"
                                                        class="form-control form-control-sm mb-2" placeholder="Notes"
                                                        value="{{ $app->notes }}">
                                                    <button class="btn btn-sm btn-primary w-100">Save</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-3 text-muted myanmar">
                                        အလုပ်ခေါ်စာ လျှောက်ထားမှု မရှိသေးပါ
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div> --}}

            {{-- Notes --}}
            @if ($candidate->notes)
                <div class="card">
                    <div class="card-header"><i class="bi bi-chat-text me-2"></i>Notes / မှတ်ချက်</div>
                    <div class="card-body">{{ $candidate->notes }}</div>
                </div>
            @endif
        </div>
    </div>
@endsection
@push('scripts')
    
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
