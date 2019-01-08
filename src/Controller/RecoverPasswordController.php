<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Service\DefaultValidator;

class RecoverPasswordController extends AbstractController
{
    private $defaultValidator;
    private $passwordEncoder;

    public function __construct(DefaultValidator $defaultValidator, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->defaultValidator = $defaultValidator;
        $this->passwordEncoder = $passwordEncoder;
    }



    /**
     * @Route("/api/recover-password", name="recover_password")
     */
    public function index(ObjectManager $manager, Request $request, \Swift_Mailer $mailer)
    {
        //Get the email

        $data = (array) json_decode($request->getContent());
        $email = $data["email"];


        if (!$email) {
            return new JsonResponse(
                [
                    'messageType' => 'error',
                    'message' => 'Por favor ingrese un email válido.',
                    'errors' => [],
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $user = $manager->getRepository(User::class)
        ->findOneBy(['email' => $email]);

        //If user does not exist, return error.

        if (!$user) {
            return new JsonResponse(
                [
                    'messageType' => 'error',
                    'message' => 'El email ' . $data["email"] .' no corresponde a ningún usuario.',
                    'errors' => [],
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $token = md5(uniqid());
        $user->setRecoveryCode($token);
        $manager->persist($user);
        $manager->flush();

        $message = (new \Swift_Message())
        ->setFrom("no-reply@pastock.com")
        ->setTo($user->getEmail())
        ->setBody(
"Buenas " . $user->getName() . " " . $user->getLastname() . "
        
Solicistaste un cambio de contraseña para paStock.

Por favor ingrese el siguiente código:
        
        "
        .  $token,
        'text/plain'
           
        )
       
        ;

        if ($mailer->send($message)) {
            return new JsonResponse(
                [
                'message' => 'Email enviado con éxito',
                'messageType' => 'success',
                'errors' => []

            ],
                JsonResponse::HTTP_OK
            );
        } else {
            return new JsonResponse(
                [
                'message' => 'Ha habido un error',
                'messageType' => 'error',
                'errors' => []

            ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
    }
    /**
     * @Route("/api/recover-password-code", name="recover_password_code")
     */
    public function getCode(Request $request, ObjectManager $manager)
    {
        //Get the code

        $data = (array) json_decode($request->getContent());
        $code = $data["code"];
        $email = $data["email"];
        

        $user = $manager->getRepository(User::class)
        ->findOneBy(['email' => $email]);

        //If user or recoveryCode does not exist, return error.

        if (!$user || $user->getRecoveryCode() === null) {
            return new JsonResponse(
                [
                    'messageType' => 'error',
                    'message' => 'Por favor vuelva a ingresar el email.',
                    'errors' => [],
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
        if (!$code) {
            return new JsonResponse(
                [
                'message' => 'Por favor introduzca un código válido.',
                'messageType' => 'error',
                'errors' => []

            ],
                JsonResponse::HTTP_OK
            );
        }

        if ($user->getRecoveryCode() === $code) {
            $user->setRecoveryCode(null);


            return new JsonResponse(
                [
                'message' => 'El código es correcto.',
                'messageType' => 'success',
                'errors' => []

            ],
                JsonResponse::HTTP_OK
            );
        } else {
            return new JsonResponse(
                [
                'message' => 'El código ingresado es incorrecto.',
                'messageType' => 'error',
                'errors' => []

            ],
                JsonResponse::HTTP_OK
            );
        }
    }
    /**
     * @Route("/api/recover-password-change", name="recover_password_change")
     */
    public function changePassword(Request $request, ObjectManager $manager)
    {
        $data = (array) json_decode($request->getContent());
        $code = $data["code"];
        $email = $data["email"];
        $password = $data["password"];

        $user = $manager->getRepository(User::class)
        ->findOneBy(['email' => $email]);

        $user->setPassword($password);

        //Valido la contraseña.
        $err = $this->defaultValidator->validar($user);

        if ($err) {
            return new JsonResponse($err, JsonResponse::HTTP_BAD_REQUEST);
        }

    

        //Codifico la contraseña del usuario.
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            $password
        ));

        //Reemplazo la vieja contraseña de $data con la codificada.
        $password = $user->getPassword();
        $data['password'] = $password;
        $manager->persist($user);
        $manager->flush();



        return new JsonResponse([
            'message' => '¡Contraseña modificada!',
            'messageType' => 'success',
            "errors" => []

        ]);
    }
}
