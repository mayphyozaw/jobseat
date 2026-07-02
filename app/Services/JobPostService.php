<?php

namespace App\Services;

use App\Models\JobPost;
use App\Repositories\Interfaces\JobPostRepoInterface;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class JobPostService
{
    protected $jobPostRepoInterface;

    public function __construct(JobPostRepoInterface $jobPostRepoInterface)
    {
        $this->jobPostRepoInterface = $jobPostRepoInterface;
    }

    public function getAllJobs()
    {
        return $this->jobPostRepoInterface->findAll();
    }

    public function create(array $data)
    {
        $record = $this->jobPostRepoInterface->create($data);
        return $record;
    }

    public function find($id)
    {
        return $this->jobPostRepoInterface->find($id);
    }

    public function update($id, array $data)
    {

        $record = $this->jobPostRepoInterface->update($data, $id);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->jobPostRepoInterface->find($id);
        $record->delete();
    }

    public function jobDataTable($request)
    {


        $query = $this->jobPostRepoInterface->query();
        // $query = JobPost::with(['createdBy', 'country'])
        //     ->withCount('job_post_candidates');

        // if ($request->filled('search')) {

        //     $s = $request->search;

        //     $query->where(function ($q) use ($s) {

        //         $q->where('title', 'like', "%{$s}%")
        //             ->orWhere('job_code', 'like', "%{$s}%")
        //             ->orWhere('company_name', 'like', "%{$s}%")
        //             ->orWhereHas('country', function ($country) use ($s) {
        //                 $country->where('name', 'like', "%{$s}%");
        //             });
        //     });
        // }


        return DataTables::of($query)

            ->filterColumn('country', function ($query, $keyword) {
                $query->whereHas('country', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })

            ->addIndexColumn()

            ->editColumn('job_code', function ($jobPost) {
                return $jobPost->job_code;
            })

            ->editColumn('country', function ($jobPost) {

                $class = match ($jobPost->country->name) {
                    'Thailand'  => 'bg-danger',
                    'Malaysia'  => 'bg-warning',
                    'Singapore' => 'bg-secondary',
                    default     => 'bg-success',
                };

                return '<span class="badge ' . $class . '">'
                    . $jobPost->country->name .
                    '</span>';
            })
            ->editColumn('total_count', function ($jobPost) {
                return '<span class="badge bg-primary">' . $jobPost->total_count . '</span>';
            })


            ->editColumn('male_count', function ($jobPost) {
                return '<span class="badge bg-info">' . $jobPost->male_count . '</span>';
            })

            ->editColumn('female_count', function ($jobPost) {
                return '<span class="badge bg-info">' . $jobPost->female_count . '</span>';
            })


            ->editColumn('description', function ($jobPost) {

                $short = Str::limit($jobPost->description, 50);

                return '<span class="short-text">' . $short . '</span>
                            <span class="full-text d-none">' . $jobPost->description . '</span>

                            <a href="javascript:void(0)"
                            class="toggle-description">
                                Show More
                            </a>';
            })

            ->editColumn('job_image', function ($jobPost) {
                return '<img src="' . $jobPost->acsrImagePath  . '" alt=""   width="100">';
            })

            ->editColumn('status', function ($jobPost) {
                return '<span class="badge bg-' . $jobPost->acsrStatus['badge'] . ' text-dark">' .
                    $jobPost->acsrStatus['text'] .
                    '</span>';
            })

            // ->editColumn('status',function($jobPost){

            //     return '<span class="badge bg-' . $jobPost->status . '">' . '</span>';
            //     // return $jobPost->status;
            // })


            ->addColumn('action', function ($jobPost) {
                return view('admin.backend.jobmanage._action', compact('jobPost'))->render();
            })
            ->rawColumns([
                'job_code',
                'country',
                'total_count',
                'male_count',
                'female_count',
                'description',
                'job_image',
                'status',
                'action',

            ])
            ->make(true);
    }
}
