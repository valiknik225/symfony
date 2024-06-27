<?php

namespace App\Interfaces\Auth;

interface IUser
{
    public function getUserIdentifier(): string;
}