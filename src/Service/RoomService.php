<?php

namespace App\Service;

use App\DTO\RoomDTO;
use App\DTO\RoomReserveDTO;
use App\Repository\RepositoryPDOImpl\RoomRepository;
use App\Repository\RepositoryPDOImpl\RoomReserveRepository;
use DateTime;

class RoomService
{
    protected RoomRepository $roomRepository;
    protected RoomReserveRepository $roomReserveRepository;

    public function __construct() {
        $this->roomRepository = new RoomRepository();
        $this->roomReserveRepository = new RoomReserveRepository();
    }
    public function getAll()
    {
        return $this->roomRepository->get(5, 0, "number", true);
    }

    public function checkAndReserve(int $room_number, DateTime $begin_date, DateTime $end_date, string $user_email): bool
    {
        $reservingInDate = $this->getReservingInDate($room_number, $begin_date);
        if ($reservingInDate) {
            return false;
        }
        $this->reserve($room_number, $begin_date, $end_date, $user_email);
        return true;
    }

    public function getReservingInDate(int $room_number, DateTime $date)
    {
        $room = $this->roomRepository->findByRoomNumber($room_number);
        if (!$room) {
            throw new \RuntimeException("room with number: $room_number not found");
        }
        $lastReserve = $this->roomReserveRepository->getLastReserve($room->getId());
        if (!$lastReserve) {
            return null;
        }
        if ($lastReserve->getEndDate() < $date) {
            return null;
        }
        return $lastReserve;
    }

    private function reserve(int $room_number, DateTime $begin_date, DateTime $end_date, string $email)
    {
        try {
            $room = $this->roomRepository->findByRoomNumber($room_number);
            $roomReserveDTO = new RoomReserveDTO();
            $roomReserveDTO->setRoom($room);
            $roomReserveDTO->setOwnerEmail($email);
            $roomReserveDTO->setBeginDate($begin_date);
            $roomReserveDTO->setEndDate($end_date);
            $this->roomReserveRepository->store($roomReserveDTO);
        } catch (\RuntimeException $exception) {
            exit($exception->getMessage());
        }
    }
}