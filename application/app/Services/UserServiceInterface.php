<?php

namespace App\Services;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;

interface UserServiceInterface
{
    public function store(CreateUserRequest $data): User;
    public function update(array $data, int $userId): User;

    public function storeRule(CreateUserRequest $request): CreateUserRequest;

    public function updateRule(UpdateUserRequest $request): array;

    public function hash(string $password): string;
}
