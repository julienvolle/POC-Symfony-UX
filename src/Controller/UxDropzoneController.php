<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Dropzone\Form\DropzoneType;

class UxDropzoneController extends AbstractController
{
    /**
     * @Route(path="/ux-dropzone", name="ux_dropzone")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('upload', DropzoneType::class)
            ->add('submit', SubmitType::class, ['label' => 'Submit'])
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $upload = $form->get('upload')->getData();
            $publicUrl = $this->save($upload);
        }

        return $this->render('pages/ux_dropzone.html.twig', [
            'form' => $form->createView(),
            'publicUrl' => $publicUrl ?? null,
        ]);
    }

    /**
     * @param UploadedFile $upload
     *
     * @return string|null
     */
    private function save(UploadedFile $upload): ?string
    {
        $filename = $upload->getClientOriginalName();
        $path = __DIR__ . '/../../public/upload/';

        try {
            $filesystem = new Filesystem();
            if ($filesystem->exists($path . $filename)) {
                $filesystem->remove($path . $filename);
            }
            $upload->move($path, $filename);
        } catch (FileException $exception) {
            return null;
        }

        return 'http://localhost:8080/upload/' . $filename;
    }
}
