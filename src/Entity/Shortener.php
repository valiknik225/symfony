<?php

namespace App\Entity;

use App\Repository\ShortenerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(ShortenerRepository::class)]
class Shortener
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    public function __construct(
        #[ORM\Column(length: 255)]
        protected string $url,
        #[ORM\Column(length: 10, unique: true)]
        protected string $code
    )
    {
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
}