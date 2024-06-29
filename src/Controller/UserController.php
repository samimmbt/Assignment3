<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/signIn', name: 'app_signIn')]
    public function signIn(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $session = $request->getSession();
        $logged = $session->get("logged");

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            

            return $this->redirectToRoute('task_success');
        }

        return $this->render('user/signIn.html.twig', [
            'controller_name' => 'UserController',
            "is_logged" => $logged,
            'form' => $form->createView()
        ]);
    }

    #[Route('/home', name: 'app_main_page')]
    public function main(Request $request): Response{
        $session = $request->getSession();
        $logged = $session->get("logged");

        return $this->render('base.html.twig', ["is_logged" => $logged,]);  
    }

    #[Route('/', name: 'app_index_page')]
    public function index(Request $request): RedirectResponse
    {
        $session = $request->getSession();
        $logged = $session->get("logged");

        if (!isset($logged) && ($logged == false)) {

            return $this->redirectToRoute('app_signIn',
             ["is_logged" => false]);

        } else if (isset($logged) && ($logged == true)) {

            return $this->redirectToRoute('app_main_page',
             ["is_logged" => $logged,]);

        }
    }
}
