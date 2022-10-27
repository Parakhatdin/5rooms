<?php

namespace App\Repository;

interface Repository
{
    public function find(int $id);
    public function delete(int $id);
}
