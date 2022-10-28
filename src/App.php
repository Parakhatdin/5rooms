<?php

namespace App;

use App\Service\RoomService;
use DateTime;

class App
{
    protected RoomService $roomService;

    public function __construct() {
        $this->roomService = new RoomService();
    }


    public function run()
    {
        $roomNumber = $this->askRoomNumber();
        $beginDate = $this->askDate();
        $endDate = $this->askDate();
        $email = $this->askEmail();

        try {
            $result = $this->roomService->checkAndReserve($roomNumber, $beginDate, $endDate, $email);
            if ($result) {
                echo "reserved! room_number: $roomNumber";
            } else {
                $reservingInDate = $this->roomService->getReservingInDate($roomNumber, $beginDate, $endDate);
                $reserverEmail = $reservingInDate->getOwnerEmail();
                $reserverEndDate = $reservingInDate->getEndDate()->format("Y-m-d H:i:s");
                echo "sorry :(. This room already reserved by $reserverEmail until $reserverEndDate";
            }
        } catch (\Throwable $exception) {
            exit("App error: " . $exception->getMessage());
        }
    }

    private function askRoomNumber(): int
    {
        $rooms = $this->roomService->getAll();
        if (!$rooms) {
            exit("No rooms :(");
        }
        $rooms = array_map(function ($room){
            return $room->getNumber();
        }, $rooms);

        $roomsLine = implode(",", $rooms);
        $selectedRoomNumber = (int) readline("Please select room number from list $roomsLine: ");
        if (!in_array($selectedRoomNumber, $rooms)) {
            exit("Room not found :(");
        }
        return $selectedRoomNumber;
    }

    private function askDate(): DateTime
    {
        $date = (string) readline("Please enter begin datetime in format 2022-12-31 23:59: ");
        $date = DateTime::createFromFormat("Y-m-d H:i", $date);
        if (!$date) {
            exit("Datetime not match to format 2022-12-31 23:59 :(");
        }
        return $date;
    }

    private function askEmail(): string
    {
        $email = (string) readline("Please enter your email: ");
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            exit("It is not email :(");
        }
        return $email;
    }
}