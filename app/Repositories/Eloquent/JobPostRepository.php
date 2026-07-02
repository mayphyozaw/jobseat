<?php

namespace App\Repositories\Eloquent;

use App\Models\Country;
use App\Models\JobPost;
use App\Repositories\Interfaces\JobPostRepoInterface;

class JobPostRepository implements JobPostRepoInterface
{

    public function __construct(JobPost $jobPost)
    {
        $this->model = $jobPost;
    }

    public function findAll()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $record = $this->model->find($id);
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->model->find($id);
        return $record->delete();
    }

    public function query()
    {
        return $this->model
            ->select([
                'id',
                'job_code',
                'country_id',
                'company_name',
                'title',
                'male_count',
                'female_count',
                'total_count',
                'age_limit',
                'salary',
                'deposit_fee',
                'description',
                'deadline',
                'status',
                'job_image',
            ]);
    }
}
