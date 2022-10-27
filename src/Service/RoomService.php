<?php

namespace App\Service;

use App\DTO\RoomDTO;
use App\Repository\RepositoryPDOImpl\RoomRepository;

class RoomService
{
    protected $roomRepository;

    public function __construct() {
        $this->roomRepository = new RoomRepository();
    }
    public function store(RoomDTO $DTO)
    {
        $this->roomRepository->store($DTO);
    }

    public function checkAndReserve(int $room_id, string $date, string $user_email)
    {

    }

    private function checkRoomForEmpty(int $room_id, string $date)
    {
        $roomDTO = $this->roomRepository->find($room_id);

    }
}