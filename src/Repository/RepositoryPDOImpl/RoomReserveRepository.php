<?php

namespace App\Repository\RepositoryPDOImpl;

use App\DTO\RoomDTO;
use App\DTO\RoomReserveDTO;
use App\Repository\RoomReserveRepository as RoomReserveRepositoryInterface;

class RoomReserveRepository extends BaseRepository implements RoomReserveRepositoryInterface
{
    protected $tableName = "room_reserves";

    public function find(int $id): ?RoomReserveDTO
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

    public function store(RoomReserveDTO $dto)
    {
        parent::insert([
            "begin_date" => $dto->getBeginDate(),
            "end_date" => $dto->getEndDate(),
            "owner_email" => $dto->getOwnerEmail()
        ]);
    }

    private function transferToDTO(array $data): RoomReserveDTO
    {
        $result = new RoomReserveDTO();
        if (array_key_exists("id", $data)) {
            $result->setId($data["id"]);
        }
        if (array_key_exists("begin_date", $data)) {
            $result->setBeginDate($data["begin_date"]);
        }
        if (array_key_exists("end_date", $data)) {
            $result->setEndDate($data["end_date"]);
        }
        if (array_key_exists("owner_email", $data)) {
            $result->setOwnerEmail($data["owner_email"]);
        }
        return $result;
    }

    public function getLastReserve($room_id): ?RoomReserveDTO
    {
        parent::all(5,0, "");
    }
}