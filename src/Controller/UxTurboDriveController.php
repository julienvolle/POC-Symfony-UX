<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UxTurboDriveController extends AbstractController
{
    /**
     * @Route(path="/ux-turbo-drive-1", name="ux_turbo_drive_1")
     *
     * @return Response
     */
    public function page1(): Response
    {
        return $this->render('pages/ux_turbo_drive_1.html.twig');
    }

    /**
     * @Route(path="/ux-turbo-drive-2", name="ux_turbo_drive_2")
     *
     * @return Response
     */
    public function page2(): Response
    {
        return $this->render('pages/ux_turbo_drive_2.html.twig');
    }
}
