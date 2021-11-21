<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class UxTurboFormController extends AbstractController
{
    /**
     * @Route(path="/ux-turbo-form", name="ux_turbo_form")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class, [
                'required'    => true,
                'constraints' => [
                    new NotBlank(),
                    new NotNull(),
                    new Email(),
                    new Length(['min' => 5, 'max' => 100])
                ],
            ])
            ->add('submit', SubmitType::class)
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Submit form successful!');

            return $this->redirectToRoute('ux_turbo_form');
        }

        $response = new Response(null, $form->isSubmitted() ? 422 : 200);
            
        return $this->render('pages/ux_turbo_form.html.twig', [
            'form' => $form->createView(),
        ], $response);
    }
}
