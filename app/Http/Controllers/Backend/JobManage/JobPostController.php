<?php

namespace App\Http\Controllers\Backend\JobManage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\JobPostManage\JobPostStoreRequest;
use App\Http\Requests\Backend\JobPostManage\JobPostUpdateRequest;
use App\Models\Country;
use App\Models\JobPost;
use App\Services\JobPostService;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;

class JobPostController extends Controller
{
    
    protected $jobPostService;

    public function __construct(JobPostService $jobPostService)
    {
        $this->jobPostService = $jobPostService;
    }


    public function index()
    {
        
        
        $jobPosts = $this->jobPostService->getAllJobs();
        return view('admin.backend.jobmanage.index', compact('jobPosts'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('admin.backend.jobmanage.create', compact('countries'));
    }

    public function store(JobPostStoreRequest $request)
    {

        
        $lastJobPost = JobPost::latest('id')->first();
        $nextId = $lastJobPost ? $lastJobPost->id + 1 : 1;

        // $jobCode = 'JB -' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
        $jobCode = 'JB -' . date('Y') . '-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $job_img_name = null;
        if ($request->hasFile('job_image')) {
            $job_img_file = $request->file('job_image');
            $job_img_name = uniqid() . '_' . time() . '.' . $job_img_file->getClientOriginalExtension();
            $job_img_file->move(public_path('/upload/job_images'), $job_img_name);
        }

        if (($request->male_count + $request->female_count) != $request->total_count) {
            return back()->withErrors([
                'total_count' => 'Total Count must equal Male Count + Female Count'
            ]);
        }

        $jobData = [
            'job_code' => $jobCode,
            'country_id' => $request->country_id,
            'company_name' => $request->company_name,
            'title' => $request->title,
            'male_count' => $request->male_count,
            'female_count' => $request->female_count,
            'total_count' => $request->total_count,
            'age_limit' => $request->age_limit,
            'salary' => $request->salary,
            'deposit_fee' => $request->deposit_fee,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'status' => $request->status,
            'job_image' => $job_img_name,

        ];
        $jobData = $this->jobPostService->create($jobData);
        return redirect()->route('jobmanage.index')
            ->with([
                'message' => 'Successfully created',
                'alert-type' => 'success'
            ]);
    }

    public function jobDataTable(Request $request)
    {
        return $this->jobPostService->jobDataTable($request);
    }

    public function edit($id)
    {
        $jobPost = JobPost::findOrFail($id);
        $countries = Country::all();
        return view('admin.backend.jobmanage.edit', compact('jobPost','countries'));
    }

    public function update(JobPostUpdateRequest $request, $id)
    {
        $jobPost = $this->jobPostService->find($id);
       
        $jobData = [
            'country_id' => $request->country_id,
            'company_name' => $request->company_name,
            'title' => $request->title,
            'male_count' => $request->male_count,
            'female_count' => $request->female_count,
            'total_count' => $request->total_count,
            'age_limit' => $request->age_limit,
            'salary' => $request->salary,
            'deposit_fee' => $request->deposit_fee,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'status' => $request->status,

        ];


        if ($request->hasFile('job_image')) {
            if ($jobPost->job_image && file_exists(public_path('upload/job_images/' . $jobPost->job_image))) {
                unlink(public_path('upload/job_images/' . $jobPost->job_image));
            }

            $job_img_file = $request->file('job_image');
            $job_img_name = uniqid() . '_' . time() . '.' . $job_img_file->getClientOriginalExtension();
            $job_img_file->move(public_path('/upload/job_images'), $job_img_name);

            $jobData['job_image'] = $job_img_name;
        }
        $jobPost = $this->jobPostService->update($id, $jobData);

        return redirect()->route('jobmanage.index')
            ->with('message', 'Successfully updated')
            ->with('alert-type', 'success');
    }

    public function destroy($id)
    {
        try {
            $this->jobPostService->delete($id);

            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
