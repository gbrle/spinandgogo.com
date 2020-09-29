<?php

namespace App\Controller\user;

use App\Repository\GameRepository;
use App\Repository\RoomRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route("/user/all_games", name="user_all_games")
     */
    public function all_games(Request $request, RoomRepository $roomRepository, GameRepository $gameRepository, PaginatorInterface $paginator)
    {
        $rooms = $roomRepository->findAll();

        $datas = $gameRepository->findBy(
            ['user' => $this->getUser()],
            ['id' => 'DESC']
        );

        $allGames = $paginator->paginate(
            $datas, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10 // Nombre de résultats par page
        );




        return $this->render('user/all_games.html.twig', [
            'rooms' => $rooms,
            'allGames' => $allGames,
        ]);
    }
}
