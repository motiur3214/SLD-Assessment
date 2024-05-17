<?php

namespace App\Services;

use App\Http\Requests\User\CreateUserRequest;

use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Traits\FileUploadTrait;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    use FileUploadTrait;

    public function __construct(private User $user)
    {
    }

    public function list(int $perPage = 10): LengthAwarePaginator
    {
        return $this->user->where('id', '!=', Auth()->id())->paginate($perPage);
    }

    public function listTrashed(int $perPage = 10): LengthAwarePaginator
    {
        return $this->user->onlyTrashed()->paginate($perPage);
    }

    public function restore(int $userId): bool
    {
        $user = $this->user->withTrashed()->findOrFail($userId);
        return $user->restore();

    }

    public function delete(int $userId): bool
    {
        $user = $this->user->withTrashed()->findOrFail($userId);
        if (!$user->trashed()) {
            return false;
        }
        return $user->forceDelete();

    }

    public function destroy(int $userId): bool
    {
        $user = $this->user->find($userId);
        return $user->delete();
    }

    public function find(int $userId): User
    {
        return $this->user->findOrFail($userId);
    }

    public function storeRule(CreateUserRequest $request): CreateUserRequest
    {
        $data = $request->all();
        return $request->validateData($data);

    }

    public function store(CreateUserRequest $data): User
    {
        $photo = $data['photo'];
        unset($data['photo']);
        $data['password'] = $this->hash($data['password']);
        $user = $this->user->create($data);
        if ($photo && $user->id) {
            $this->FileUpload($photo, User::class, $user->id, 'user');
        }
        return $user;
    }

    public function updateRule(UpdateUserRequest $request): array
    {
        return $request->validated();
    }

    public function update(array $data, int $userId): User
    {
        $photo = null;
        if (isset($data['photo'])) {
            $photo = $data['photo'];
            unset($data['photo']);
        }

        $user = $this->user->find($userId);
        if ($user) {

            $user->update($data);
            if ($photo) {
                $this->FileUpdate($photo, User::class, $user->id, 'user');
            }
        }
        return $user;
    }

    public function hash(string $password): string
    {
        return Hash::make($password);
    }
}
