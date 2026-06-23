<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepoInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class UserService
{
    protected $userRepoInterface;

    public function __construct(UserRepoInterface $userRepoInterface)
    {
        $this->userRepoInterface = $userRepoInterface;
    }

    public function getAllUsers()
    {
        return $this->userRepoInterface->findAll();
    }

    public function create(array $data)
    {
        $record = $this->userRepoInterface->create($data);
        return $record;
    }

    public function find($id)
    {
        return $this->userRepoInterface->find($id);
    }

    public function update($id, array $data)
    {
        
        $record = $this->userRepoInterface->update($data, $id);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->userRepoInterface->find($id);
        $record->delete();
    }

    public function userDataTable($request)
    {
        $currentUserId = Auth::id();

        $query = $this->userRepoInterface->query();

        return DataTables::of($query)
            ->addIndexColumn()
           
            
            ->editColumn('photo', function ($user) {
                return '<img src="' . $user->acsrImagePath  . '" alt=""  class="rounded" width="50">';
            })
            
            // ->editColumn('status', function ($user) {
            //     return '<span style="color: #' . $user->acsrStatus['color'] . '">' . $user->acsrStatus['text'] . '</span>';
            // })
            ->editColumn('status', function ($user) use ($currentUserId) {
                if ($user->id === $currentUserId) {
                    return '<span class="badge badge-soft-success">Active</span>';
                }

                return '<span class="badge badge-soft-danger">Inactive</span>';
            })
            ->addColumn('action', function ($user) {
                return view('admin.backend.usermanage._action', compact('user'))->render();
            })
            ->rawColumns([
                
                'photo',
                'status',
                'action',
               
            ])
            ->make(true);
    }

}


