<?php
namespace App\Service;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class DefaultValidator
{

    private $validator;
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validar($item)
    {
        //Valido el item.
        $err = $this->validator->validate($item);

        //Si me da errores, entonces por cada uno de ellos me dice qué campo (values) es el que tiene el error.
        if (count($err) > 0) {

            $errors = [];
            foreach ($err as $error) {

                $errors[] =
                    [
                    'value' => $error->getPropertyPath(),
                    'message' => $error->getMessage(),
                    'status' => 'error'
                ];
            }
            return [
                'messageType' => 'error',
                'message' => 'Ha habido un error.',
                'errors' => $errors,
            ];
        }

    }
}
