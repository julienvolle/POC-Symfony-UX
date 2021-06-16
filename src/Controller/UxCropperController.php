<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Cropperjs\Factory\CropperInterface;
use Symfony\UX\Cropperjs\Form\CropperType;

class UxCropperController extends AbstractController
{
    public const UPLOAD_PATH_SERVER = __DIR__ . '/../../public/upload/';
    public const UPLOAD_PATH_PUBLIC = 'http://localhost:8080/upload/';

    /**
     * @Route(path="/ux-cropper", name="ux_cropper")
     *
     * @param CropperInterface $cropper
     * @param Request          $request
     *
     * @return Response
     */
    public function __invoke(CropperInterface $cropper, Request $request): Response
    {
        $filename = [
            'original'  => ['name' => '366-1920x1080.jpg', 'width' => 1920, 'height' => 1080],
            'cropped'   => ['name' => '366-500x500.jpg',   'width' => 500,  'height' => 500],
            'thumbnail' => ['name' => '366-50x50.jpg',     'width' => 75,   'height' => 75],
        ];

        $crop = $cropper
            ->createCrop($this->getPath($filename['original']['name']))
            ->setCroppedMaxSize($filename['cropped']['width'], $filename['cropped']['height'])
        ;

        $form = $this->createFormBuilder(['crop' => $crop])
            ->add('crop', CropperType::class, [
                'public_url'   => $this->getPath($filename['original']['name'], true),
                'aspect_ratio' => (float) $filename['cropped']['width'] / $filename['cropped']['height'],
            ])
            ->add('save', SubmitType::class, ['label' => 'Save'])
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Save the cropped image
            $this->save($filename['cropped']['name'], $crop->getCroppedImage());

            // Save a thumbnail of the cropped image
            $this->save($filename['thumbnail']['name'], $crop->getCroppedThumbnail(
                $filename['thumbnail']['width'],
                $filename['thumbnail']['height']
            ));
        }

        return $this->render('pages/ux_cropper.html.twig', [
            'form'      => $form->createView(),
            'cropped'   => $this->getPath($filename['cropped']['name'], true),
            'thumbnail' => $this->getPath($filename['thumbnail']['name'], true),
        ]);
    }

    /**
     * @param string $filename
     * @param bool   $external
     *
     * @return string|null
     */
    private function getPath(string $filename, bool $external = false): ?string
    {
        $filesystem = new Filesystem();

        if (!$filesystem->exists(self::UPLOAD_PATH_SERVER . $filename)) {
            return null;
        }

        return ($external ? self::UPLOAD_PATH_PUBLIC : self::UPLOAD_PATH_SERVER) . $filename;
    }

    /**
     * @param string $filename
     * @param string $data
     */
    private function save(string $filename, string $data): void
    {
        $filesystem = new Filesystem();

        $path = self::UPLOAD_PATH_SERVER . $filename;

        if ($filesystem->exists($path)) {
            $filesystem->remove($path);
        }

        $filesystem->appendToFile($path, $data);
    }
}
