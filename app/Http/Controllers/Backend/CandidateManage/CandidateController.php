<?php

namespace App\Http\Controllers\Backend\CandidateManage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CandidateManage\CandidateStoreRequest;
use App\Http\Requests\Backend\CandidateManage\CandidateUpdateRequest;
use App\Models\Candidate;
use App\Models\JobPost;
use App\Models\JobPostCandidate;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        $query = Candidate::withCount('jobPostCandidates');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('full_name', 'like', "%$s%")
                    ->orWhere('phone', 'like', "%$s%")
                    ->orWhere('nrc_number', 'like', "%$s%")
                    ->orWhere('passport_number', 'like', "%$s%");
            });
        }

        if ($request->filled('job_post_id')) {
            $query->whereHas('jobPostCandidates', fn($q) => $q->where('job_post_id', $request->job_post_id));
        }

        if ($request->filled('status')) {
            $query->whereHas('jobPostCandidates', fn($q) => $q->where('status', $request->status));
        }

        $candidates = Candidate::all();
        $jobPosts = JobPost::orderBy('title')->get();

        return view('admin.backend.candidatemanage.index', compact('candidates', 'jobPosts'));
    }

    public function create()
    {
        $jobPosts = JobPost::where('status', 'open')->get();
        return view('admin.backend.candidatemanage.create', compact('jobPosts'));
    }

    public function store(CandidateStoreRequest $request)
    {

        $lastCandidate = Candidate::latest('id')->first();
        $nextId = $lastCandidate ? $lastCandidate->id + 1 : 1;

        $laborNo = 'LB -' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $nrc_front_img_name = null;
        if ($request->hasFile('nrc_front_path')) {
            $nrc_front_img_file = $request->file('nrc_front_path');
            $nrc_front_img_name = uniqid() . '_' . time() . '.' . $nrc_front_img_file->getClientOriginalExtension();
            $nrc_front_img_file->move(public_path('upload/candidates/'), $nrc_front_img_name);
        }
        $nrc_back_img_name = null;
        if ($request->hasFile('nrc_back_path')) {
            $nrc_back_img_file = $request->file('nrc_back_path');
            $nrc_back_img_name = uniqid() . '_' . time() . '.' . $nrc_back_img_file->getClientOriginalExtension();
            $nrc_back_img_file->move(public_path('upload/candidates/'), $nrc_back_img_name);
        }

        $passport_img_name = null;
        if ($request->hasFile('passport_path')) {
            $passport_file = $request->file('passport_path');
            $passport_img_name = uniqid() . '_' . time() . '.' . $passport_file->getClientOriginalExtension();
            $passport_file->move(public_path('upload/candidates/'), $passport_img_name);
        }


        $photo_name = null;
        if ($request->hasFile('photo_path')) {
            $photo_file = $request->file('photo_path');
            $photo_name = uniqid() . '_' . time() . '.' . $photo_file->getClientOriginalExtension();
            $photo_file->move(public_path('upload/candidates/'), $photo_name);
        }



        if ($request->date_of_birth) {
            $age = \Carbon\Carbon::parse($request->date_of_birth)->age;
        }


        $candidate = Candidate::create([
            'labor_no' => $laborNo,
            'full_name'       => $request->full_name,
            'phone'           => $request->phone,
            'nrc_number'      => $request->nrc_number,
            'passport_number' => $request->passport_number,
            'date_of_birth'   => $request->date_of_birth,
            'age'             => $age,
            'gender'          => $request->gender,
            'address'         => $request->address,
            'notes'           => $request->notes,
            'nrc_front_path'       => $nrc_front_img_name,
            'nrc_back_path'        => $nrc_back_img_name,
            'passport_path'    => $passport_img_name,
            'photo_path'           => $photo_name,
            'job_post_id'    => $request->job_post_id,
            'status' => $request->status,
        ]);



        // Assign to job order if provided
        if ($request->filled('job_post_id')) {
            JobPostCandidate::create([
                'candidate_id' => $candidate->id,
                'job_post_id' => $request->job_post_id,
                'status'       => 'pending_payment',
                'applied_online' => false,
            ]);
        }

        return redirect()->route('candidatemanage.show', $candidate)
            ->with('success', 'Candidate added. / လျှောက်ထားသူ ထည့်သွင်းပြီးပါပြီ။');
    }

    public function show($id)
    {
        $candidate = Candidate::findOrFail($id);
        // $candidate->load(['jobPostCandidates.jobPost']);
        return view('admin.backend.candidatemanage.show', compact('candidate'));
    }

    public function edit($id)
    {
        $candidate = Candidate::findOrFail($id);
        $jobPosts = JobPost::where('status', 'open')->get();
        return view('admin.backend.candidatemanage.edit', compact('candidate', 'jobPosts'));
    }

    public function update(CandidateUpdateRequest $request, $id)
    {

        $candidate = Candidate::find($id);

        if ($request->hasFile('nrc_front_path')) {
            if ($candidate->nrc_front_path && file_exists(public_path('upload/candidates/' . $candidate->nrc_front_path))) {
                unlink(public_path('upload/candidates/' . $candidate->nrc_front_path));
            }

            $nrc_front_img_file = $request->file('nrc_front_path');
            $nrc_front_img_name = uniqid() . '_' . time() . '.' . $nrc_front_img_file->getClientOriginalExtension();
            $nrc_front_img_file->move(public_path('/upload/candidates'), $nrc_front_img_name);

            $candidate_data['nrc_front_path'] = $nrc_front_img_name;
        }


        if ($request->hasFile('nrc_back_path')) {
            if ($candidate->nrc_back_path && file_exists(public_path('upload/candidates/' . $candidate->nrc_back_path))) {
                unlink(public_path('upload/candidates/' . $candidate->nrc_back_path));
            }

            $nrc_back_img_file = $request->file('nrc_front_path');
            $nrc_back_img_name = uniqid() . '_' . time() . '.' . $nrc_back_img_file->getClientOriginalExtension();
            $nrc_back_img_file->move(public_path('/upload/candidates'), $nrc_back_img_name);

            $candidate_data['nrc_front_path'] = $nrc_back_img_name;
        }


        if ($request->hasFile('passport_path')) {
            if ($candidate->passport_path && file_exists(public_path('upload/candidates/' . $candidate->passport_path))) {
                unlink(public_path('upload/candidates/' . $candidate->passport_path));
            }

            $passport_file = $request->file('passport_path');
            $passport_img_name = uniqid() . '_' . time() . '.' . $passport_file->getClientOriginalExtension();
            $passport_file->move(public_path('/upload/candidates'), $passport_img_name);

            $candidate_data['passport_path'] = $passport_img_name;
        }


        if ($request->hasFile('photo_path')) {
            if ($candidate->photo_path && file_exists(public_path('upload/candidates/' . $candidate->photo_path))) {
                unlink(public_path('upload/candidates/' . $candidate->passport_path));
            }

            $photo_file = $request->file('photo_path');
            $photo_name = uniqid() . '_' . time() . '.' . $photo_file->getClientOriginalExtension();
            $photo_file->move(public_path('/upload/candidates'), $photo_name);

            $candidate_data['passport_path'] = $photo_name;
        }

        if ($request->date_of_birth) {
            $age = \Carbon\Carbon::parse($request->date_of_birth)->age;
        }

        $candidate->update([

            'full_name'       => $request->full_name,
            'phone'           => $request->phone,
            'nrc_number'      => $request->nrc_number,
            'passport_number' => $request->passport_number,
            'date_of_birth'   => $request->date_of_birth,
            'age'             => $age,
            'gender'          => $request->gender,
            'address'         => $request->address,
            'notes'           => $request->notes,
            'job_post_id'    => $request->job_post_id,
            'status' => $request->status,
        ]);

        return redirect()->route('candidatemanage.show', $candidate)
            ->with('success', 'Candidate updated. / ပြင်ဆင်ပြီးပါပြီ။');
    }

    public function destroy(Candidate $candidate)
    {
        $candidate->delete();
        return redirect()->route('candidates.index')
            ->with('success', 'Candidate deleted. / ဖျက်ပြီးပါပြီ။');
    }

    // Assign existing candidate to a job order
    public function assign(Request $request, Candidate $candidate)
    {
        $request->validate([
            'job_post_id' => 'required|exists:job_posts,id',
        ]);

        $exists = JobPostCandidate::where('candidate_id', $candidate->id)
            ->where('job_post_id', $request->job_post_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Candidate already assigned to this job order.');
        }

        JobPostCandidate::create([
            'candidate_id' => $candidate->id,
            'job_post_id' => $request->job_post_id,
            'status'       => 'pending_payment',
            'applied_online' => false,
        ]);

        return back()->with('success', 'Candidate assigned to job order.');
    }

    public function updateStatus(Request $request, JobPostCandidate $jobPostCandidate)
    {
        $request->validate([
            'status' => 'required|in:pending_payment,payment_submitted,deposit_verified,qualified,rejected,waiting_list,confirmed',
            'rejection_reason' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $jobPostCandidate->update($request->only('status', 'rejection_reason', 'notes'));

        // Auto-close job order if quota is filled
        $jobPost = $jobPostCandidate->jobPost;
        if ($jobPost->isQuotaFilled()) {
            $jobPost->update(['status' => 'closed']);
        }

        return back()->with('success', 'Status updated. / အခြေအနေ ပြောင်းလဲပြီးပါပြီ။');
    }

    public function exportCsv(Request $request)
    {
        $query = Candidate::with(['jobPostCandidates.jobPost']);

        if ($request->filled('job_post_id')) {
            $query->whereHas('jobPostCandidates', fn($q) => $q->where('job_post_id', $request->job_post_id));
        }

        $candidates = $query->get();
        $query = Candidate::with('jobPosts');
        $filename = 'candidates-' . date('Ymd') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($candidates) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['#', 'Full Name', 'Phone', 'NRC', 'Passport', 'Gender', 'Age']);
            foreach ($candidates as $i => $c) {
                fputcsv($file, [
                    $i + 1,
                    $c->full_name,
                    $c->phone,
                    $c->nrc_number,
                    $c->passport_number,
                    $c->gender,
                    $c->age,
                    $c->jobPosts->pluck('title')->join(', ')
                ]);
                
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
