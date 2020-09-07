<?php

namespace App\Controller\user;

use App\Repository\RoomRepository;
use Doctrine\Common\Annotations\AnnotationReader;
use http\Client\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
