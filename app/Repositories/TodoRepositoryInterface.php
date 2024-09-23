<?php

namespace App\Repositories;

interface TodoRepositoryInterface
{
    public function all($userId = null);
    public function find($id);
    public function create($userId, array $data);
    public function update($id, array $data);
    public function delete($id);
}
