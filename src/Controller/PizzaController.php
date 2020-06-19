<?php

namespace App\Controller;

use App\Entity\Pizza;
use Doctrine\Persistence\ManagerRegistry;
use Library\CRUDBundle\CRUDBundle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class PizzaController extends CRUDBundle
{

    /**
     * @Route("/pizza", name="pizza")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PizzaController.php',
        ]);
    }

    /**
     * @Route("/pizza/all", methods={"GET"})
     */
    public function readPizza(Request $request){

        $jsonContent = $this->read();

        return new Response($jsonContent, Response::HTTP_OK);
    }

    /**
     * @Route("/pizza/new", methods={"POST"})
     */
    public function newPizza(Request $request){

        $pizza = new Pizza();
        $pizza->setingredient1($request->get('ingredient1'));
        $pizza->setingredient2($request->get('ingredient2'));
        $pizza->setingredient3($request->get('ingredient3'));
        $pizza->setingredient4($request->get('ingredient4'));
        $pizza->setingredient5($request->get('ingredient5'));
        $pizza->setName($request->get('name'));

        $jsonContent = $this->create($pizza);

        return new Response($jsonContent, Response::HTTP_OK);
    }

    /**
     * @Route("/pizza/edit", methods={"PUT"})
     */
    public function editPizza(Request $request){

        $pizza = new Pizza();
        $pizza->setIngredient1($request->get('ingredient1'));
        $pizza->setIngredient2($request->get('ingredient2'));
        $pizza->setIngredient3($request->get('ingredient3'));
        $pizza->setIngredient4($request->get('ingredient4'));
        $pizza->setIngredient5($request->get('ingredient5'));
        $pizza->setName($request->get('name'));

        $jsonContent = $this->update($pizza, $request->get("nameID"));

        return new Response($jsonContent, Response::HTTP_OK);
    }



    /**
     * @Route("/pizza/delete/{name}", methods={"DELETE"})
     */
    public function deletePizza(Request $request){

        $jsonContent = $this->delete($request->get('name'));

        return new Response($jsonContent, Response::HTTP_OK);
    }
}
