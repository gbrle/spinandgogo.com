<?php

namespace App\Controller\admin;

use App\Entity\BuyIn;
use App\Entity\Multiplicator;
use App\Entity\Ranked;
use App\Entity\Room;
use App\Form\BuyInType;
use App\Form\MultiplicatorType;
use App\Form\RoomType;
use App\Repository\BuyInRepository;
use App\Repository\RankedRepository;
use App\Repository\RoomRepository;
use App\Repository\UserRepository;
use App\Service\RoomService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
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
    public function adminUsers(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        return $this->render('admin/adminUsers.html.twig',[
            'allRooms' => $this->roomService->getAllRooms(),
            'users' => $users,
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


        if(file_exists($this->getTargetDir(). '/' . $room->getLogo())) {
            unlink($this->getTargetDir() . '/' .$room->getLogo());

            $manager->remove($room);
            $manager->flush();
        }
        

        $this->addFlash('success', 'La salle a bien été suprimée');


        return $this->redirectToRoute('admin_home');

    }


    /**
     * @Route("/admin/deleteBuyIn/{id}", name="admin_delete_BuyIn")
     */
    public function adminDeleteBuyIn($id, Request $request, BuyIn $buyIn, EntityManagerInterface $manager)
    {
        $room = $buyIn->getRoom();

        $manager->remove($buyIn);
        $manager->flush();


        $this->addFlash('success', 'Le buy in a bien été suprimé');


        return $this->redirect('/admin/room/'. $room->getId()
        );
    }

    /**
     * @Route("/admin/room/{id}", name="admin_room")
     */
    public function adminRoom($id, Request $request, RoomRepository $roomRepository, EntityManagerInterface $manager, Session $session)
    {
        $currentRoom = $roomRepository->find($id);

        $buyInsRoom = $currentRoom->getBuyIn();

        $session->set('rooms', $buyInsRoom);

        // Form New Buy In
        $buyIn = new BuyIn();
        $buyIn->setRoom($currentRoom);
        $formBuyIn = $this->createForm(BuyInType::class, $buyIn);

        $formBuyIn->handleRequest($request);
        if ($formBuyIn->isSubmitted() && $formBuyIn->isValid()) {

            $buyIn = $formBuyIn->getData();

            $manager->persist($buyIn);
            $manager->flush();

            $this->addFlash('success', 'Le Buy In a bien été ajouté');

            return $this->redirect('/admin/room/'. $currentRoom->getId());
        }
        // End New Buy In



        return $this->render('admin/adminRoom.html.twig',[
            'allRooms' => $this->roomService->getAllRooms(),
            'room' => $currentRoom,
            'buyInsRoom' => $buyInsRoom,
            'formBuyIn' => $formBuyIn->createView(),
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


            $image = $formRoom->get('logo')->getData();


            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = mt_rand(1, 9999999999);;
            $newFilename = $safeFilename.'.'.$image->guessExtension();

            $image->move(
                $this->getParameter('uploads_logo_dir'),
                $newFilename
            );

            $room->setLogo($newFilename);

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

    /**
     * @Route("/admin/addMultiplicatorForOneBuyIn/{id}", name="add_multiplicator_for_one_buy_in")
     */
    public function adminAddMultiplicatorForOneBuyIn($id, Request $request, BuyInRepository $buyInRepository, EntityManagerInterface $manager)
    {
        $buyIn = $buyInRepository->find($id);
        $multiplicatorValue = $request->getContent();

        $multiplicator = new Multiplicator();
        $multiplicator->setBuyIn($buyIn);
        $multiplicator->setValue($multiplicatorValue);

        $manager->persist($multiplicator);

        // I add 3 rankeds with value "0"
        for ($i=1; $i<4; $i++) {

            $ranked = new Ranked();
            $ranked->setMultiplicator($multiplicator);
            $ranked->setPosition($i);
            $ranked->setPrice(0);

            $manager->persist($ranked);
        }

        $manager->flush();



        $this->addFlash('success', 'Le multiplicateur a bien été ajouté');


        return $this->json($buyIn->getRoom()->getId());
    }


    /**
     * @Route("/admin/addPrice", name="add_price")
     */
    public function adminAddPrice(Request $request, RankedRepository $rankedRepository, EntityManagerInterface $manager)
    {

        $rankedValue = json_decode($request->getContent());

        $ranked1 = $rankedRepository->findOneBy(['id' => $rankedValue[0]]);
        $ranked2 = $rankedRepository->findOneBy(['id' => $rankedValue[0]+1]);
        $ranked3 = $rankedRepository->findOneBy(['id' => $rankedValue[0]+2]);




        $ranked1->setPrice($rankedValue[1]);
        $ranked2->setPrice($rankedValue[2]);
        $ranked3->setPrice($rankedValue[3]);

        $manager->persist($ranked1);
        $manager->persist($ranked2);
        $manager->persist($ranked3);

        $manager->flush();



        $this->addFlash('success', 'Les prix ont bien été ajoutés');


        return $this->json($rankedValue[0]);
    }


    private function getTargetDir()
    {
        return $this->getParameter('uploads_logo_dir');
    }
}
