<?php

namespace App\Interfaces\Auth;

use App\ValueObjects\PasswordLoginVO;

interface ICanLoginForPass
{
    public function login(PasswordLoginVO $loginVO): void;
}