<?php

namespace App\Repository\RepositoryPDOImpl;

use App\DTO\RoomDTO;
use App\Repository\RoomRepository as RoomRepositoryInterface;

class RoomRepository extends BaseRepository implements RoomRepositoryInterface
{
    protected $tableName = "rooms";

    public function find(int $id): ?RoomDTO
    {
        $result = parent::find($id);
        if (count($result) > 0) {
            return $this->transferToDTO($result[0]);
        }
        return null;
    }

    public function getAll(): ?array
    {
        $result = parent::all();
        if (count($result) > 0) {
            $toDTO = [];
            foreach ($result as $item) {
                $toDTO[] = $this->transferToDTO($item);
            }
            return $toDTO;
        }
        return null;
    }

    public function store(RoomDTO $dto)
    {
        parent::insert(["number" => $dto->getNumber()]);
    }

    private function transferToDTO(array $data): RoomDTO
    {
        $result = new RoomDTO();
        if (array_key_exists("id", $data)) {
            $result->setId($data["id"]);
        }
        if (array_key_exists("number", $data)) {
            $result->setNumber($data["number"]);
        }
        return $result;
    }
}