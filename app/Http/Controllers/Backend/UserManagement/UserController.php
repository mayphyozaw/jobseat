<?php

namespace App\Http\Controllers\Backend\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UserManage\UserStoreRequest;
use App\Http\Requests\Backend\UserManage\UserUpdateRequest;
use App\Models\User;
use App\Services\ResponseService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function index()
    {
        $users = $this->userService->getAllUsers();
        return view('admin.backend.usermanage.index', compact('users'));
    }

    public function create()
    {
        return view('admin.backend.usermanage.create');
    }

    public function store(UserStoreRequest $request)
    {


        $user_img_name = null;
        if ($request->hasFile('photo')) {
            $user_img_file = $request->file('photo');
            $user_img_name = uniqid() . '_' . time() . '.' . $user_img_file->getClientOriginalExtension();
            $user_img_file->move(public_path('/upload/user_images'), $user_img_name);
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'photo' => $user_img_name,
            'status' => 'active',


        ];
        $user = $this->userService->create($userData);
        // $user->assignRole($request->role);

        return redirect()->route('usermanage.index')
            ->with([
                'message' => 'Successfully created',
                'alert-type' => 'success'
            ]);
    }

    public function userDataTable(Request $request)
    {
        return $this->userService->userDataTable($request);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.backend.usermanage.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->userService->find($id);
        $user_data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => $request->status ?? 'active',

        ];
        if ($request->filled('password')) {
            $user_data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo && file_exists(public_path('upload/user_images/' . $user->photo))) {
                unlink(public_path('upload/user_images/' . $user->photo));
            }

            $user_img_file = $request->file('photo');
            $user_img_name = uniqid() . '_' . time() . '.' . $user_img_file->getClientOriginalExtension();
            $user_img_file->move(public_path('/upload/user_images'), $user_img_name);

            $user_data['photo'] = $user_img_name;
        }
        $user = $this->userService->update($id, $user_data);

        return redirect()->route('usermanage.index')
            ->with('message', 'Successfully updated')
            ->with('alert-type', 'success');
    }

    public function destroy($id)
    {
        try {
            $this->userService->delete($id);

            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
