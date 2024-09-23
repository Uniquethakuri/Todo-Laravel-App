<?php

namespace App\Repositories;

use App\Models\Todo;

class TodoRepository implements TodoRepositoryInterface
{
    public function all($userId = null)
    {
        if ($userId === null) {
            return Todo::all();
        }
        return Todo::where('user_id', $userId)->get();
    }

    public function find($id)
    {
        return Todo::findOrFail($id);
    }

    public function create($userId, array $data)
    {
        return Todo::create([
            'user_id' => $userId,
            'title' => $data['title'],
            'description' => $data['description'],
            'completed' => $data['completed'] ?? false,
        ]);
    }

    public function update($id, array $data)
    {
        $todo = $this->find($id);
        $todo->update($data);
        return $todo;
    }

    public function delete($id)
    {
        $todo = $this->find($id);
        return $todo->delete();
    }
}
