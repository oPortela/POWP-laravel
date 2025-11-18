<?php

namespace App\Repositories\Interfaces;

interface ClienteRepositoryInterface
{
    public function getAll(int $page, int $perPage);
    public function findById(string $id);
    public function create(string $table, array $data);
    public function update(string $table, string $column, string $id, array $data);
    public function delete(string $table, string $column, string $id);
}