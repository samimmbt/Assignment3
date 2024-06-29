<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController{
    
      #[Route('/delete-session', name:'delete_session')]
    public function deleteSession(Request $session): Response
    {
        $session->getSession()->clear();// Delete all session data
        return $this->redirectToRoute('app_main_page'); // Redirect to homepage after deleting session
    }
}