<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UxTurboFrameController extends AbstractController
{
    /**
     * @Route(path="/ux-turbo-frame", name="ux_turbo_frame")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        sleep(1); // Pending to show page loader

        return $this->render('pages/ux_turbo_frame.html.twig');
    }

    /**
     * @Cache(public=false, maxage="0")
     *
     * @return Response
     */
    public function privateFrame(): Response
    {
        return $this->render('pages/ux_turbo_frame_private.html.twig');
    }

    /**
     * @Cache(public=true, maxage="3600")
     *
     * @return Response
     */
    public function publicFrame(): Response
    {
        return $this->render('pages/ux_turbo_frame_public.html.twig');
    }

    /**
     * @Route(path="/ux-turbo-frame-1", name="ux_turbo_frame_1")
     *
     * @return Response
     */
    public function frame1(): Response
    {
        sleep(1); // Pending to show frame lazy loading

        return $this->render('pages/ux_turbo_frame_1.html.twig');
    }

    /**
     * @Route(path="/ux-turbo-frame-2", name="ux_turbo_frame_2")
     *
     * @return Response
     */
    public function frame2(): Response
    {
        return $this->render('pages/ux_turbo_frame_2.html.twig');
    }
}
