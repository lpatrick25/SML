<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserPasswordRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;
use App\Models\User;
use App\Services\UserServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServices $userService, Request $request)
    {
        parent::__construct($request);
        $this->userService = $userService;
    }

    public function index(Request $request): UserCollection
    {
        $validated = $request->validate([
            'email' => 'nullable|email',
            'limit' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
        ]);

        $query = $this->userService->getAllUsers($validated);
        $users = $query->paginate($this->limit, ['*'], 'page', $this->page);

        return new UserCollection($users);
    }

    public function show(User $user): JsonResponse
    {
        return $this->success(new UserResource($user));
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->create($request->validated());
        return $this->success(new UserResource($user), 'User created', 201);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user = $this->userService->update($user->id, $request->validated());
        return $this->success(new UserResource($user), 'User updated');
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return $this->success(null, 'User deleted');
    }

    public function changePassword(UpdateUserPasswordRequest $request, User $user)
    {
        $user = $this->userService->changePassword($user->id, $request->validated());
        return $this->success(new UserResource($user), 'User password updated');
    }

    public function changeStatus(User $user)
    {
        $user = $this->userService->changeStatus($user->id);
        return $this->success(new UserResource($user), 'User status updated');
    }
}
