<?php

namespace Library\CRUDBundle;
use App\Entity\Pizza;
use App\Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\PizzaController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as abs;
class CRUDBundle extends AbstractController {

    function create($data){
        $product = $this->getDoctrine()->getManager();
        $product->persist($data);
        $product->flush();

        return 'Created';

    }

    function read(){
        $product = $this->getDoctrine()
            ->getRepository(Pizza::class)
            ->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($product, 'json');

        return $jsonContent;
    }

    function update($data, $nameAUpdate){
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Pizza::class)->findBy(['name' => $nameAUpdate]);
        $entityManager->persist($product);
        $entityManager->flush();

        return 'Updated';
    }

    function delete($name){
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($name);
        $entityManager->flush();
        return "ok";

    }
}