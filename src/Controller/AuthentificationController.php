<?php

namespace App\Controller;
use App\Entity\User;
use Library\AuthentificationBundle\AuthentificationBundle;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthentificationController extends AuthentificationBundle
{
    /**
     * @Route("/auth", name="authentification")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AuthentificationController.php',
        ]);
    }

    /**
     * @Route("/login", name="login", methods={"GET"})
     */
    public function loginAuth(Request $request)
    {
        $email = $request->get('_username');
        $password = $request->get('_password');
        $jsonContent =  $this->loginAuthentification($email, $password);

        return new Response($jsonContent, Response::HTTP_OK);

    }

    /**
     * @Route("/register", name="security_register", methods={"POST"})
     */
    public function registerAuth(Request $request)
    {
        $email = $request->get('_username');
        $password = $request->get('_password');
     //   $hash = password_hash($password, PASSWORD_BCRYPT);

        $jsonContent =  $this->registerAuthentification($email, $password);

        return new Response($jsonContent, Response::HTTP_OK);

    }
}
