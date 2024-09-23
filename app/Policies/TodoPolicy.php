<?php

namespace App\Policies;
use App\Models\User;
use App\Models\Todo;

class TodoPolicy
{
    public function viewAny(?User $user): bool
    {
        return true; // Allow anyone to view the list of todos
    }

    public function view(?User $user, Todo $todo): bool
    {
        return true; // Allow anyone to view individual todos
    }

    public function create(User $user): bool
    {
        return true; // Assuming all authenticated users can create todos
    }

    public function update(User $user, Todo $todo): bool
    {
        return $user->id === $todo->user_id;
    }

    public function delete(User $user, Todo $todo): bool
    {
        return $user->id === $todo->user_id;
    }
}
