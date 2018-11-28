<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\DefaultValidator;
use App\Security\LoginFormAuthenticator;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/registration", name="registration")
     */
    public function register(LoginFormAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler, ObjectManager $manager, Request $request, DefaultValidator $defaultValidator)
    {
        //Convierto en ARRAY el usuario que venga del formulario.
        $data = (array) json_decode($request->getContent());

        //Inserto cada uno de los datos en variables.
        $username = $data['username'];
        $email = $data['email'];
        $password = $data['password'];

        //Creo el usuario.
        $user = new User();
        $user->setUserName($username);
        $user->setEmail($email);
        $user->setPassword($password);

        //Valido el usuario.
        $err = $defaultValidator->validar($user);
        if($err){
            return new JsonResponse ($err, JsonResponse::HTTP_BAD_REQUEST);
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

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($user);
            $manager->flush();

            // after validating the user and saving them to the database
            // authenticate the user and use onAuthenticationSuccess on the authenticator

            $guardHandler->authenticateUserAndHandleSuccess(
                $user,          // the User object you just created
                $request,
                $authenticator, // authenticator whose onAuthenticationSuccess you want to use
                'main'          // the name of your firewall in security.yaml
            );
            

            return new JsonResponse([
                'user' => [
                    'username' => $username, 'email' => $email, 'roles' => $user->getRoles(), 'id' =>$user->getId()
                ],
                'message' => '¡Registrado!',
                'messageType' => 'success',

            ]);

        } else {
            throw new JsonResponse(
                [
                    'message' => 'Hubo un error',
                    'messageType' => 'error',
                ]
            );

        }

    }
}
