<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login", name="login")
     */
    public function login(Request $request)
    {
        $user = $this->getUser();
        $roles = $user->getRoles();
        $name = $user->getName();
        $email = $user->getEmail();
        $id = $user->getID();

        $role = [];
        foreach ($roles as $rol) {
            $role += ['rol' => $rol];
        }

        // Call whatever methods you've added to your User class
        // For example, if you added a getFirstName() method, you can use that.
        return new JsonResponse(['id' => $id,'roles' => $role,  'email' => $email, 'username' => $name]);
    }

    /**
     * @Route("/api/user", name="user")
     */
    public function index()
    {
        // usually you'll want to make sure the user is authenticated first
            

        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if ($user === null) {
            return new JsonResponse(['user' => 'anonymous']);
        }

        $roles = $user->getRoles();
        $name = $user->getName();
        $lastname = $user->getLastname();
        $email = $user->getEmail();
        $id = $user->getID();

        $role = [];
        foreach ($roles as $rol) {
            $role += ['rol' => $rol];
        }

        // Call whatever methods you've added to your User class
        // For example, if you added a getFirstName() method, you can use that.
        return new JsonResponse(['id' => $id,'roles' => $role, 'email' => $email, 'username' => $name, "lastname" => $lastname]);
    }
    /**
     * @Route("/api/logout", name="app_logout")
     */
    public function logout()
    {
        return new JsonResponse(JsonResponse::HTTP_OK);
    }
}
