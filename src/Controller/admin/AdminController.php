<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
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
    public function adminAddRoom()
    {
        return $this->render('admin/adminAddRoomIndex.html.twig');
    }
}
