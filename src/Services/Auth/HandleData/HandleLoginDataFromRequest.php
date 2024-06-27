<?php

namespace App\Services\Auth\HandleData;

use App\ValueObjects\PasswordLoginVO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HandleLoginDataFromRequest
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function handle(Request $request): PasswordLoginVO
    {
        $identificator = $request->request->get('email');
        $password = $request->request->get('password');

        $loginVO = new PasswordLoginVO($identificator, $password);

        $errors = $this->validator->validate($loginVO);
        if (count($errors) > 0) {
            // Handle validation errors, e.g., throw an exception or return an error response
            throw new \Exception((string) $errors);
        }

        return $loginVO;
    }
}
