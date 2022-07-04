<?php

namespace App\Controller;

use App\Entity\Image;
use App\Repository\ImageRepository;
use App\Requests\SearchRequest;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends AbstractFOSRestController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function indexAction(SearchRequest $request, ImageRepository $repository, PaginatorInterface $paginator)
    {
        $request->validate();

        $data = $request->data();

        $queryBuilder = $repository->search($data['tag'], $data['provider']);

        $pagination = $paginator->paginate($queryBuilder->getQuery(), $data['page'], $data['limit']);
        $result = [
            'items' => $pagination->getItems(),
            'meta' => $pagination->getPaginationData(),
        ];

        $view = $this->view($result, Response::HTTP_OK);
        $view->getContext()->setGroups(['image_search']);

        return $this->handleView($view);
    }

}
