<?php

namespace App\Entity;

use App\Interfaces\IIncrementor;
use App\Repository\ShortenerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(ShortenerRepository::class)]
class Shortener implements IIncrementor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $count = 0;

    public function __construct(
        #[ORM\Column(length: 255)]
        protected string $url,
        #[ORM\Column(length: 10, unique: true)]
        protected string $code,
        #[ORM\ManyToOne(targetEntity: User::class, fetch: 'LAZY')]
        #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
        private User $user,
    )
    {
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return static
     */
    public function incrementCount(): static
    {
        $this->count++;
        return $this;
    }

    public function increment(): void
    {
        $this->incrementCount();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}