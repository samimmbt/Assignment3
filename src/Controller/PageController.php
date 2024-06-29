<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{

    #[Route('/signUp', name: 'app_signUp')]
    public function signUp(Request $request, LoggerInterface $logger, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $session = $request->getSession();
        $logged = $session->get("logged");

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && !$logged) {
            
            $user = $form->getData();
            # php bin/console dbal:run-sql "SELECT * FROM product"
            $entityManager->persist($user);
            $entityManager->flush();

            $session->set("logged", true);

            $logger->info($user->getfirstName() . " ," . $user->getLastName());

            return $this->redirectToRoute('app_main_page', ['is_logged' => true]);
        } else if ($logged) {
            return $this->redirectToRoute('app_main_page', ['is_logged' => true]);
        }

        return $this->render('user/signUp.html.twig', [
            'controller_name' => 'UserController',
            "is_logged" => $logged,
            'form' => $form->createView()
        ]);
    }

    #[Route('/logIn', name: 'app_logIn')]
    public function logIn(Request $request, LoggerInterface $logger): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $session = $request->getSession();
        $logged = $session->get("logged");

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && !$logged) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $form->getData();
            $session->set("logged", true);

            $logger->info($user->getfirstName() . " ," . $user->getLastName());
            return $this->redirectToRoute('app_main_page', ['is_logged' => true]);
        } else if ($logged) {
            return $this->redirectToRoute('app_main_page', ['is_logged' => true]);
        }

        return $this->render('user/logIn.html.twig', [
            'controller_name' => 'UserController',
            "is_logged" => $logged,
            'form' => $form->createView()
        ]);
    }

    #[Route('/home', name: 'app_main_page')]
    public function main(Request $request): Response
    {
        $session = $request->getSession();
        $logged = $session->get("logged");
        if (!isset($logged) && ($logged == false)) {

            return $this->redirectToRoute(
                'app_signUp',
                ["is_logged" => false]
            );
        } else {
            return $this->render('base.html.twig', ["is_logged" => $logged,]);
        }
    }

    #[Route('/', name: 'app_index_page')]
    public function index(Request $request): RedirectResponse
    {
        $session = $request->getSession();
        $logged = $session->get("logged");

        if (!isset($logged) && ($logged == false)) {

            return $this->redirectToRoute(
                'app_signUp',
                ["is_logged" => false]
            );
        } else if (isset($logged) && ($logged == true)) {

            return $this->redirectToRoute(
                'app_main_page',
                ["is_logged" => $logged,]
            );
        }
    }
}
