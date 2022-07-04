<?php

namespace App\Repository;

use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Image>
 *
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Image $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function search($tag, $provider = null)
    {
        $queryBuilder = $this->createQueryBuilder('i');

        $queryBuilder->innerJoin('i.tags', 't');
        $queryBuilder->andWhere('t.name LIKE :tag')
            ->setParameter('tag', '%'.$tag.'%');

        if ($provider) {
            $queryBuilder->innerJoin('i.provider', 'p');
            $queryBuilder->andWhere('p.name LIKE :provider')
                ->setParameter('provider', '%'.$provider.'%');
        }

        return $queryBuilder;
    }

}
