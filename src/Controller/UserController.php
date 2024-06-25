<?php
namespace Assignment3\Src\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController{
#[Route('/signin')]
    public function Sign() : Response
    {
        return $this->render('SignIn.html.twing',[]);
    }
}
