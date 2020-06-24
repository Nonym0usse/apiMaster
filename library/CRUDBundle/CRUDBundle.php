<?php

namespace Library\CRUDBundle;
use App\Entity\Pizza;
use App\Repository;
use DateTime;
use Doctrine\ORM\EntityManager;
use ReflectionClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\PizzaController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as abs;
class CRUDBundle extends AbstractController {

    function getClassName(){

        $reflection = new ReflectionClass(get_called_class());
       $reflection = $reflection->getConstant('repository');
        return $reflection;
    }


    function create($data){
        $product = $this->getDoctrine()->getManager();
        $product->persist($data);
        $product->flush();

        return 'Created';

    }

    function read(){

        $repo = $this->getClassName();
        $product = $this->getDoctrine()
            ->getRepository($repo)
            ->findAll();

        $this->getClassName();
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
        $repo = $this->getClassName();
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository($repo)->findOneBy(['name' => $name]);
        $entityManager->remove($product);
        $entityManager->flush();
        return "ok";

    }



    function filter($data){
        $repo = $this->getClassName();
        foreach ($data as $keys => $content){
            if ($keys === "type"){
                if(strpos($content, ',')){
                    $match = explode(',', $content);
                    $result = $this->getDoctrine()
                        ->getRepository($repo)
                        ->findBy(['name' => $match]);
                }else{
                    $result = $this->getDoctrine()
                        ->getRepository($repo)
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
                            $queryBuilder = $entityManager->getRepository($repo)
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
                                ->getRepository($repo)
                                ->findBy(['id' => $sup]);

                        }else{
                            $entityManager = $this->getDoctrine()->getManager();

                            $queryBuilder = $entityManager->getRepository($repo)
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
                        ->getRepository($repo)
                        ->findBy(['id' => $tmp]);
                } else{
                    $result = $this->getDoctrine()
                        ->getRepository($repo)
                        ->findBy(['id' => $content]);
                }

            }

            if($keys == 'createdat'){
                $tmp = str_replace('[', '', $content );
                $tmp2 = explode(',', $tmp);
                $tmp3 = str_replace(']', '', $tmp2 );
                if(strstr($content, '[')) {
               if(strpos($content, ',')){
                     if($tmp3[0] == ''){
                         $entityManager = $this->getDoctrine()->getManager();
                         $queryBuilder = $entityManager->getRepository($repo)
                             ->createQueryBuilder('c');

                         $result = $queryBuilder->select('c')
                             ->where('c.createdat <= :value')
                             ->setParameter(':value', end($tmp3))
                             ->getQuery()
                             ->getResult();
                        //faire requete inferieur ou égale à la date
                    }elseif(end($tmp3) == ''){

                        $entityManager = $this->getDoctrine()->getManager();
                        $queryBuilder = $entityManager->getRepository($repo)
                            ->createQueryBuilder('c');

                        $result = $queryBuilder->select('c')
                            ->where('c.createdat >= :value')
                            ->setParameter(':value', $tmp3[0])
                            ->getQuery()
                            ->getResult();
                        //faire requete superieur ou égle à la date
                    }else{
                         $entityManager = $this->getDoctrine()->getManager();

                         $queryBuilder = $entityManager->getRepository($repo)
                             ->createQueryBuilder('c');

                         $result = $queryBuilder->select('c')
                             ->where('c.createdat >= :value AND c.createdat <= :value2')
                             ->setParameter(':value', $tmp3[0])
                             ->setParameter(':value2',end($tmp3))
                             ->getQuery()
                             ->getResult();
                         //rechercher etre les valeurs de tmp3[0] et end de tmp3
                     }

                    }
                }
                }elseif(strpos($content, ',')){

                    $entityManager = $this->getDoctrine()->getManager();
                    $result = $entityManager->getRepository($repo)->findBy(['createdat' => $tmp3]);


                }else{
                    $tmp = str_replace('/', '-', $content);
                    $entityManager = $this->getDoctrine()->getManager();
                    $result = $entityManager->getRepository($repo)->findBy(['createdat' => $tmp]);

                }
            }


        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($result, 'json');

        return $jsonContent;
    }
}