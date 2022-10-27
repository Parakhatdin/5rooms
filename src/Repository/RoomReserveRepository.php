<?php

namespace App\Repository;

use App\DTO\RoomReserveDTO;

interface RoomReserveRepository extends Repository
{
    public function getLastReserve($room_id): ?RoomReserveDTO;

}