<?php

namespace App\Controller\user;

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
}
