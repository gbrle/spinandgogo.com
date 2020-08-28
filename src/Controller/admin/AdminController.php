<?php

namespace App\Controller\admin;

use App\Entity\Multiplicator;
use App\Entity\Room;
use App\Form\MultiplicatorType;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use App\Service\RoomService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    /**
     * @Route("/admin", name="admin_home")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig',[
            'allRooms' => $this->roomService->getAllRooms(),
        ]);
    }

    /**
     * @Route("/admin/users", name="admin_users")
     */
    public function adminUsers()
    {
        return $this->render('admin/adminUsers.html.twig',[
            'allRooms' => $this->roomService->getAllRooms(),
        ]);
    }

    /**
     * @Route("/admin/newsletter", name="admin_newsletter")
     */
    public function adminNewsLetter()
    {
        return $this->render('admin/adminNewsletter.html.twig', [
            'allRooms' => $this->roomService->getAllRooms(),
        ]);
    }


    /**
     * @Route("/admin/deleteRoom/{id}", name="admin_delete_room")
     */
    public function adminDeleteRoom($id, Request $request, Room $room, EntityManagerInterface $manager)
    {
        $manager->remove($room);
        $manager->flush();


        $this->addFlash('success', 'La salle a bien été suprimée');


        return $this->redirectToRoute('admin_home');

    }

    /**
     * @Route("/admin/deleteMultiplicator/{id}", name="admin_delete_multiplicator")
     */
    public function adminDeleteMultiplicator($id, Request $request, Multiplicator $multiplicator, EntityManagerInterface $manager)
    {
        $room = $multiplicator->getRoom();

        $manager->remove($multiplicator);
        $manager->flush();


        $this->addFlash('success', 'Le multiplicateur a bien été suprimé');


        return $this->redirect('/admin/room/'. $room->getId()
    );

    }

    /**
     * @Route("/admin/room/{id}", name="admin_room")
     */
    public function adminRoom($id, Request $request, RoomRepository $roomRepository, EntityManagerInterface $manager)
    {
        $currentRoom = $roomRepository->find($id);
        $multicatorsRoom = $currentRoom->getMultiplicators();

        // Form New Multiplicator
        $multiplicator = new Multiplicator();
        $multiplicator->setRoom($currentRoom);
        $formMultiplicator = $this->createForm(MultiplicatorType::class, $multiplicator);

        $formMultiplicator->handleRequest($request);
        if ($formMultiplicator->isSubmitted() && $formMultiplicator->isValid()) {

            $multiplicator = $formMultiplicator->getData();

            $manager->persist($multiplicator);
            $manager->flush();

            $this->addFlash('success', 'Le multiplicateur a bien été ajouté');

            return $this->redirect('/admin/room/'. $currentRoom->getId());
        }

        return $this->render('admin/adminRoom.html.twig',[
            'allRooms' => $this->roomService->getAllRooms(),
            'room' => $currentRoom,
            'multiplicators' => $multicatorsRoom,
            'formMultiplicator' => $formMultiplicator->createView(),
        ]);
    }

    /**
     * @Route("/admin/addRoomIndex", name="admin_add_room_index")
     */
    public function adminAddRoom(Request $request, EntityManagerInterface $manager)
    {

        $room = new Room();
        $formRoom = $this->createForm(RoomType::class, $room);

        $formRoom->handleRequest($request);
        if ($formRoom->isSubmitted() && $formRoom->isValid()) {

            $room = $formRoom->getData();

            $manager->persist($room);
            $manager->flush();

            $this->addFlash('success', 'La salle a bien été ajoutée');


            return $this->redirect('/admin/room/'. $room->getId());
        }

        return $this->render('admin/adminAddRoomIndex.html.twig',[
            'formRoom' => $formRoom->createView(),
            'allRooms' => $this->roomService->getAllRooms(),
        ]);
    }
}
