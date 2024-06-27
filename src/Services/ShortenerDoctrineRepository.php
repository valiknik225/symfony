<?php

namespace App\Services;

use App\Entity\Shortener;
use App\Entity\User;
use App\Repository\ShortenerRepository;
use App\Shortener\Exceptions\DataNotFoundException;
use App\Shortener\Interfaces\IShortenerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Monolog\Logger;
use Symfony\Bundle\SecurityBundle\Security;

class ShortenerDoctrineRepository implements IShortenerRepository
{
    /**
     * @var ShortenerRepository
     */
    protected ObjectRepository $repository;

    public function __construct(
        protected EntityManagerInterface $em,
        protected Security $security
    ) {
        $this->repository = $this->em->getRepository(Shortener::class);
    }

    public function getUrlByCode(string $code): string
    {
        if (is_null($entity = $this->getEntityByCode($code))) {
            throw new DataNotFoundException($code . ' is not exist');
        }
        return $entity->getUrl();
    }

    public function getCodeByUrl(string $url): string
    {
        if (is_null($entity = $this->getEntityByUrl($url))) {
            throw new DataNotFoundException($url . ' is not exist');
        }
        return $entity->getCode();
    }

    public function codeIsset(string $code): bool
    {
        return (bool)$this->getEntityByCode($code);
    }

    public function addNewUrl(string $code, string $url): void
    {
        /**
         * @var User $user
         */
        $user = $this->security->getUser();
        $entity = new Shortener($url, $code, $user);
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function getEntityByUrl(string $url): ?Shortener
    {
        return $this->repository->findOneBy(['url' => $url]);
    }

    public function getEntityByCode(string $code): ?Shortener
    {
        return $this->repository->findOneBy(['code' => $code]);
    }
}