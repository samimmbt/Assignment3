<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/signIn', name: 'app_signIn')]
    public function signIn(): Response
    {
        return $this->render('user/signIn.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/', name: 'app_main_page')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        $logged = $session->get("logged");
        if(isset($logged) && !$logged){
           return $this->redirectToRoute('app_signIn');
        }else{
            return $this->render('base.html.twig',['isLogged'=>$logged] );
        }
    }
}
