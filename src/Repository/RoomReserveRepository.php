<?php

namespace App\Repository;

use App\DTO\RoomReserveDTO;
use DateTime;

interface RoomReserveRepository extends Repository
{
    public function store(RoomReserveDTO $dto);
    public function getLastReserve(int $room_id): ?RoomReserveDTO;
    public function getBetweenDate(int $room_id, DateTime $begin_date): ?RoomReserveDTO;
}