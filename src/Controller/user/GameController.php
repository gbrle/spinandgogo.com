<?php

namespace App\Controller\user;

use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route("/user/all_games", name="user_all_games")
     */
    public function all_games(RoomRepository $roomRepository)
    {
        $rooms = $roomRepository->findAll();

        return $this->render('user/all_games.html.twig', [
            'rooms' => $rooms,
        ]);
    }
}
