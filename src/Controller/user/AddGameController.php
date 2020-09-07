<?php

namespace App\Controller\user;

use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AddGameController extends AbstractController
{
    /**
     * @Route("/user/user_add_game", name="user_add_game")
     */
    public function all_games(RoomRepository $roomRepository)
    {
        $rooms = $roomRepository->findAll();

        return $this->render('user/add_game.html.twig', [
            'rooms' => $rooms,
        ]);
    }
}
