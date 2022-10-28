<?php

namespace App\Repository\RepositoryPDOImpl;

use App\DTO\RoomDTO;
use App\DTO\RoomReserveDTO;
use App\Repository\RoomReserveRepository as RoomReserveRepositoryInterface;
use DateTime;
use Exception;

class RoomReserveRepository extends BaseRepository implements RoomReserveRepositoryInterface
{
    protected ?string $tableName = "room_reserves";

    public function store(RoomReserveDTO $dto)
    {
        $this->insert([
            "room_id" => $dto->getRoom()->getId(),
            "begin_date" => $dto->getBeginDate()->format("Y-m-d H:i:s"),
            "end_date" => $dto->getEndDate()->format("Y-m-d H:i:s"),
            "owner_email" => $dto->getOwnerEmail()
        ]);
    }

    public function getLastReserve($room_id): ?RoomReserveDTO
    {
        /** @var RoomReserveDTO $result */
        $result = $this->where("room_id", "=", $room_id)->first("begin_date", false);
        return $result;
    }

    /**
     * @throws Exception
     */
    public function getBetweenDate(int $room_id, DateTime $begin_date): ?RoomReserveDTO
    {
        /** @var RoomReserveDTO $result */
        $result = $this->where("room_id", "=", $room_id)
            ->andWhere("begin_date", "<", $begin_date->format("Y-m-d H:i:s"))
            ->andWhere("end_date", ">", $begin_date->format("Y-m-d H:i:s"))
            ->first();
        return $result;
    }

    /**
     * @throws Exception
     */
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
            /** @var RoomDTO $roomDTO */
            $roomDTO = $roomRepository->find($data["room_id"]);
            $result->setRoom($roomDTO);
        }
        return $result;
    }
}