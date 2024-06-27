<?php

namespace App\Interfaces\Auth;

interface IPasswordAuthenticatable
{
    public function changePassword(): void;
    public function isValidPassword(string $password): bool;
}