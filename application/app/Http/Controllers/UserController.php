<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Models\User;
use App\Services\UserServiceInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct(public UserServiceInterface $userService)
    {
    }

    public function index(): View
    {
        try {
            $perPage = 10;
            $users = $this->userService->list($perPage);
            return view('users.index', ['users' => $users]);
        } catch (\Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
            abort(500, 'An error occurred while fetching users.');
        }
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(CreateUserRequest $request): RedirectResponse
    {
        try {
            $validate_data = $this->userService->storeRule($request);
            $this->userService->store($validate_data);
            $request->session()->flash('success', 'User created successfully!');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            $request->session()->flash('error', 'An error occurred while creating the user. Please try again.');
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, $userId): RedirectResponse
    {
        try {
            $validate_data = $this->userService->updateRule($request);
           $this->userService->update($validate_data, $userId);
            $request->session()->flash('success', 'User updated successfully!');
            return redirect()->route('users.show', $userId);
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            $request->session()->flash('error', 'An error occurred while updating the user. Please try again.');
            return back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function show($id): View
    {
        try {
            $user = $this->userService->find($id);
            return view('users.show', ['user' => $user]);
        } catch (\Exception $e) {
            Log::error('Error fetching user details: ' . $e->getMessage());
            abort(500, 'An error occurred while fetching the user details.');
        }
    }

    public function trashedUsers(): View
    {
        try {
            $perPage = 10;
            $users = $this->userService->listTrashed($perPage);
            return view('users.trashed-users', ['users' => $users]);
        } catch (\Exception $e) {
            Log::error('Error fetching trashed users: ' . $e->getMessage());
            abort(500, 'An error occurred while fetching trashed users.');
        }
    }

    public function restore($userId): RedirectResponse
    {
        try {
            $this->userService->restore($userId);
            return redirect()->route('users.index')->with('success', 'User restored successfully!');
        } catch (\Exception $e) {
            Log::error('Error restoring user: ' . $e->getMessage());
            return redirect()->route('users.index')->with('error', 'An error occurred while restoring the user. Please try again.');
        }
    }

    public function destroy($userId): RedirectResponse
    {
        try {
            $this->userService->destroy($userId);
            return redirect()->route('users.index')->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return redirect()->route('users.index')->with('error', 'An error occurred while deleting the user. Please try again.');
        }
    }

    public function forceDelete($userId): RedirectResponse
    {
        try {
            $status = $this->userService->delete($userId);
            if ($status) {
                return redirect()->route('users.index')->with('success', 'User deleted permanently!');
            } else {
                return redirect()->back()->with('error', 'User cannot be permanently deleted unless marked for deletion first!');
            }
        } catch (\Exception $e) {
            Log::error('Error permanently deleting user: ' . $e->getMessage());
            return redirect()->route('users.index')->with('error', 'An error occurred while permanently deleting the user. Please try again.');
        }
    }
}
