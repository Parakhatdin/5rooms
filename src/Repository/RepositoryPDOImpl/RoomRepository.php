<?php

namespace App\Repository\RepositoryPDOImpl;

use App\DTO\RoomDTO;
use App\Repository\RoomRepository as RoomRepositoryInterface;

class RoomRepository extends BaseRepository implements RoomRepositoryInterface
{
    protected ?string $tableName = "rooms";

    public function findByRoomNumber(int $room_number): ?RoomDTO
    {
        /** @var RoomDTO $result */
        $result = $this->where("number", "=", $room_number)->first();
        return $result;
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