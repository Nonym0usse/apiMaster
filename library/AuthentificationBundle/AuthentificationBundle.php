<?php

namespace Library\AuthentificationBundle;
use App\Entity\Pizza;
use App\Entity\User;
use App\Repository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\PizzaController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as abs;
use Symfony\Component\HttpFoundation\Session\Session;

class AuthentificationBundle extends AbstractController {

    public function loginAuthentification($email, $password){
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email, 'password' => $password]);
        if($user != NULL){
            $session = new Session();
            $session->start();

// set and get session attributes
            $session->set('name', $email);
            $session->get('name');

            return 'Vous êtes à présent connecté';
        }else{
            return "Une erreur s'est produite";        }
    }

    public function registerAuthentification($email, $password){
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($password);
        $product = $this->getDoctrine()->getManager();
        $product->persist($user);
        $product->flush();

        return 'Created';
    }
}