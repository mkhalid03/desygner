<?php

namespace App\Controller;

use App\Entity\Bookmark;
use App\Repository\BookmarkRepository;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookmarkController extends AbstractFOSRestController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createAction(Request $request, ImageRepository $repository, BookmarkRepository $bookmarkRepository)
    {
        $image = $repository->find($request->get('image_id'));
        if (!$image) {
            throw new NotFoundHttpException('Requested image does not exist');
        }

        $bookmark = $bookmarkRepository->findOneBy([
            'user' => $this->getUser(),
            'image' => $image,
        ]);

        if ($bookmark) {
            return $this->view([
                'message' => 'User already bookmarked image',
            ], Response::HTTP_CONFLICT);
        }

        $bookmark = new Bookmark();
        $bookmark->setImage($image);
        $bookmark->setUser($this->getUser());

        $this->em->persist($bookmark);
        $this->em->flush();

        return $this->handleView($this->view($bookmark, Response::HTTP_CREATED));
    }

}
