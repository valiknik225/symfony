<?php

namespace App\Interfaces\Auth;

interface IPasswordAuthenticatable
{
    public function changePassword(string $password): void;
    public function isValidPassword(string $password): bool;
}