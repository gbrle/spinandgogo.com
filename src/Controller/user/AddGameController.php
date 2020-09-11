<?php

namespace App\Controller\user;

use App\Entity\Game;
use App\Repository\BuyInRepository;
use App\Repository\GameRepository;
use App\Repository\MultiplicatorRepository;
use App\Repository\RankedRepository;
use App\Repository\RoomRepository;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

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

    /**
     * @Route("/user/user_get_buy_in", name="user_get_buy_in")
     */
    public function get_room(Request $request, RoomRepository $roomRepository, SerializerInterface  $serializer)
    {

        $id_room = $request->getContent();


        $room = $roomRepository->findOneBy([
            'id' => $id_room,
        ]);

        $json = $serializer->serialize(
            $room->getBuyIn(),
            'json',
            ['groups' => 'buy_in']
        );

        return new \Symfony\Component\HttpFoundation\Response($json);


    }

    /**
     * @Route("/user/user_get_multiplicator", name="user_get_multiplicator")
     */
    public function get_multiplicator(Request $request, BuyInRepository $buyInRepository, SerializerInterface  $serializer)
    {

        $idBuyIn = $request->getContent();


        $buyIn = $buyInRepository->findOneBy([
            'id' => $idBuyIn,
        ]);

        $json = $serializer->serialize(
            $buyIn->getMultiplicators(),
            'json',
            ['groups' => 'multiplicator']
        );

        return new \Symfony\Component\HttpFoundation\Response($json);


    }

    /**
     * @Route("/user/user_get_ranked", name="user_get_ranked")
     */
    public function get_ranked(Request $request, MultiplicatorRepository $multiplicatorRepository, SerializerInterface  $serializer)
    {

        $idMultiplicator = $request->getContent();


        $multiplicator = $multiplicatorRepository->findOneBy([
            'id' => $idMultiplicator,
        ]);

        $json = $serializer->serialize(
            $multiplicator->getRankeds(),
            'json',
            ['groups' => 'ranked']
        );

        return new \Symfony\Component\HttpFoundation\Response($json);


    }

    /**
     * @Route("/user/user_create_game", name="user_create_game")
     */
    public function create_game(Request $request, RankedRepository $rankedRepository, EntityManagerInterface $manager)
    {
        $idRanked = $request->getContent();


        $ranked = $rankedRepository->findOneBy([
            'id' => $idRanked,
        ]);


        $game = new Game();
        $game->setUser($this->getUser());
        $game->setRoom($ranked->getMultiplicator()->getBuyIn()->getRoom());
        $game->setBuyIn($ranked->getMultiplicator()->getBuyIn()->getValue());
        $game->setMultiplicator($ranked->getMultiplicator()->getValue());
        $game->setPlace($ranked->getPosition());
        $game->setPrice($rankedRepository->find($idRanked)->getPrice());
        $game->setCreatedAt(new \DateTime('now'));

        $manager->persist($game);
        $manager->flush();


        return new \Symfony\Component\HttpFoundation\Response('super');


    }


    /**
     * @Route("/user/user_get_games_for_chart", name="user_get_games_for_chart")
     */
    public function get_games_for_chart(Request $request, GameRepository $gameRepository)
    {
        $nbreGame = [];
        $bankroll = [];

        $games = $gameRepository->findBy([
            'user' => $this->getUser(),
        ]);


        $startGame = 0;
        foreach ($games as $game){
            array_push($nbreGame, $startGame + 1);
            $startGame += 1;
        }
        $startBankroll = 0;
        foreach ($games as $game){
            array_push($bankroll, $startBankroll + ($game->getPrice() - $game->getBuyIn()));
            $startBankroll = $startBankroll + ($game->getPrice() - $game->getBuyIn());
        }

        $brankroolFinale = 0;
        $totalBuy = 0;
        foreach ($games as $game){
            $totalBuy = $totalBuy + $game->getBuyIn();
            $brankroolFinale = $brankroolFinale + ($game->getPrice() - $game->getBuyIn());
        }
        $roi = ($brankroolFinale - $totalBuy) / $totalBuy;

        if ($request->isXMLHttpRequest()) {
            return new JsonResponse(([json_encode($nbreGame), json_encode($bankroll), round($roi, 1)]));
        }


        return new Response('Error 400', 400);
    }
}
