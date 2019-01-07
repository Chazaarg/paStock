<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Security\LoginFormAuthenticator;
use App\Service\DefaultValidator;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/api/registration", name="registration")
     */
    public function register(LoginFormAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler, ObjectManager $manager, Request $request, DefaultValidator $defaultValidator)
    {
        //Convierto en ARRAY el usuario que venga del formulario.
        $data = (array) json_decode($request->getContent());

        //Inserto cada uno de los datos en variables.
        $name = $data['name'];
        $lastname = $data['lastname'];
        $email = $data['email'];
        $password = $data['password'];
        $passwordVerifyIsValid = $data['passwordVerifyIsValid'];
       

        //Creo el usuario.
        $user = new User();
        $user->setName($name);
        $user->setLastname($lastname);
        $user->setEmail($email);
        $user->setPassword($password);

        //Antes que nada verifico que las contraseñas ingresadas coincidan.
        $passVerifyFullErr = null;
        $passVerifyErr = null;

        if (!$passwordVerifyIsValid) {
            //Este array es para acumularlo junto con otros errores.
            $passVerifyErr = [
                "value" => "passwordRepeat",
                "message" => "La contraseña ingresada no coincide.",
                "status" => "error",
            ];
            //Este array es por si no hay otros errores.
            $passVerifyFullErr = [
                'messageType' => 'error',
                'message' => 'Ha habido un error.',
                'errors' => [$passVerifyErr],
            ];
        }

        //Valido el usuario.
        $err = $defaultValidator->validar($user);
        if ($err) {

            //Si hay más errores, entonces acumulo el error de la verificación de contraseña, si es que está.
            if ($passVerifyErr) {
                array_push($err['errors'], $passVerifyErr);
            }

            return new JsonResponse($err, JsonResponse::HTTP_BAD_REQUEST);
        } elseif ($passVerifyErr) {

            //Si no hay más errores, entonces devuelvo solamente el error de verificación de contraseña.
            return new JsonResponse($passVerifyFullErr, JsonResponse::HTTP_BAD_REQUEST);
        }

        //Codifico la contraseña del usuario.
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            $password
        ));
        
        //Reemplazo la vieja contraseña de $data con la codificada.
        $password = $user->getPassword();
        $data['password'] = $password;

        $form = $this->createForm(UserType::class, $user);
        //Saco el verifypassword antes de hacer el submit.
        $data = array_slice($data, 0, 4);
        
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();
            //TODO: Si quisiese confirmar el EMAIL. Lo haría acá.
            // after validating the user and saving them to the database
            // authenticate the user and use onAuthenticationSuccess on the authenticator

            $guardHandler->authenticateUserAndHandleSuccess(
                $user, // the User object you just created
                $request,
                $authenticator, // authenticator whose onAuthenticationSuccess you want to use
                'main' // the name of your firewall in security.yaml
            );

            return new JsonResponse([
                'user' => [ 'username' => $name . " " . $lastname,'email' => $email, 'roles' => $user->getRoles(), 'id' => $user->getId(),
                ],
                'message' => '¡Registrado!',
                'messageType' => 'success',

            ]);
        } else {
            return new JsonResponse(
                [
                    'message' => 'Hubo un error',
                    'messageType' => 'error',
                ]
            );
        }
    }
}
