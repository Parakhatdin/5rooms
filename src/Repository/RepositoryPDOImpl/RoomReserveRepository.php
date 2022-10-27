<?php

namespace App\Repository\RepositoryPDOImpl;

use App\DTO\RoomReserveDTO;
use App\Repository\RoomReserveRepository as RoomReserveRepositoryInterface;
use DateTime;

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
            "room_id" => $dto->getRoom()->getId(),
            "begin_date" => $dto->getBeginDate()->format("Y-m-d H:i:s"),
            "end_date" => $dto->getEndDate()->format("Y-m-d H:i:s"),
            "owner_email" => $dto->getOwnerEmail()
        ]);
    }

    protected function transferToDTO(array $data): RoomReserveDTO
    {
        $roomRepository = new RoomRepository();
        $result = new RoomReserveDTO();
        if (array_key_exists("id", $data)) {
            $result->setId($data["id"]);
        }
        if (array_key_exists("begin_date", $data)) {
            $result->setBeginDate(new DateTime($data["begin_date"]));
        }
        if (array_key_exists("end_date", $data)) {
            $result->setEndDate(new DateTime($data["end_date"]));
        }
        if (array_key_exists("owner_email", $data)) {
            $result->setOwnerEmail($data["owner_email"]);
        }
        if (array_key_exists("room_id", $data)) {
            $result->setRoom($roomRepository->find($data["room_id"]));
        }
        return $result;
    }

    public function getLastReserve($room_id): ?RoomReserveDTO
    {
        return parent::where("room_id", "=", $room_id)->first("begin_date", false);
    }
}