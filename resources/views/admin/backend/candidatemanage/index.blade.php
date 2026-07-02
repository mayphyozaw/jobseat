@extends('layouts.app')
@section('title', 'Candidates')
@section('page-title', 'Candidates / လျှောက်ထားသူများ')

@section('content')
    <div class="content pb-0">
        <div class="mb-4">
            <h4 class="mb-1">Candidate Lists<span class="badge badge-soft-primary ms-2">{{ $candidates->count() }}</span>
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Candidate Lists</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3 ">
            <div></div>
            <div class="d-flex gap-2">
                <a href="{{ route('candidates.export') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}"
                    class="btn btn-outline-success btn-sm">
                    <i class="bi bi-download me-1"></i>Export CSV
                </a>
                <a href="{{ route('candidatemanage.create') }}" class="btn btn-primary">
                    <i class="bi bi-person-plus-fill me-1"></i>Add Candidate
                    <span class="myanmar">/ ထည့်သွင်း</span>
                </a>
            </div>
        </div>

        {{-- Search & Filter --}}
        <div class="card mb-3">
            <div class="card-body py-2">
                <form class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="Name, Phone, NRC, Passport..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="job_order_id" class="form-select form-select-sm">
                            <option value="">All Job Orders</option>
                            @foreach ($jobPosts as $jo)
                                <option value="{{ $jo->id }}"
                                    {{ request('job_post_id') == $jo->id ? 'selected' : '' }}>
                                    {{ $jo->job_post_id }} — {{ $jo->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="col-md-2">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">All Status</option>
                            @foreach (['pending_payment', 'deposit_verified', 'qualified', 'rejected', 'waiting_list', 'confirmed'] as $s)
                                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $s)) }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="col-md-3 d-flex gap-2">
                        <button class="btn btn-sm btn-primary flex-grow-1">
                            <i class="bi bi-search me-1"></i>
                            Search
                        </button>
                        <a href="{{ route('candidatemanage.index') }}" class="btn btn-sm btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Candidate No</th>
                            <th>Name / အမည်</th>
                            <th>Phone</th>
                            <th>NRC</th>
                            <th>Passport</th>
                            <th>Gender</th>
                            <th>Job Category</th>
                            <th>Applications</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidates as $c)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $c->labor_no }}</td>
                                <td>
                                    <a href="{{ route('candidatemanage.show', $c) }}"
                                        class="fw-medium text-decoration-none">
                                        {{ $c->full_name }}
                                    </a>
                                    @if ($c->age)
                                        <span class="text-muted ms-1" style="font-size:.75rem;">Age
                                            {{ $c->age }}</span>
                                    @endif
                                </td>
                                <td style="font-size:.875rem;">{{ $c->phone }}</td>
                                <td style="font-size:.8rem;" class="text-muted">{{ $c->nrc_number ?? '—' }}</td>
                                <td style="font-size:.8rem;" class="text-muted">{{ $c->passport_number ?? '—' }}</td>
                                <td>
                                    @if ($c->gender)
                                        <span
                                            class="badge bg-{{ $c->gender === 'male' ? 'primary' : 'danger' }}-subtle
                                        text-{{ $c->gender === 'male' ? 'primary' : 'danger' }}">
                                            {{ ucfirst($c->gender) }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @forelse($c->jobPosts as $job)
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                            {{ $job->title }}
                                        </span>
                                    @empty
                                        <span class="text-muted">No Job</span>
                                    @endforelse
                                </td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                        {{ $c->applications_count }} jobs
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('candidatemanage.show', $c->id) }}" class="btn btn-sm btn-info">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <a href="{{ route('candidatemanage.edit', $c->id) }}" class="btn btn-sm btn-secondary">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('candidatemanage.destroy', $c) }}"
                                            onsubmit="return confirm('Delete this candidate?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-person-x fs-2 d-block mb-2"></i>
                                    No candidates found. <span class="myanmar">/ လျှောက်ထားသူများ မရှိသေးပါ</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- @if ($candidates->hasPages())
                <div class="card-footer">{{ $candidates->links() }}</div>
            @endif --}}
        </div>
    </div>
@endsection
