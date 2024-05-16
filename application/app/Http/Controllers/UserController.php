<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use App\Traits\FileUploadTrait;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    use FileUploadTrait;

    public function index(): View
    {
        $users = User::where('id', '!=', Auth()->id())
            ->paginate(10);
        return view('users.index', ['users' => $users]);
    }


    public function create(): View
    {
        return view('users.create');
    }

    public function store(CreateUserRequest $request): RedirectResponse
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


    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
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
            return redirect()->route('users.show', $user->id);
        } catch (\Exception $errors) {
            $request->session()->flash('error', 'An error occurred while creating the user. Please try again.');
            return back()->with('errors');
        }
    }


    public function show($id): View
    {
        $user = User::find($id);
        return view('users.show', ['user' => $user]);
    }

    public function trashedUsers(): View
    {
        $users = User::onlyTrashed()->paginate(10);

        return view('users.trashed-users', ['users' => $users]);
    }

    public function restore($id): RedirectResponse
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.index')->with('success', 'User restored successfully!');
    }

    public function forceDelete($id): RedirectResponse
    {
        $user = User::withTrashed()->findOrFail($id);

        if ($user->trashed()) {
            $user->forceDelete();
            return redirect()->route('users.index')->with('success', 'User deleted permanently!');
        } else {
            return redirect()->back()->with('error', 'User cannot be permanently deleted unless marked for deletion first!');
        }
    }

}


