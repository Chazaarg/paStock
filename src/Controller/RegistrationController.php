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
    public function register(LoginFormAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler, ObjectManager $manager, Request $request, ValidatorInterface $validator)
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

        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */

           
            
             $values = [];
             foreach ($errors as $error){
                $values[] = $error->getPropertyPath();
             }
           
            $errorsString = $errors[0]->getMessage();

         



            return new JsonResponse(
                [
                    'status' => 'error',
                    'errors' => $errorsString,
                    'values' => $values
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );

        }

        $form = $this->createForm(UserType::class, $user);

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($user);
            $manager->flush();

            // after validating the user and saving them to the database
            // authenticate the user and use onAuthenticationSuccess on the authenticator
            return new JsonResponse([
                'user' => [
                    'username' => $username, 'email' => $email,
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
