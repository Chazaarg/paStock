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

            //Desde contact.js, los inputs vienen en este formato: children[name].data. Este switch es una solución rápida a eso.
            foreach ($err as $error) {
                $fixedValue = null;
                switch ($error->getPropertyPath()) {
                    case 'children[name].data':
                    $fixedValue = 'name';
                        break;
                    case 'children[email].data':
                    $fixedValue = 'email';
                        break;
                    case 'children[message].data':
                    $fixedValue = 'message';
                        break;
                    
                    default:
                    $fixedValue = $error->getPropertyPath();
                        break;
                }
                $errors[] =
                    [
                    'value' => $fixedValue,
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
