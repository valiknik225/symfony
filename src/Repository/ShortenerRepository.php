<?php

namespace App\Repository;

use App\Entity\Shortener;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @method Shortener|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shortener|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shortener[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShortenerRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        protected Security $security
    )
    {
        parent::__construct($registry, Shortener::class);
    }

    /**
     * @return Shortener[]
     */
    public function findAll(): array
    {
        return $this->findBy(['user' => $this->security->getUser()]);
    }

}
