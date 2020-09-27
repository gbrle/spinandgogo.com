<?php

namespace App\Controller\user;

use App\Entity\Room;
use App\Repository\GameRepository;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user_home")
     */
    public function index(RoomRepository $roomRepository, GameRepository $gameRepository)
    {
        $rooms = $roomRepository->findAll();
        $games = $gameRepository->findBy([
            'user' => $this->getUser(),
        ]);

        return $this->render('user/index.html.twig', [
            'rooms' => $rooms,
            'games' => $games,
        ]);
    }

    /**
     * @Route("/user/stats-by-room/{id}", name="user_stats_by_room")
     */
    public function statsByRoom(Room $room, RoomRepository $roomRepository, GameRepository $gameRepository)
    {
        $rooms = $roomRepository->findAll();
        $games = $gameRepository->findBy([
            'user' => $this->getUser(),
            'room' => $room->getName()
        ]);

        return $this->render('user/statsByRoom.html.twig', [
            'rooms' => $rooms,
            'games' => $games,
            'room' => $room
        ]);
    }
}
