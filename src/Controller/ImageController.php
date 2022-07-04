<?php

namespace App\Controller;

use App\Requests\Base64ImageRequest;
use App\Requests\RemoteImageRequest;
use App\Requests\UploadImageRequest;
use App\Service\ImageService;
use App\Service\ImageUploadService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends AbstractFOSRestController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function addBase64ImageAction(
        Base64ImageRequest $request,
        ImageService $imageService,
        ImageUploadService $imageUploadService
    ) {
        $request->validate();

        $data = json_decode($request->getRequest()->getContent(), true);

        $base64_image = explode(',', $data['base64_image']);
        $file_content = base64_decode($base64_image[1]);

        $path = $imageUploadService->storeImage($file_content);

        $image = $imageService->save($path, $data['provider'], $data['tags']);

        return $this->handleView($this->view($image, Response::HTTP_CREATED));
    }

    public function addRemoteImageAction(
        RemoteImageRequest $request,
        ImageService $imageService,
        ImageUploadService $imageUploadService
    ) {
        $request->validate();

        $data = json_decode($request->getRequest()->getContent(), true);
        $copy = $data['copy'] ?? true;

        $path = $data['path'];
        if ($copy) {
            $file_content = file_get_contents($data['path']);
            $path = $imageUploadService->storeImage($file_content);
        }

        $image = $imageService->save($path, $data['provider'], $data['tags']);

        return $this->handleView($this->view($image, Response::HTTP_CREATED));
    }

    public function imageUploadAction(
        UploadImageRequest $request,
        ImageService $imageService,
        ImageUploadService $imageUploadService
    ) {
        $request->validate();

        /** @var UploadedFile $file */
        $file = $request->getRequest()->files->get('image');

        $path = $imageUploadService->storeImage($file->getContent());

        $provider = $request->getRequest()->get('provider');
        $tags = $request->getRequest()->get('tags');

        $image = $imageService->save($path, $provider, $tags);

        return $this->handleView($this->view($image, Response::HTTP_CREATED));
    }
}
