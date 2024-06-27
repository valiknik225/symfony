<?php

namespace App\ValueObjects;

class PasswordLoginVO
{
    public function __construct(
        protected string|int $identificator,
        protected string $password
    )
    {
    }

    public function getIdentificator(): int|string
    {
        return $this->identificator;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

}