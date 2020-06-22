<?php

namespace Library\CRUDBundle;
use App\Entity\Pizza;
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

    function update($nameAUpdate, $entityManager){




        $entityManager->flush();

        return 'Updated';
    }

    function delete($name){
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Pizza::class)->findOneBy(['name' => $name]);
        $entityManager->remove($product);
        $entityManager->flush();
        return "ok";

    }



    function search($data){
        foreach ($data as $keys => $content){
            if ($keys === "type"){
                if(strpos($content, ',')){
                    $match = explode(',', $content);
                    $result = $this->getDoctrine()
                        ->getRepository(Pizza::class)
                        ->findBy(['name' => $match]);
                }else{
                    $result = $this->getDoctrine()
                        ->getRepository(Pizza::class)
                        ->findBy(['name' => $content]);
                }
            }
            if ($keys === "rating"){
                if(strstr($content, '[')){
                    $tmp = str_replace('[', '', $content );
                    $tmp2 = explode(',', $tmp);
                    $tmp3 = str_replace(']', '', $tmp2 );
                    if(mb_strpos($content, ',' )){
                        if(end($tmp3) == ''){

                            $entityManager = $this->getDoctrine()->getManager();
                            $queryBuilder = $entityManager->getRepository(Pizza::class)
                                ->createQueryBuilder('c');

                            $result = $queryBuilder->select('c')
                                ->where('c.id >= :value')
                                ->setParameter(':value', $tmp3[0])
                                ->getQuery()
                                ->getResult();

                        }elseif ($tmp3[0] == ''){
                            $sup = [];
                            for($i=0; $i<= end($tmp3); $i++) {
                                array_push($sup,$i);
                            }
                            $result = $this->getDoctrine()
                                ->getRepository(Pizza::class)
                                ->findBy(['id' => $sup]);

                        }else{
                            $entityManager = $this->getDoctrine()->getManager();

                            $queryBuilder = $entityManager->getRepository(Pizza::class)
                                ->createQueryBuilder('c');

                            $result = $queryBuilder->select('c')
                                ->where('c.id >= :value AND c.id <= :value2')
                                ->setParameter(':value', $tmp3[0])
                                ->setParameter(':value2',end($tmp3))
                                ->getQuery()
                                ->getResult();

                        }
                    }
                }elseif(strstr($content, ',')) {

                    $tmp=explode(',', $content);
                    $result = $this->getDoctrine()
                        ->getRepository(Pizza::class)
                        ->findBy(['id' => $tmp]);
                }else{
                    $result = $this->getDoctrine()
                        ->getRepository(Pizza::class)
                        ->findBy(['id' => $content]);
                }

            }
        }



        // $products = $query->getResult();

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($result, 'json');

        return $jsonContent;
    }
}