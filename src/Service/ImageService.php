<?php

namespace App\Service;

use App\Entity\Image;
use App\Entity\Provider;
use App\Entity\Tag;
use App\Repository\ProviderRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;

class ImageService
{
    private $em;
    private $providerRepository;
    private $tagRepository;

    public function __construct(
        EntityManagerInterface $em,
        ProviderRepository $providerRepository,
        TagRepository $tagRepository
    ) {
        $this->em = $em;
        $this->providerRepository = $providerRepository;
        $this->tagRepository = $tagRepository;
    }

    public function save($path, $provider_name, $tags): Image
    {

        $provider = $this->providerRepository->findOneByName($provider_name);
        if (empty($provider)) {
            $provider = new Provider();
            $provider->setName($provider_name);
        }

        $image = new Image();
        $image->setPath($path);
        $image->setProvider($provider);

        foreach ($tags as $tag_label) {
            $tag = $this->tagRepository->findOneByName($tag_label);
            if (empty($tag)) {
                $tag = new Tag();
                $tag->setName($tag_label);
            }
            $image->addTag($tag);
        }

        $this->em->persist($image);
        $this->em->flush();

        return $image;
    }

}
