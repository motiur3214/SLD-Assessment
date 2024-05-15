<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use App\Traits\FileUploadTrait;

class UserController extends Controller
{
    use FileUploadTrait;

    public function index(): View
    {
        $users = User::with('filemanager')->paginate(10);
        return view('users.index', ['users' => $users]);
    }
    public function trashedUsers(): View
    {
        $users = User::with('filemanager')->onlyTrashed()->paginate(10);

        return view('users.trashed-users', ['users' => $users]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(CreateUserRequest $request)
    {

        $validatedData = $request->validated();
        $photo = $request->photo;
        unset($validatedData['photo']);

        try {
            $user = User::create($validatedData);
            if ($photo && $user->id) {
                $this->FileUpload($photo, User::class, $user->id, 'user');
            }
            $request->session()->flash('success', 'User created successfully!');
            return redirect()->route('users.index');
        } catch (\Exception $errors) {
            $request->session()->flash('error', 'An error occurred while creating the user. Please try again.');
            return back()->withInput()->with('errors');
        }
    }


    public function edit(User $user) // Replace User with your actual model
    {
        return view('users.edit', compact('user')); // Replace 'users.edit' with your view name
    }

    public function update(UpdateUserRequest $request, User $user) // Replace User with your actual model
    {
        $validatedData = $request->validated();
        $photo = $request->photo;
        unset($validatedData['photo']);
        try {
            $isUpdated = $user->update($validatedData);
            if ($photo && $isUpdated) {
                $this->FileUpdate($photo, User::class, $user->id, 'user');
            }
            $request->session()->flash('success', 'User Updated successfully!');
            return redirect()->route('users.show', $user->id); // Replace 'users.show' with your route name
        } catch (\Exception $errors) {
            $request->session()->flash('error', 'An error occurred while creating the user. Please try again.');
            return back()->with('errors');
        }
    }

    public function destroy(User $user) // Replace User with your actual model
    {
        $user->delete();

        return redirect()->route('users.index'); // Replace 'users.index' with your route name
    }


    public function show($id): View
    {
        $user = User::with('filemanager')->find($id);
        return view('users.show', ['user' => $user]);
    }
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.index')->with('success', 'User restored successfully!');
    }
    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if ($user->trashed()) {
            $user->forceDelete(); // Permanently delete the user after confirmation
            return redirect()->route('users.index')->with('success', 'User deleted permanently!');
        } else {
            return redirect()->back()->with('error', 'User cannot be permanently deleted unless marked for deletion first!');
        }
    }

}
