<?php

namespace App\Service;

use App\Repository\RoomRepository;

class RoomService
{
    private $rooms;

    public function __construct(RoomRepository $roomRepository)
    {
        $this->rooms = $roomRepository->findAll();
    }


    public function getAllRooms()
    {
        return $this->rooms;
    }
}