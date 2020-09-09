<?php

namespace App\Controller\user;

use App\Repository\GameRepository;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route("/user/all_games", name="user_all_games")
     */
    public function all_games(RoomRepository $roomRepository, GameRepository $gameRepository)
    {
        $rooms = $roomRepository->findAll();

        $allGames = $gameRepository->findBy([
            'user' => $this->getUser()
        ]);

        return $this->render('user/all_games.html.twig', [
            'rooms' => $rooms,
            'allGames' => $allGames,
        ]);
    }
}
