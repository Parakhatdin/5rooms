<?php

require __DIR__.'/../vendor/autoload.php';

use App\Service\RoomService;

$roomService = new RoomService();
$result = $roomService->checkAndReserve(1, new DateTime("now"), new DateTime("2022-10-27 20:00"), "nuratdinov.p@gmail.com");
if ($result) {
    echo "reserved!";
} else {
    $reservingInDate = $roomService->getReservingInDate(1, new DateTime("now"));
    print_r($reservingInDate->toArray());
}
