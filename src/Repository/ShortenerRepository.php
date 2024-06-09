<?php

namespace App\Repository;

use App\Entity\Shortener;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Shortener|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shortener|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shortener[] findAll()
 * @method Shortener[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShortenerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shortener::class);
    }

}
