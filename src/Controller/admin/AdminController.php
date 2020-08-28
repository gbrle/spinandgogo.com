<?php

namespace App\Controller\admin;

use App\Entity\Room;
use App\Form\RoomType;
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
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/admin/users", name="admin_users")
     */
    public function adminUsers()
    {
        return $this->render('admin/adminUsers.html.twig');
    }

    /**
     * @Route("/admin/newsletter", name="admin_newsletter")
     */
    public function adminNewsLetter()
    {
        return $this->render('admin/adminNewsletter.html.twig');
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

            return $this->redirectToRoute('admin_home');
        }

        return $this->render('admin/adminAddRoomIndex.html.twig',[
            'formRoom' => $formRoom->createView(),
            'rooms' => $this->roomService->getAllRooms(),
        ]);
    }
}
