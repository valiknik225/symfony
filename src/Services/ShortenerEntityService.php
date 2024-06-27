<?php

namespace App\Services;

use App\Entity\Shortener;
use App\Repository\ShortenerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ShortenerEntityService
{
    /**
     * @var ShortenerRepository
     */
    protected EntityRepository $repository;
    public function __construct(
        EntityManagerInterface $entityManager,
    )
    {
        $this->repository = $entityManager->getRepository(Shortener::class);
    }

    public function getAllByUser(): array
    {
        return $this->repository->findAll();
    }
}