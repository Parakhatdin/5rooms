<?php

require __DIR__.'/../vendor/autoload.php';

use App\Service\RoomService;

$roomService = new RoomService();
$d = new \App\DTO\RoomDTO();
$d->setNumber("5");
$roomService->store($d);
//$roomService->store($d);
//var_dump($roomService->getById(2)?->toArray());
