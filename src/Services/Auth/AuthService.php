<?php

namespace App\Services\Auth;

use App\Entity\User;
use App\Interfaces\Auth\ICanLoginForPass;
use App\ValueObjects\PasswordLoginVO;
use App\ValueObjects\RegistrationVO;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Exception;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthService implements ICanLoginForPass
{
    protected EntityRepository $repository;

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface      $em,
    )
    {
        $this->repository = $this->em->getRepository(User::class);
    }

    /**
     * @throws Exception
     */
    public function login(PasswordLoginVO $loginVO): void
    {
        $user = $this->findUserByIdentificator($loginVO->getIdentificator());
        if (!$user || !$user->isValidPassword($loginVO->getPassword(), $this->passwordHasher)) {
            throw new Exception('Invalid credentials');
        }
    }

    public function register(RegistrationVO $registrationVO): void
    {
        $user = new User(
            $registrationVO->getFirstname(),
            $registrationVO->getLastname(),
            $registrationVO->getEmail(),
            $registrationVO->getPassword(),
            $this->passwordHasher
        );

        $this->em->persist($user);
        $this->em->flush();
    }

    private function findUserByIdentificator(string $identificator): ?User
    {
        return $this->repository->findOneByEmail($identificator);
    }
}
