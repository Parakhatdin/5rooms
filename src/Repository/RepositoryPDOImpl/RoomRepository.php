<?php

namespace App\Repository\RepositoryPDOImpl;

use App\DTO\RoomDTO;
use App\Repository\RoomRepository as RoomRepositoryInterface;

class RoomRepository extends BaseRepository implements RoomRepositoryInterface
{
    protected $tableName = "rooms";

    public function store(RoomDTO $dto)
    {
        parent::insert(["number" => $dto->getNumber()]);
    }

    public function findByRoomNumber(int $room_number): ?RoomDTO
    {
        return parent::where("number", "=", $room_number)->first();
    }

    protected function transferToDTO(array $data): RoomDTO
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