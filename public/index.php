<?php

require __DIR__.'/../vendor/autoload.php';

use App\Service\RoomService;

$roomService = new RoomService();
$rooms = $roomService->getAll();
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

$beginDate = (string) readline("Please enter begin datetime in format 2022-12-31 23:59: ");
$beginDate = DateTime::createFromFormat("Y-m-d H:i", $beginDate);
if (!$beginDate) {
    exit("Datetime not match to format 2022-12-31 23:59 :(");
}

$endDate = (string) readline("Please enter end datetime in format 2022-12-31 23:59: ");
$endDate = DateTime::createFromFormat("Y-m-d H:i", $endDate);
if (!$endDate) {
    exit("Datetime not match to format 2022-12-31 23:59 :(");
}

$email = (string) readline("Please enter your email: ");
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("It is not email :(");
}

$result = $roomService->checkAndReserve($selectedRoomNumber, $beginDate, $endDate, $email);
if ($result) {
    echo "reserved!";
} else {
    $reservingInDate = $roomService->getReservingInDate(1, new DateTime("now"));
    print_r($reservingInDate->toArray());
}
