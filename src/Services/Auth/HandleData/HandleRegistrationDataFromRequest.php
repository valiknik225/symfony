<?php

namespace App\Services\Auth\HandleData;

use App\Entity\User;
use App\ValueObjects\RegistrationVO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\EmailValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HandleRegistrationDataFromRequest
{
    public function __construct()
    {
    }

    public function handle(Request $request): RegistrationVO
    {
        $firstname = $request->request->get('firstname');
        $lastname = $request->request->get('lastname');
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        $registrationVO = new RegistrationVO($firstname, $lastname, $email, $password);

//        if (count($errors) > 0) {
//            // Handle validation errors, e.g., throw an exception or return an error response
//            throw new \Exception((string) $errors);
//        }

        return $registrationVO;
    }
}
