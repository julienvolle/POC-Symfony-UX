<?php

namespace App\Controller;

use App\Repository\BadgeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;

class UxTurboStreamController extends AbstractController
{
    /**
     * @Route(path="/ux-turbo-stream", name="ux_turbo_stream")
     *
     * @param BadgeRepository $badgeRepository
     *
     * @return Response
     */
    public function __invoke(BadgeRepository $badgeRepository): Response
    {
        return $this->render('pages/ux_turbo_stream.html.twig', [
            'badges' => $badgeRepository->findAll(),
            'news'   => [
                'title'   => 'Welcome!',
                'content' => 'Work in progress...',
            ],
        ]);
    }

    /**
     * @Route(path="/ux-turbo-stream-manager", name="ux_turbo_stream_manager")
     *
     * @param Request      $request
     * @param HubInterface $hub
     *
     * @return Response
     */
    public function manager(Request $request, HubInterface $hub): Response
    {
        $form = $this->createFormBuilder()
            ->add('title', TextType::class, [
                'data' => 'Welcome!',
            ])
            ->add('content', TextareaType::class, [
                'data' => 'Work in progress...',
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Post update request on mercure HUB'
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $hub->publish(new Update(
                'my_topic_for_news',
                $this->renderView('pages/ux_turbo_stream_template.html.twig', [
                    'news' => [
                        'title'   => $data['title'],
                        'content' => $data['content'],
                    ]
                ])
            ));
        }

        return $this->render('pages/ux_turbo_stream_manager.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
