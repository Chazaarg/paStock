<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Security\LoginFormAuthenticator;
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
     * @Route("/registration", name="registration")
     */
    public function register(LoginFormAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler, ObjectManager $manager, Request $request)
    {
        $data = (array) json_decode($request->getContent());
        $username = $data['username'];
        $email = $data['email'];
        $password = $data['password'];

        $user = new User();
        $user->setUserName($username);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            $password
        ));
        $user->setEmail($email);
        $data['password'] = $user->getPassword();
        $form = $this->createForm(UserType::class, $user);

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($user);
            $manager->flush();

            // after validating the user and saving them to the database
            // authenticate the user and use onAuthenticationSuccess on the authenticator
            return new JsonResponse([
                'user' => [
                    'username' => $username, 'email' => $email
                ],
                'message' => '¡Registrado!',
                'messageType' => 'success'
                
            ]);

        } else {
            throw new JsonResponse(
                [
                    'message' => 'Hubo un error',
                    'messageType' => 'error'
                ]
            );

        }

    }
}
