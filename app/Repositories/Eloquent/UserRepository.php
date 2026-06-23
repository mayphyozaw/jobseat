<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserRepoInterface;

class UserRepository implements UserRepoInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
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
                'name',
                'email',
                'phone',
                'address',
                'status',
                'photo',
            ]);
    }
}
