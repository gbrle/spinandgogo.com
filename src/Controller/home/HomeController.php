<?php

namespace App\Controller\home;

use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(RoomRepository $roomRepository)
    {
        $rooms = $roomRepository->findAll();

        return $this->render('home/index.html.twig', [
            'rooms' => $rooms,
        ]);
    }

//    /**
//     * @Route("/", name="home")
//     */
//    public function startSAGG()
//    {
//
//        return $this->render('home/homeStart.html.twig', [
//
//        ]);
//    }
}
