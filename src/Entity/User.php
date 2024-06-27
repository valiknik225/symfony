<?php

namespace App\Entity;

use App\Interfaces\Auth\IPasswordAuthenticatable;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, IPasswordAuthenticatable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $password;

    public function __construct(
        #[ORM\Column(type: 'string', length: 180, unique: true)]
        private string              $email,
        string                      $password,
    )
    {
        $this->changePassword($password);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function isValidPassword(string $password): bool
    {
        $password = $this->hashPassword($password);
        return $this->password === $password;
    }

    public function changePassword(string $password): void
    {
        $this->password = $this->hashPassword($password);
    }

    public function hashPassword(string $password): string
    {
        return md5($password);
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }
}
