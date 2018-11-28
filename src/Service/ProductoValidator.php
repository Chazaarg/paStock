<?php
namespace App\Service;

use App\Entity\Producto;
use App\Entity\Variante;
use App\Form\ProductoType;
use App\Form\VarianteType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductoValidator{

    private $validator;
    private $formFactory;
    public function __construct(ValidatorInterface $validator, $formFactory)
    {
        $this->validator = $validator;
        $this->formFactory = $formFactory;
    }
    
    public function validarProducto($data, $producto)
    {   
        $producto->setUpdatedAt(new \DateTime());

        //Ingreso al producto en un FORMTYPE para validarlo.   
        $form = $this->formFactory->create(ProductoType::class, $producto);

        //Submit data decodificada.
        $form->submit($data);

        //Inicializar las variables que contendrán el error.
        $errProducto = [];
        $errVariante = [];

        //Hasta ahora el producto es individual.
        $formGroup = "individual";

        //Si el producto tiene variantes...
        if(sizeOf($form->getData()->getVariantes()) > 0)
        {
            //Agarro las variantes ingresadas al formulario y les indexo el producto creado.
            foreach ($form->getData()->getVariantes() as $variante) {
                $variante->setProducto($producto);
            };

            //Valido las variantes directamente de lo que me venga de data.
            foreach ($data['variantes'] as $variante)
            {
                //Por cada variante, creo su objeto y lo ingreso en un FORMTYPE para validarlo. 
                $productoVariante = new Variante();
                $formVariante = $this->formFactory->create(VarianteType::class, $productoVariante);
                $formVariante->submit($variante);

                //Ingreso la validación en la variable de error 
                $errVariante[] = $this->validator->validate($productoVariante);

            }

            //Me aseguro de que en la variable errVariante no quede ningún array vacío en caso de no haber ningún error.
            
            //Que haya arrays vacíos me ayuda en el FrontEnd porque es igual a un INPUT que no se valida.

            $cantVariantes = count($errVariante);
            $sinError = 0;
            for ($i = 0; $i < $cantVariantes; $i++) {
                if (count($errVariante[$i]) === 0) {
                    $sinError++;
                }
            }
            if ($sinError === $cantVariantes) {
                for ($i = 0; $i < $cantVariantes; $i++) {
                    unset($errVariante[$i]);
                }
            }

            //En caso de que el producto tenga variantes, lo único que tengo que validar es el nombre del producto.
            $formGroup = null;

        }

        //Valido el producto en general. El formGroup determina si valido como producto individual o con variantes.
        $err = $this->validator->validate($producto,null,["Default",$formGroup]);

        //Si me da errores, entonces por cada uno de ellos me dice qué campo (values) es el que tiene el error.

        if(count($err) > 0 || count($errVariante) > 0){

            //Producto.
            foreach ($err as $error) {
                $errProducto[] = [
                    'value' => $error->getPropertyPath(),
                    'message' => $error->getMessage(),
                    'status' => 'error',
                ];
            }

            //Variantes.
            $errVariante_ = [];

            foreach ($errVariante as $error) {
                $variante = [];
                foreach ($error as $er) {
                    $variante[] = [
                        'value' => $er->getPropertyPath(),
                        'message' => $er->getMessage(),
                        'status' => 'error',
                    ];
                }
                $errVariante_[] = $variante;
            }

            return new JsonResponse(
                [
                    'messageType' => 'error',
                    'message' => 'Ha habido un error.',
                    'errors' => ['varianteError' => $errVariante_, 'productoError' => $errProducto],
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        if (false === $form->isValid()) {
            return new JsonResponse(
                [
                    'status' => 'error',
                ]
            );
        }







        
    }
}



?>