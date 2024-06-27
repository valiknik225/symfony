<?php

namespace App\Services;

use App\Interfaces\IIncrementor;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

class IncrementorService
{

    public function __construct(
        protected EntityManagerInterface $em
    ) {}

    public function incrementAndSave(IIncrementor $object): void
    {
        $object->increment();
        try {
            $this->em->persist($object);
            $this->em->flush();
        } catch (Throwable) {}
    }
}