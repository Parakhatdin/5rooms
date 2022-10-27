<?php

namespace App\Repository;

use App\DTO\RoomDTO;

interface RoomRepository extends Repository
{
    public function findByRoomNumber(int $room_number): ?RoomDTO;
}